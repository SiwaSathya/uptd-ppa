<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanduanKeamanan extends Model
{
    // WAJIB: Sertakan nama skema 'uptd.' sebelum nama tabel
    protected $table    = 'uptd.panduan_keamanan'; 
    
    protected $fillable = ['kategori', 'tindakan_keamanan', 'preservasi_bukti', 'edukasi'];
    
    // Aktifkan jika Anda membuat kolom created_at di database sebelumnya
    public $timestamps  = false; 

    // Cast kolom array PostgreSQL
    protected $casts = [
        'kategori' => 'array',
    ];
    
    public function setKategoriAttribute($value)
    {
        if (is_array($value)) {
            $escaped = array_map(fn($v) => '"' . addslashes(trim($v)) . '"', $value);
            $this->attributes['kategori'] = '{' . implode(',', $escaped) . '}';
        } else {
            $this->attributes['kategori'] = $value;
        }
    }

    public function getKategoriAttribute($value)
    {
        if (is_string($value)) {
            $value = trim($value, '{}');
            return $value ? array_map(
                fn($v) => trim(stripslashes(trim($v, '"'))),
                str_getcsv($value)
            ) : [];
        }
        return $value ?? [];
    }

    /**
     * Scope untuk mempermudah pencarian berdasarkan kategori di PostgreSQL
     */
    public function scopeHasKategori($query, $kategori)
    {
        return $query->whereRaw('? = ANY(kategori)', [$kategori]);
    }
}