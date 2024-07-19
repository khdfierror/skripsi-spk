<?php

namespace App\Models;

use App\Concerns\HasUlids;
use App\Filament\Pages\Penilaian\Administrasi;
use App\Models\Data;
use App\Models\Data\Perusahaan;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaTender extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasFactory, HasUlids;
    use SoftDeletes;

    protected $table = 'peserta_tender';

    protected $fillable = [
        'perusahaan_id',
        'paket_tender_id',
        'nama',
        'harga_penawaran',
        'harga_terkoreksi',
        'persentase',
    ];

    public function paket_tender(): BelongsTo
    {
        return $this->belongsTo(Data\Paket::class,  'paket_tender_id');
    }

    public function administrasi()
    {
        return $this->hasMany(Administrasi::class);
    }

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(Data\Perusahaan::class);
    }

    protected static function booted()
    {
        static::saving(function ($pesertaTender) {
            $hps = $pesertaTender->paket_tender->hps;

            if ($hps > 0) {
                $pesertaTender->persentase = round(($pesertaTender->harga_terkoreksi / $hps) * 100, 2);
            } else {
                $pesertaTender->persentase = 0;
            }
        });
    }
}
