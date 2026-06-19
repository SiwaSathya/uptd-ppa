<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class UndangUndang extends Model {
    protected $table = 'undang_undang';
    protected $fillable = ['nama_uu', 'penjelasan_uu'];
    public $timestamps = false;
}