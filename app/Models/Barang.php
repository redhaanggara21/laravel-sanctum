<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barangs";
    protected $fillable = [
        'NAMA_BARANG',
        'KATEGORI',
        'HARGA',
        'created_at',
        'updated_at'
    ];

    public function itemPenjualan(){
        return $this->belongsToMany(
            Item_Penjualan::class,
            'penjualans',
            'id',
            'NOTA_KODE'
        );
    }

}
