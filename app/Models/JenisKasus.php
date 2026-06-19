<?php
// app/Models/JenisKasus.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKasus extends Model {
    protected $table = 'Jenis-jenis_kasus';
    protected $fillable = ['jenis_kasus', 'pengertian', 'aksi'];
    public $timestamps = false;
}