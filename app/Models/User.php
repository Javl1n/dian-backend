<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with = [
        'followers', 'following', 
        // 'posts', 'currentProfilePost', 'comments', 'likes',
        // 'participating', 'messages',
        // 'interests',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the current profile post of User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentProfilePost(): HasOne
    {
        return $this->hasOne(Post::class)->ofMany([
            'created_at' => 'max',
            'id' => 'max',
        ], function (Builder $query){
            $query->where('profile', true);
        });
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get all of the likes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get all of the followers for the User
     * followers sa user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Pair::class, 'following_id');
    }

    /**
     * Get all of the following for the User
     * gina follow sa user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function following(): HasMany
    {
        return $this->hasMany(Pair::class, 'follower_id');
    }

    /**
     * Get all of the participating for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participating(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Get all of the messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * The interests that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }
}