<?php

namespace App\Filament\Pages;

use App\Models\Data\JenisEvaluasi;
use App\Models\Ahp as AhpModel;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use App\Enums\BobotEnum;

class Ahp extends Page
{
    protected static ?string $navigationIcon = null;
    protected static ?string $navigationLabel = 'Analisis Kriteria';
    protected static ?string $navigationGroup = 'Matriks';
    protected static ?int $navigationSort = 0;
    protected static ?string $title = 'Analisis Kriteria';
    protected static ?string $slug = 'matriks/kriteria';
    protected static string $view = 'filament.pages.ahp';

    public array|Collection $listJenisEvaluasi = [];
    public array $inputValues = [];
    public array $normalizedValues = [];
    public array $priorityWeights = [];
    public array $consistencyMeasures = [];
    public float $lambdaMax = 0;
    public float $consistencyIndex = 0;
    public float $consistencyRatio = 0;
    public float $ratioIndex = 0;
    public string $consistencyStatus = 'Tidak Konsisten';

    public int $selectedBobot = 1; // Default selected bobot

    private static array $ratioIndexes = [
        1 => 0,
        2 => 0,
        3 => 0.58,
        4 => 0.9,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
    ];

    public function mount(): void
    {
        $this->listJenisEvaluasi = JenisEvaluasi::all();
        $this->initializeMatrix();
        $this->fillData();
        $this->calculateNormalizedValues();
        $this->calculatePriorityWeights();
        $this->calculateConsistencyMeasures();
        $this->calculateLambdaMax();
        $this->calculateConsistencyIndex();
        $this->calculateConsistencyRatio();
        $this->calculateRatioIndex();
        $this->getConsistencyStatus();
    }

    private function initializeMatrix()
    {
        foreach ($this->listJenisEvaluasi as $jenisEvaluasiKiri) {
            foreach ($this->listJenisEvaluasi as $jenisEvaluasiAtas) {
                $this->inputValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id] = '';
            }
        }
    }

    private function fillData()
    {
        $values = AhpModel::all();
        foreach ($values as $value) {
            $this->inputValues[$value->kiri_jenis_evaluasi_id][$value->atas_jenis_evaluasi_id] = $value->nilai;
        }
    }

    private function calculateNormalizedValues()
    {
        $totals = [];
        foreach ($this->listJenisEvaluasi as $jenisEvaluasiAtas) {
            $total = 0;
            foreach ($this->listJenisEvaluasi as $jenisEvaluasiKiri) {
                $total += $this->inputValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id];
            }
            $totals[$jenisEvaluasiAtas->id] = $total;
        }

        foreach ($this->listJenisEvaluasi as $jenisEvaluasiKiri) {
            foreach ($this->listJenisEvaluasi as $jenisEvaluasiAtas) {
                $this->normalizedValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id] = round(
                    $this->inputValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id] / $totals[$jenisEvaluasiAtas->id],
                    4
                );
            }
        }
    }

    private function calculatePriorityWeights()
    {
        $this->priorityWeights = [];
        foreach ($this->listJenisEvaluasi as $jenisEvaluasiKiri) {
            $total = 0;
            foreach ($this->listJenisEvaluasi as $jenisEvaluasiAtas) {
                $total += $this->normalizedValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id];
            }
            $this->priorityWeights[$jenisEvaluasiKiri->id] = round($total / count($this->listJenisEvaluasi), 4);
        }
    }

    private function calculateConsistencyMeasures()
    {
        $this->consistencyMeasures = [];
        foreach ($this->listJenisEvaluasi as $jenisEvaluasiKiri) {
            $total = 0;
            foreach ($this->listJenisEvaluasi as $jenisEvaluasiAtas) {
                $total += $this->inputValues[$jenisEvaluasiKiri->id][$jenisEvaluasiAtas->id] * $this->priorityWeights[$jenisEvaluasiAtas->id];
            }
            $this->consistencyMeasures[$jenisEvaluasiKiri->id] = round($total / $this->priorityWeights[$jenisEvaluasiKiri->id], 4);
        }
    }

    private function calculateLambdaMax()
    {
        $total = array_sum($this->consistencyMeasures);
        $count = count($this->consistencyMeasures);
        $this->lambdaMax = round($total / $count, 4);
    }

    private function calculateConsistencyIndex()
    {
        $this->consistencyIndex = round(($this->lambdaMax - count($this->listJenisEvaluasi)) / (count($this->listJenisEvaluasi) - 1), 4);
    }

    private function calculateConsistencyRatio()
    {
        $this->calculateRatioIndex();
        $this->consistencyRatio = round($this->consistencyIndex / $this->ratioIndex, 4);
    }

    private function calculateRatioIndex()
    {
        $n = count($this->listJenisEvaluasi);
        $this->ratioIndex = self::$ratioIndexes[$n] ?? 0;
    }

    private function getConsistencyStatus()
    {
        $this->consistencyStatus = $this->consistencyRatio <= 0.1 ? 'Konsisten' : 'Tidak Konsisten';
    }

    public function updated($propertyName, $value): void
    {
        $keys = explode('.', str_replace('inputValues.', '', $propertyName));

        if (count($keys) == 2) {
            list($kiriId, $atasId) = $keys;

            if (isset($this->inputValues[$kiriId]) && isset($this->inputValues[$atasId])) {
                if ($kiriId != $atasId && !empty($value) && is_numeric($value)) {
                    $inverseValue = 1 / $value;
                    $this->inputValues[$atasId][$kiriId] = round($inverseValue, 4);
                }

                $this->inputValues[$kiriId][$atasId] = round($value, 2);

                $this->calculateNormalizedValues();
                $this->calculatePriorityWeights();
                $this->calculateConsistencyMeasures();
                $this->calculateLambdaMax();
                $this->calculateConsistencyIndex();
                $this->calculateConsistencyRatio();
                $this->getConsistencyStatus();
            }
        }
    }

    // Contoh di dalam metode save()
    public function save()
    {
        foreach ($this->inputValues as $kiriId => $row) {
            foreach ($row as $atasId => $nilai) {
                AhpModel::updateOrCreate(
                    [
                        'kiri_jenis_evaluasi_id' => $kiriId,
                        'atas_jenis_evaluasi_id' => $atasId,
                    ],
                    [
                        'nilai' => $nilai,
                        'bobot' => $this->selectedBobot,
                        'bobot_prioritas' => $this->priorityWeights, // Jangan encode ke JSON
                    ]
                );
            }
        }

        Notification::make()
            ->title('Data Perhitungan Kriteria berhasil disimpan!')
            ->success()
            ->send();

        $this->calculateNormalizedValues();
        $this->calculatePriorityWeights();
        $this->calculateConsistencyMeasures();
        $this->calculateLambdaMax();
        $this->calculateConsistencyIndex();
        $this->calculateConsistencyRatio();
        $this->getConsistencyStatus();
    }
    public function getBobotOptions(): array
    {
        return array_map(fn($bobot) => ['label' => "Bobot $bobot", 'value' => $bobot], BobotEnum::cases());
    }
}
