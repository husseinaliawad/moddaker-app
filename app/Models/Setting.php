<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'key',
        'group',
        'value',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        try {
            if (! Schema::hasTable('settings')) {
                return $default;
            }

            return static::query()->where('key', $key)->value('value') ?? $default;
        } catch (Throwable) {
            return $default;
        }
    }

    public static function putValue(string $key, mixed $value, string $group = 'general'): self
    {
        try {
            if (! Schema::hasTable('settings')) {
                return new self();
            }

            return static::query()->updateOrCreate(
                ['key' => $key],
                ['group' => $group, 'value' => $value]
            );
        } catch (Throwable) {
            return new self();
        }
    }
}
