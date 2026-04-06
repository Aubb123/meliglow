<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscribe extends Model
{
    /** @use HasFactory<\Database\Factories\SubscribeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'token',
        'email',
        'etat',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
    ];
 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
