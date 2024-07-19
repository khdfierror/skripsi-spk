<?php

namespace App\Models\Data;

use App\Concerns\HasUlids;
use App\Models\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisEvaluasi extends Model
{
    use HasUlids, SoftDeletes;

    protected $table = 'data_jenis_evaluasi';

    protected $fillable = [
        'no',
        'nama_jenis',
        'bobot1',
        'bobot2',
        'bobot3',
    ];

    public function evaluasi(): HasMany
    {
        return $this->hasMany(Data\Evaluasi::class);
    }
}
