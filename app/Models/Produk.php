<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produks';
    protected $primaryKey = 'idProduk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idProduk',
        'nama',
        'tipe',
        'harga',
    ];

    // Event untuk mengisi UUID sebelum create
    protected static function boot(): void
    {
        parent::boot();
        static::creating(callback: function ($model): void {
            $model->idProduk = Str::uuid();
        });
    }
    public function penjualanProduk(): BelongsToMany
    {
        return $this->belongsToMany(related: Produk::class, table: 'idProduk', foreignPivotKey: 'idProduk');
    }
    public function barang(): HasOne
    {
        return $this->hasOne(related: Barang::class, foreignKey: 'idProduk', localKey: 'idProduk');
    }
    public function jasa(): HasOne
    {
        return $this->hasOne(related: Jasa::class, foreignKey: 'idProduk', localKey: 'idProduk');
    }
}
