<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoices';
    protected $primaryKey = 'idInvoice';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'idInvoice',
        'idPenjualan',
    ];

    // Event untuk mengisi UUID sebelum create
    protected static function boot()
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

}
