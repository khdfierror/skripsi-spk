<?php

namespace App\Filament\Pages\Penilaian;

use App\Models\Data\JenisEvaluasi;
use App\Models\Data\Evaluasi;
use App\Models\Data\Paket;
use App\Models\PesertaTender;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Administrasi extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.penilaian.administrasi';
    protected static ?string $title = 'Penilaian Administrasi';
    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?int $navigationSort = 0;

    public array $peserta = [];
    public array $paketTender = [];

    public $selectedPesertaTender = null;
    public $selectedPaketTender = null;

    public array|Collection $listJenisEvaluasi = [];
    public Collection $listUraian;
    public ?PesertaTender $pesertaTender = null;

    public function __construct()
    {
        // Konstruktor tanpa parameter
    }

    public function mount(): void
    {
        // Misalnya, Anda dapat mengambil data dari model yang sesuai tanpa memerlukan $state
        $this->paketTender = Paket::query()->has('pesertaTenders')->get()->toArray();
        $this->peserta = PesertaTender::query()->has('perusahaan')->get()->toArray();
        $this->peserta = PesertaTender::with('perusahaan', 'paket_tender')->get()->toArray();

        $this->listJenisEvaluasi = JenisEvaluasi::all();

        $jenisEvaluasi = JenisEvaluasi::query()->where('nama_jenis', 'Evaluasi Administrasi')->orderBy('no')->get();

        foreach ($jenisEvaluasi as $jenis) {
            $this->listUraian = Evaluasi::query()->where('jenis_evaluasi_id', $jenis->id)->orderBy('no')->get();
        }
    }
}
