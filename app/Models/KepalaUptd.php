<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaUptd extends Model
{
    protected $table    = 'kepala_uptd';
    protected $fillable = ['nama_kepala', 'nip', 'no_telp'];
    public $timestamps  = false;
}