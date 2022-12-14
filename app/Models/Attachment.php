<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperAttachment
 */
class Attachment extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    */

    public static function booted(): void
    {
        static::deleting(function (self $attachment) {
            Storage::disk('attachments')->delete($attachment->path);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function chirp(): BelongsTo
    {
        return $this->belongsTo(Chirp::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    public function getUrlAttribute(): string
    {
        return Storage::disk('attachments')->url($this->path);
    }
}
