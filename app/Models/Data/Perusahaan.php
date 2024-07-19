<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\PesertaTender;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    use \Awobaz\Compoships\Compoships;

    use HasUlids, SoftDeletes;

    protected $table = 'data_perusahaan';

    protected $fillable = [
        'npwp',
        'nama_perusahaan',
        'nama_pimpinan',
        'jabatan',
        'telepon_perusahaan',
        'alamat',
    ];

    protected $casts = [
        //
    ];

//    public function pesertaTenders()
//     {
//         return $this->belongsToMany(PesertaTender::class, 'daftar_perusahaan', 'perusahaan_id', 'peserta_tender_id');
//     }

    public function peserta_tender(): HasMany
    {
        return $this->hasMany(PesertaTender::class);
    }
}

