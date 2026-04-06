<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Continent extends Model
{
    /** @use HasFactory<\Database\Factories\ContinentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'name', 
        'code', 
        'description',
        'path_img',
        'population',
        'area',
        'sort_order',
        'is_active',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'population' => 'integer',
        'area' => 'decimal:2',
    ];

    protected $appends = [
        //
    ];

    // Relations with other models can be defined here
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }

}
