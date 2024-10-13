<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pair extends Model
{
    /** @use HasFactory<\Database\Factories\PairFactory> */
    use HasFactory;

    /**
     * Get the follower that owns the Pair
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the following that owns the Pair
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function following(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
