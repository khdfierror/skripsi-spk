<?php

namespace App\Models\Matriks;

use App\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class AlternatifKualifikasi extends Model
{
    use HasUlids;

    protected $table = 'perbandingan_alternatif_kualifikasi';

    protected $fillable = [
        'jenis_evaluasi_id',
        'kiri_perusahaan_id',
        'atas_perusahaan_id',
        'nilai',
        'bobot',
    ];

    protected $casts = [
        //
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->kiri_perusahaan_id === $model->atas_perusahaan_id) {
                $model->nilai = 1;
            } else {
                $model->nilai = 0;
            }
        });
    }
}
