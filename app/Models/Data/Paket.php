<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\Data;
use App\Models\PaketBobot;
use App\Models\PesertaTender;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use \Awobaz\Compoships\Compoships;
    use HasUlids, SoftDeletes;

    protected $table = 'data_paket_tender';

    protected $fillable = [
        'satker_id',
        'ppk_id',
        'tahun',
        'kode_paket',
        'nama_paket',
        'pagu',
        'hps',
    ];

    protected $casts = [
        //
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($paketTender) {
            PaketBobot::where('paket_tender_id', $paketTender->id)->delete();
        });
    }

    public function satker(): BelongsTo
    {
        return $this->belongsTo(Data\Satker::class);
    }

    public function ppk(): BelongsTo
    {
        return $this->belongsTo(Data\Ppk::class);
    }

    public function pesertaTenders()
    {
        return $this->hasMany(PesertaTender::class, 'paket_tender_id');
    }

    public function paket_bobot(): HasMany
    {
        return $this->hasMany(PaketBobot::class, 'paket_tender_id');
    }
}
