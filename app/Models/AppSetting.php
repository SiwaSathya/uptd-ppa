<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table    = 'app_settings';
    protected $fillable = ['key', 'value'];
    public $timestamps  = false;

    public static function getValue(string $key, $default = null)
    {
        $row = static::where('key', $key)->first();
        return $row ? $row->value : $default;
    }

    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getMany(array $defaults): array
    {
        $rows = static::whereIn('key', array_keys($defaults))->pluck('value', 'key')->toArray();
        return array_merge($defaults, $rows);
    }
}