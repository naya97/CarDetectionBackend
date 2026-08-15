<?php

namespace App\Services\Detection;

use App\Models\Detection;
use App\Models\Vehicle;
use App\Models\Video;

class DetectionProcessingService
{
    public function processVehicle(array $aiVehicle, Video $video): Detection
    {
        if (isset($aiVehicle['color'])) {
            $aiVehicle['color'] = $this->translateColor($aiVehicle['color']);
        }

        $vehicle = $this->matchVehicleByPlate($aiVehicle['plate_number'] ?? null);

        $blacklistViolation = $this->checkBlacklistViolation($vehicle);

        $specMismatches = $this->compareVehicleSpecifications($aiVehicle, $vehicle);

        $result = $this->aggregateViolationResult(
            $aiVehicle,
            $vehicle,
            $blacklistViolation,
            $specMismatches
        );

        $detection = new Detection([
            'video_id' => $video->id,
            'vehicle_id' => $vehicle?->id,
            'track_id' => $aiVehicle['track_id'],
            'detected_plate_number' => $aiVehicle['plate_number'] ?? null,
            'plate_confidence' => $aiVehicle['plate_confidence'] ?? null,
            'detected_model' => $aiVehicle['model'] ?? null,
            'model_confidence' => $aiVehicle['make_model_confidence'] ?? null,
            'detected_type' => $aiVehicle['type'] ?? null,
            'type_confidence' => $aiVehicle['type_confidence'] ?? null,
            'detected_color' => $aiVehicle['color'] ?? null,
            'color_confidence' => $aiVehicle['color_confidence'] ?? null,
            'vehicle_image_path' => $aiVehicle['vehicle_image_path'] ?? null,
            'plate_match' => $vehicle !== null,
            'color_mismatch' => $specMismatches['color'] ?? false,
            'type_mismatch' => $specMismatches['type'] ?? false,
            'model_mismatch' => $specMismatches['model'] ?? false,
            'plate_mismatch' => $blacklistViolation['plate_mismatch'] ?? false,
            'risk_score' => $result['risk_score'],
            'severity' => $result['severity'],
            'violation_type' => $result['violation_type'],
            'message' => $result['message'],
            'detected_at' => now(),
        ]);

        $detection->save();

        return $detection;
    }

    private function translateColor(?string $color): ?string
    {
        if (empty($color)) {
            return null;
        }

        $colorsMap = [
            'beige'  => 'بيج',
            'black'  => 'أسود',
            'blue'   => 'أزرق',
            'brown'  => 'بني',
            'gold'   => 'ذهبي',
            'green'  => 'أخضر',
            'grey'   => 'رمادي',
            'orange' => 'برتقالي',
            'pink'   => 'زهري',
            'purple' => 'بنفسجي',
            'red'    => 'أحمر',
            'silver' => 'فضي',
            'tan'    => 'بني فاتح',
            'white'  => 'أبيض',
            'yellow' => 'أصفر',
        ];

        $lowerColor = strtolower(trim($color));

        return $colorsMap[$lowerColor] ?? $color;
    }

    public function matchVehicleByPlate(?string $plateNumber): ?Vehicle
    {
        if (empty($plateNumber)) {
            return null;
        }

        return Vehicle::where('plate_number', $plateNumber)->first();
    }

    public function checkBlacklistViolation(?Vehicle $vehicle): array
    {
        if ($vehicle === null) {
            return [
                'is_wanted' => false,
                'plate_mismatch' => false,
                'priority' => null,
                'status' => null,
            ];
        }

        $latestBlacklist = $vehicle->latestBlacklist;

        if ($latestBlacklist === null) {
            return [
                'is_wanted' => false,
                'plate_mismatch' => false,
                'priority' => null,
                'status' => null,
            ];
        }

        return [
            'is_wanted' => $latestBlacklist->wanted,
            'plate_mismatch' => $latestBlacklist->wanted,
            'priority' => $latestBlacklist->priority,
            'status' => $latestBlacklist->status,
        ];
    }

    public function compareVehicleSpecifications(array $aiVehicle, ?Vehicle $vehicle): array
    {
        if ($vehicle === null) {
            return [
                'color' => false,
                'type' => false,
                'model' => false,
            ];
        }

        $colorMismatch = $this->isMismatch(
            $aiVehicle['color'] ?? null,
            $vehicle->color,
            $aiVehicle['color_confidence'] ?? 0
        );

        $typeMismatch = $this->isMismatch(
            $aiVehicle['type'] ?? null,
            $vehicle->type,
            $aiVehicle['type_confidence'] ?? 0
        );

        $modelMismatch = $this->isMismatch(
            $aiVehicle['model'] ?? null,
            $vehicle->model,
            $aiVehicle['make_model_confidence'] ?? 0
        );

        return [
            'color' => $colorMismatch,
            'type' => $typeMismatch,
            'model' => $modelMismatch,
        ];
    }

    public function aggregateViolationResult(
        array $aiVehicle,
        ?Vehicle $vehicle,
        array $blacklistViolation,
        array $specMismatches
    ): array {
        $colorWeight = 1;
        $typeWeight = 3;
        $modelWeight = 4;

        $colorConf = $aiVehicle['color_confidence'] ?? 0;
        $typeConf = $aiVehicle['type_confidence'] ?? 0;
        $modelConf = $aiVehicle['make_model_confidence'] ?? 0;

        $score = 0;

        if ($specMismatches['color'] && $colorConf >= 0.50) {
            $score += $colorConf * $colorWeight;
        }
        if ($specMismatches['type'] && $typeConf >= 0.50) {
            $score += $typeConf * $typeWeight;
        }
        if ($specMismatches['model'] && $modelConf >= 0.50) {
            $score += $modelConf * $modelWeight;
        }

        $severity = null;
        $violationType = null;
        $message = null;

        if ($blacklistViolation['is_wanted']) {
            $severity = 'عالي';
            $violationType = 'مطلوب بالقائمة السوداء';
            $message = 'تم مطابقة لوحة المركبة مع مركبة موجودة في القائمة السوداء';
        } elseif ($score >= 4) {
            $severity = 'عالي';
            $violationType = 'عدم تطابق مواصفات المركبة';
            $message = $this->buildMismatchMessage($specMismatches);
        } elseif ($score >= 2) {
            $severity = 'متوسط';
            $violationType = 'عدم تطابق مواصفات المركبة';
            $message = $this->buildMismatchMessage($specMismatches);
        } elseif ($score > 0) {
            $severity = 'منخفض';
            $violationType = 'عدم تطابق مواصفات المركبة';
            $message = $this->buildMismatchMessage($specMismatches);
        }

        return [
            'risk_score' => round($score, 2),
            'severity' => $severity,
            'violation_type' => $violationType,
            'message' => $message,
        ];
    }

    private function isMismatch(?string $aiValue, ?string $dbValue, float $confidence): bool
    {
        if (empty($dbValue) || empty($aiValue)) {
            return false;
        }

        if (strtolower($aiValue) === 'unknown') {
            return false;
        }

        if ($confidence < 0.50) {
            return false;
        }

        return strtolower(trim($aiValue)) !== strtolower(trim($dbValue));
    }

    private function buildMismatchMessage(array $specMismatches): string
    {
        $parts = [];

        if ($specMismatches['color']) {
            $parts[] = 'اللون';
        }
        if ($specMismatches['type']) {
            $parts[] = 'النوع';
        }
        if ($specMismatches['model']) {
            $parts[] = 'الموديل';
        }

        if (empty($parts)) {
            return 'مواصفات المركبة المرصودة تختلف عن بيانات المركبة المسجلة.';
        }

        $last = array_pop($parts);

        if (empty($parts)) {
            return $last . ' المرصود يختلف عن بيانات المركبة المسجلة.';
        }

        return implode('، ', $parts) . ' و' . $last . ' المرصودة تختلف عن بيانات المركبة المسجلة.';
    }
}
