<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farmasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'antrians';
    protected $fillable = ['nama_pasien', 'nomor_antrian', 'status', 'deleted_at'];

    const STATUS = [
        'menunggu' => 'Menunggu',
        'dipanggil' => 'Dipanggil',
        'selesai' => 'Selesai',
    ];
    public static function generateNomorAntrian()
    {
        return 'A' . str_pad(Antrian::count() + 1, 3, '0', STR_PAD_LEFT);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->nomor_antrian = self::generateNomorAntrian();
        });
    }
}
