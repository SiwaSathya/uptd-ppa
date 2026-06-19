<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LaporanKasusPpa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'laporan_kasus_ppa';
    protected $primaryKey = 'id';
    public $incrementing  = true;
    protected $keyType    = 'int';
    public $timestamps    = false;
    const UPDATED_AT      = null;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pelapor', 'jenis_kasus', 'tanggal_kejadian', 'kecamatan',
        'lokasi_spesifik', 'hubungan_pelaku', 'gender_korban', 'usia_korban',
        'disabilitas_korban', 'gender_pelaku', 'usia_pelaku', 'instance',
        'address_instance', 'user_number', 'id_kasus', 'nama_korban',
        'nama_pelaku', 'deskripsi_kasus', 'validasi', 'status',
        'tanggal_pertemuan', 'waktu_pertemuan', 'status_kirim',
        'created_at', 'deleted_at',
    ];

    
    public static function formatIdKasus(
        int    $usiaKorban,
        string $pelapor,
        $date
    ): string {
        $t    = \Carbon\Carbon::parse($date);
        $dd   = $t->format('d');
        $mm   = $t->format('m');
        $yyyy = $t->format('Y');   // 4 digit: 2026

        $katK = ($usiaKorban <= 17) ? 'A' : 'P';
        $katP = in_array(strtolower(trim($pelapor)), ['korban', 'keluarga', 'kerabat'])
                ? 'B' : 'R';

        return "{$dd}/{$mm}/{$dd}-{$katK}-{$katP}/UPTD PPA/{$yyyy}";
    }

    /**
     * Generate & simpan ID kasus ke database
     * Dipanggil setelah save() pertama agar created_at sudah terisi
     */
    public static function generateIdKasus(
        string $genderKorban,
        int    $usiaKorban,
        string $pelapor,
        $createdAt
    ): string {
        return self::formatIdKasus($usiaKorban, $pelapor, $createdAt);
    }

    /**
     * Accessor — bisa dipanggil langsung sebagai $item->id_kasus_formatted
     */
    public function getIdKasusFormattedAttribute(): string
    {
        return self::formatIdKasus(
            (int) $this->usia_korban,
            (string) $this->pelapor,
            $this->created_at
        );
    }
}