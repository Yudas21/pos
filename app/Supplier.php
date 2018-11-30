<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $table = 'supplier';
    protected $fillable = [
        'nama_supplier', 'alamat_supplier', 'kontak_supplier'
    ];
    protected $dates = ['deleted_at'];
}
