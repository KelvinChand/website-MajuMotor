<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Jasa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jasas';
    protected $primaryKey = 'idJasa';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idJasa',
        'deskripsiKeluhan',
        'idProduk',
    ];

    // Event untuk mengisi UUID sebelum create
    protected static function boot(): void
    {
        parent::boot();
        static::creating(callback: function ($model): void {
            $model->idJasa = Str::uuid();
        });
    }

    /**
     * Relasi ke model Produk
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(related: Produk::class, foreignKey: 'idProduk', ownerKey: 'idProduk');
    }
}
