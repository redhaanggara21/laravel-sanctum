<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = "penjualans";
    protected $fillable = [
        'KODE_PELANGGAN',
        'TOTAL',
        'created_at',
        'updated_at'
    ];

    public function barangPenjualan(){
        return $this->belongsToMany(
            Barang::class,
            'item_penjualans',
            'NOTA_KODE',
            'KODE_BARANG'
        );
    }

    public function itemPenjualan(){
        return $this->hasMany(
            Item_Penjualan::class,
            'NOTA_KODE', 
            'id'
        );
    }

    public function pelanggan(){
        return $this->belongsTo(User::class,'KODE_PELANGGAN','id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, Item_penjualan::class,'KODE_BARANG','id');
    }
}
