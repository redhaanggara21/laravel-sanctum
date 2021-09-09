<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_Penjualan extends Model
{
    use HasFactory;

    protected $table = "item_penjualans";
    protected $fillable = [
        'NOTA_KODE',
        'KODE_BARANG',
        'QTY',
        'created_at',
        'updated_at'
    ];

    public function barang(){
        return $this->hasOne(Barang::class,'KODE_BARANG','KODE_BARANG');
    }

    public function Penjualan(){
        return $this->belongsTo(Penjualan::class,'KODE_NOTA','NOTA_KODE')->withDefault([
            'KODE_NOTA' => 'Not found',
            'KODE_PELANGGAN'  => 'Not found',
            'TOTAL'  => '0',
            'created_at' => '',
            'updated_at' => '',
        ]);
    }
}
