<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'token',
        'key',
        'value',
        'type',
        'description',
        'is_public',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Si 'type' est 'decimal', obtenir la valeur comme float
    public function getValueAsDecimalAttribute(): ?float
    {
        if($this->type === 'decimal') {
            return (float) $this->value; 
        }
        return null;
    }

    // Si 'type' est 'integer', obtenir la valeur comme integer
    public function getValueAsIntegerAttribute(): ?int
    {
        if($this->type === 'integer') {
            return (int) $this->value;
        }
        return null;
    }

    // Si 'type' est 'boolean', obtenir la valeur comme boolean
    public function getValueAsBooleanAttribute(): ?bool
    {
        if($this->type === 'boolean') {
            return filter_var($this->value, FILTER_VALIDATE_BOOLEAN);
        }
        return null;
    }

    // Si 'type' est 'string', obtenir la valeur comme string
    public function getValueAsStringAttribute(): ?string
    {
        if($this->type === 'string') {
            return (string) $this->value;
        }
        return null;
    }   

}
