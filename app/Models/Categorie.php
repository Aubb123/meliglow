<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    /** @use HasFactory<\Database\Factories\CategorieFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'name',
        'path_img',
        'description',
        'created_at',
        'updated_at',
    ];

    // Relations entre la Table categories et blogs /////////////////////////////////////////////////////////////////////////////////////////////////
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }


}
