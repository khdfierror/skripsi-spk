<?php

namespace App\Models;

use App\Concerns\HasUlids;
use App\Models\Data;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketBobot extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasUlids;

    protected $table = 'paket_bobot';

    protected $fillable = [
        'paket_tender_id',
        'evaluasi_id',
        'nilai_bobot',
    ];

    protected $casts = [
        //
    ];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Data\Paket::class, 'paket_tender_id');
    }

    public function evaluasi(): BelongsTo
    {
        return $this->belongsTo(Data\Evaluasi::class, 'evaluasi_id');
    }
}
