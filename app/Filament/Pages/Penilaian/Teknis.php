<?php

namespace App\Filament\Pages\Penilaian;

use App\Models\Data\JenisEvaluasi;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Teknis extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.penilaian.teknis';

    protected static ?string $title = 'Penilaian Teknis';

    protected static ?string $navigationGroup = 'Penilaian';

    protected static ?int $navigationSort = 3;

    public array|Collection $listJenisEvaluasi = [];


    public  $evaluasiAdministrasi;

    public function mount(): void
    {
        $this->listJenisEvaluasi = JenisEvaluasi::all();
    }
}
