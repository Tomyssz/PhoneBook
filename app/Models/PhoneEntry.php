<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'deleted_at'
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_phone_entry')->withTimestamps()->withPivot('main');
    }

    public function canUpdate(): bool
    {
        if (!$this->haveAccess()) {
            return false;
        }

        return $this->user()->where('user_id', auth()->id())->firstOrFail()->pivot->main;
    }

    public function haveAccess(int $id = null): bool
    {
        return (bool)$this->user()->where('user_id', $id ?: auth()->id())->first();
    }

    public static function validateAccessRights(PhoneEntry|null $entry, array &$errors): void
    {
        if (!$entry || !$entry->exists()) {
            $errors[] = 'Phone entry no longer exists';
        }

        if ($entry && (!$entry->canUpdate() || !$entry->user())) {
            $errors[] = 'You do not have permission to edit';
        }
    }
}
