<?php

namespace App\Filament\Pages\Matriks;

use App\Models\Data\Perusahaan;
use App\Models\Matriks\AlternatifKualifikasi as AlternatifKualifikasiModel;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class AlternatifKualifikasi extends Page
{
    protected static ?string $navigationIcon = null;
    protected static ?string $title = 'Matriks Alternatif Terhadap Kualifikasi';
    protected static ?string $navigationGroup = 'Matriks';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Kualifikasi';
    protected static string $view = 'filament.pages.matriks.alternatif-kualifikasi';

    public array|Collection $listPerusahaan = [];
    public array $inputValues = [];
    public array $normalizedValues = [];
    public array $bobot = [];

    public function mount(): void
    {
        $this->listPerusahaan = Perusahaan::all();
        $this->initializeMatrix();
        $this->fillData();
        $this->calculateNormalizedValues();
        $this->calculateBobot();
    }

    private function initializeMatrix()
    {
        foreach ($this->listPerusahaan as $perusahaanKiri) {
            foreach ($this->listPerusahaan as $perusahaanAtas) {
                $this->inputValues[$perusahaanKiri->id][$perusahaanAtas->id] = '';
            }
        }
    }

    private function fillData()
    {
        $values = AlternatifKualifikasiModel::all();
        foreach ($values as $value) {
            $this->inputValues[$value->kiri_perusahaan_id][$value->atas_perusahaan_id] = $value->nilai;
        }
    }

    private function calculateNormalizedValues()
    {
        $totals = [];
        foreach ($this->listPerusahaan as $perusahaanAtas) {
            $total = 0;
            foreach ($this->listPerusahaan as $perusahaanKiri) {
                $total += $this->inputValues[$perusahaanKiri->id][$perusahaanAtas->id];
            }
            $totals[$perusahaanAtas->id] = $total;
        }

        foreach ($this->listPerusahaan as $perusahaanKiri) {
            foreach ($this->listPerusahaan as $perusahaanAtas) {
                $this->normalizedValues[$perusahaanKiri->id][$perusahaanAtas->id] = round(
                    $this->inputValues[$perusahaanKiri->id][$perusahaanAtas->id] / $totals[$perusahaanAtas->id],
                    4
                );
            }
        }
    }

    private function calculateBobot()
    {
        $this->bobot = [];
        foreach ($this->listPerusahaan as $perusahaanKiri) {
            $total = 0;
            foreach ($this->listPerusahaan as $perusahaanAtas) {
                $total += $this->normalizedValues[$perusahaanKiri->id][$perusahaanAtas->id];
            }
            $this->bobot[$perusahaanKiri->id] = round($total / count($this->listPerusahaan), 4);
        }
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
                $this->calculateBobot();
            }
        }
    }

    public function save()
    {
        foreach ($this->inputValues as $kiriId => $row) {
            foreach ($row as $atasId => $nilai) {
                AlternatifKualifikasiModel::updateOrCreate(
                    [
                        'kiri_perusahaan_id' => $kiriId,
                        'atas_perusahaan_id' => $atasId,
                    ],
                    [
                        'nilai' => $nilai,
                        'bobot' => $this->bobot,
                    ]
                );
            }
        }

        Notification::make()
            ->title('Data Perhitungan Alternatif Kualifikasi berhasil disimpan!')
            ->success()
            ->send();

        $this->calculateNormalizedValues();
        $this->calculateBobot();
    }


}
