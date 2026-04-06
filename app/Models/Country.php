<?php

namespace App\Models;

use App\Models\User;
use App\Models\Continent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'continent_id',
        'name', 
        'code', 
        'code_2',
        'phone_code',
        
        'is_active',

        'path_img',
 
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = [
        //
    ];

    // Relations with other models can be defined here
    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

}
