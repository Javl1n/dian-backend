<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    /**
     * Get the parent fileable model (post or message).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
