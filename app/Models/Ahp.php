<?php

namespace App\Models;

use App\Concerns\HasUlids;
use App\Enums\BobotEnum;
use App\Models\Data\JenisEvaluasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ahp extends Model
{
    use HasUlids;

    protected $table = 'ahp';

    protected $fillable = [
        'kiri_jenis_evaluasi_id',
        'atas_jenis_evaluasi_id',
        'nilai',
        'bobot',
        'bobot_prioritas',
    ];

    protected $casts = [
        'bobot' => BobotEnum::class,
        // 'bobot_prioritas' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->kiri_jenis_evaluasi_id === $model->atas_jenis_evaluasi_id) {
                $model->nilai = 1;
            } else {
                $model->nilai = 0;
            }

            // Pastikan bobot_prioritas adalah array
            if (is_string($model->bobot_prioritas)) {
                $model->bobot_prioritas = json_decode($model->bobot_prioritas, true);
            }
        });
    }


    public function saveBobotPrioritas()
    {
        DB::transaction(function () {
            foreach ($this->bobot_prioritas as $jenisEvaluasiId => $nilaiBobotPrioritas) {
                $jenisEvaluasi = JenisEvaluasi::find($jenisEvaluasiId);
                if ($jenisEvaluasi) {
                    if ($this->bobot == 1) {
                        $jenisEvaluasi->bobot1 = $nilaiBobotPrioritas;
                        $jenisEvaluasi->bobot2 = null;
                        $jenisEvaluasi->bobot3 = null;
                    } elseif ($this->bobot == 2) {
                        $jenisEvaluasi->bobot1 = null;
                        $jenisEvaluasi->bobot2 = $nilaiBobotPrioritas;
                        $jenisEvaluasi->bobot3 = null;
                    } elseif ($this->bobot == 3) {
                        $jenisEvaluasi->bobot1 = null;
                        $jenisEvaluasi->bobot2 = null;
                        $jenisEvaluasi->bobot3 = $nilaiBobotPrioritas;
                    }
                    $jenisEvaluasi->save();
                }
            }
        });
    }
}
