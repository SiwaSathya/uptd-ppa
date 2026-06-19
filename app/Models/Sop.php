<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sop extends Model {
    protected $table = 'sop';
    protected $fillable = ['sop'];
    public $timestamps = false;
}