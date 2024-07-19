<?php

namespace App\Filament\Pages\Penilaian;

use App\Models\Data\Evaluasi;
use App\Models\Data\JenisEvaluasi;
use App\Models\Data\Paket;
use App\Models\Data\Perusahaan;
use App\Models\PesertaTender;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Harga extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.penilaian.harga';

    protected static ?string $title = 'Penilaian Harga';

    protected static ?string $navigationGroup = 'Penilaian';

    protected static ?int $navigationSort = 4;

    public array $listJenisEvaluasi = [];
    public array $pesertaTenders = [];
    public array $perusahaans = [];
    public array $paketTenders = [];
    public $listUraian = [];

    public $selectedPesertaTender = null;
    public $selectedPerusahaan = null;
    public $selectedPaketTender = null;

    public function mount(): void
    {
        $pesertaId = PesertaTender::all()->toArray();
        $this->listJenisEvaluasi = JenisEvaluasi::all()->toArray();

        $this->pesertaTenders = PesertaTender::with(['perusahaan', 'paket_tender'])->where('paket_tender_id', $pesertaId)->get()
        ->toArray();

        // dd($this->pesertaTenders);
        // $perusahaanIds = DB::table('daftar_perusahaan')
        //     ->where('peserta_tender_id', $pesertaId)
        //     ->pluck('perusahaan_id')
        //     ->toArray();

        // $this->perusahaans = Perusahaan::whereIn('id', $perusahaanIds)->get()->toArray();
        $this->perusahaans = Perusahaan::all()->toArray();

        $this->paketTenders = Paket::all()->toArray();

        $jenisEvaluasi = JenisEvaluasi::query()->where('nama_jenis', 'Evaluasi Harga')->orderBy('no')->get();

        foreach ($jenisEvaluasi as $jenis) {
            $this->listUraian = Evaluasi::query()->where('jenis_evaluasi_id', $jenis->id)->orderBy('no')->get();
        }
    }

    public function updatedSelectedPesertaTender($value)
    {
        $this->perusahaans = Perusahaan::whereHas('pesertaTenders', function ($query) use ($value) {
            $query->where('peserta_tender.id', $value);
        })->get()->toArray();

        $this->paketTenders = Paket::whereHas('pesertaTenders', function ($query) use ($value) {
            $query->where('peserta_tender.id', $value);
        })->get()->toArray();


    }
}
