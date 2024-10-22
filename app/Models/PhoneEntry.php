<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneEntry extends Model
{
    use SoftDeletes;

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
