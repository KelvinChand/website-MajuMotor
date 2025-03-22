<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Penjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penjualans';
    protected $primaryKey = 'idPenjualan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idPenjualan',
        'totalHarga',
        'status',
    ];

    // Event untuk mengisi UUID sebelum create
    protected static function boot(): void
    {
        parent::boot();
        static::creating(callback: function ($model): void {
            $model->idPenjualan = Str::uuid();
        });
    }


    public function invoice(): HasOne
    {
        return $this->hasOne(related: Invoice::class, foreignKey: 'idPenjualan', localKey: 'idPenjualan');
    }


    public function penjualanProduk(): HasMany
    {
        return $this->hasMany(related: PenjualanProduk::class, foreignKey: 'idPenjualan', localKey: 'idPenjualan');
    }
}
