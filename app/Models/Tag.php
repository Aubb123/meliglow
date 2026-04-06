<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'name',
        'created_at',
        'updated_at',
    ];

    // Relations entre la Table tags et blogs /////////////////////////////////////////////////////////////////////////////////////////////////
    public function blogs()
    {
        return $this->morphedByMany(Blog::class, 'taggable');
    }
}
 