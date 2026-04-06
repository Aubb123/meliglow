<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'label',
        'description',
        'created_at',
        'updated_at',
    ];

    // Relations entre la Table roles et users /////////////////////////////////////////////////////////////////////////////////////////////////
    public function users(): HasMany    
    {
        return $this->hasMany(User::class);
    }
 
}
