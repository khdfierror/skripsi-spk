<?php

namespace App\Models\Penilaian;

use App\Concerns\HasUlids;
use App\Models\Data\Evaluasi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teknis extends Model
{
    use HasUlids;

    protected $table = 'penilaian_teknis';

    protected $fillable = [
        'peserta_tender_id',
        'perusahaan_id',
        'paket_tender_id',
        'evaluasi_id',
        'bobot',
        'jumlah',
        'keterangan',
        'nilai_1',
        'nilai_2',
        'nilai_3',
        'nilai_4',
        'nilai_5',
    ];

    public function evaluasi(): BelongsTo
    {
        return $this->belongsTo(Evaluasi::class);
    }
}
