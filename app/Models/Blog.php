<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Blog extends Model
{
    /** @use HasFactory<\Database\Factories\BlogFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'categorie_id',
        'user_id',

        'title',
        'content',
        'path_img',
        'views',
        'time_read',
        'is_visible',
        'created_at',
        'updated_at',
    ];

    // Relations entre la Table blogs et users /////////////////////////////////////////////////////////////////////////////////////////////////
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relations entre la Table blogs et categories /////////////////////////////////////////////////////////////////////////////////////////////////
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    // Relations entre la Table blogs et tags /////////////////////////////////////////////////////////////////////////////////////////////////
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    // Relations entre la Table blogs et comments /////////////////////////////////////////////////////////////////////////////////////////////////
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->orderBy('id', 'DESC');
    }

}

