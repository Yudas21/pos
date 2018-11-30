<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customer';
    protected $fillable = [
        'nomor_kartu', 'nama_customer', 'tgl_lahir_customer', 'kontak_customer'
    ];
    protected $dates = ['deleted_at'];
}
