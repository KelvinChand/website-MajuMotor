<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PenjualanProduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penjualanproduks';
    protected $primaryKey = 'idPenjualanProduk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'idPenjualanProduk',
        'jumlah',
        'kuantitas',
        'idPenjualan',
        'idProduk',
    ];

    // Event untuk mengisi UUID sebelum create
    protected static function boot(): void
    {
        parent::boot();
        static::creating(callback: function ($model): void {
            $model->idPenjualanProduk = Str::uuid();
        });
    }

    /**
     * Relasi ke model Penjualan
     */
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(related: Penjualan::class, foreignKey: 'idPenjualan', ownerKey: 'idPenjualan');
    }

    /**
     * Relasi ke model Produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }
}
