<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PoliUmum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poli_umum';
    protected $fillable = ['nama_pasien', 'nomor_antrian', 'poli', 'status', 'deleted_at'];

    const STATUS = [
        'menunggu' => 'Menunggu',
        'dipanggil' => 'Dipanggil',
        'selesai' => 'Selesai',
    ];
    public static function generateNomorAntrian()
    {
        return 'B' . str_pad(PoliUmum::count() + 1, 3, '0', STR_PAD_LEFT);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->nomor_antrian = self::generateNomorAntrian();
        });
    }
}
