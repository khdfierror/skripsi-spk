<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satker extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'data_satker';

    protected $fillable = [
        'kode_satker',
        'nama_satker',
    ];

    protected $casts = [
        //
    ];

    public function ppk(): HasMany
    {
        return $this->hasMany(Data\Ppk::class);
    }

    public function paket_tender(): HasMany
    {
        return $this->hasMany(Data\Paket::class);
    }
}
