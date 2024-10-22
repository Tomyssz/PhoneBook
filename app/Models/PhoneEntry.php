<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneEntry extends Model
{
    use SoftDeletes;

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
