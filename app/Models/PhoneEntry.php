<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'deleted_at'
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_phone_entry')->withTimestamps();
    }
}
