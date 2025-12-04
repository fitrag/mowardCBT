<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return $setting->parsed_value ?? $default;
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general', ?string $description = null): void
    {
        $setting = static::firstOrNew(['key' => $key]);
        
        $setting->value = match($type) {
            'json' => json_encode($value),
            'boolean' => $value ? '1' : '0',
            default => (string) $value,
        };
        
        $setting->type = $type;
        $setting->group = $group;
        
        if ($description) {
            $setting->description = $description;
        }
        
        $setting->save();
    }

    /**
     * Get all settings grouped by category
     */
    public static function getAllGrouped(): array
    {
        $settings = static::all();
        $grouped = [];

        foreach ($settings as $setting) {
            if (!isset($grouped[$setting->group])) {
                $grouped[$setting->group] = [];
            }
            $grouped[$setting->group][$setting->key] = $setting->parsed_value;
        }

        return $grouped;
    }

    /**
     * Get parsed value based on type
     */
    public function getParsedValueAttribute(): mixed
    {
        return match($this->type) {
            'number' => is_numeric($this->value) ? (float) $this->value : 0,
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
