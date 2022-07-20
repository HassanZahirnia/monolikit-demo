<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const PROFILE_PICTURE_PATH = 'profiles/';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function chirps(): HasMany
    {
        return $this->hasMany(Chirp::class, foreignKey: 'author_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function displayName(): Attribute
    {
        return Attribute::make(
            get: fn ($display_name) => $display_name ?: $this->username,
        );
    }

    public function profilePictureUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->profile_picture_path
                ? Storage::url(self::PROFILE_PICTURE_PATH . $this->profile_picture_path)
                : null,
        );
    }
}
