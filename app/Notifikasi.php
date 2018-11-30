<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
	protected $connection = 'mysql';
    protected $table = 'notifikasi';

    protected $fillable = [
        'to', 'read', 'notif'
    ];
}
