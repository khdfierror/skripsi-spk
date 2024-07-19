<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\Data;
use App\Models\PaketBobot;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluasi extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasUlids, SoftDeletes;

    protected $table = 'data_evaluasi';

    protected $fillable = [
        'jenis_evaluasi_id',
        'uraian',
        'no',
    ];

    protected $casts = [
        //
    ];

    public function jenis_evaluasi(): BelongsTo
    {
        return $this->belongsTo(Data\JenisEvaluasi::class);
    }

    public function paket_bobot(): HasMany
    {
        return $this->hasMany(PaketBobot::class);
    }
}
