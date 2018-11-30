<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriBarang extends Model
{
    use SoftDeletes;
    protected $table = 'kategori_barang';
    protected $fillable = [
        'nama_kategori', 'ket_kategori'
    ];
    protected $dates = ['deleted_at'];
}
