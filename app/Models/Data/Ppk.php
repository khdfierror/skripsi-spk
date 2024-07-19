<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ppk extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'data_ppk';

    protected $fillable = [
        'satker_id',
        'nip',
        'nama_ppk',
    ];

    protected $casts = [
        //
    ];

    public function paket_tender()
    {
        return $this->hasMany(Data\Paket::class);
    }

    public function satker(): BelongsTo
    {
        return $this->belongsTo(Data\Satker::class);
    }
}
