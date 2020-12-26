<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Models\Media;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const ROLE_USER = 0;
    const ROLE_AUTHOR = 1;
    const ROLE_ADMIN = 2;
    const USER_TEACHER = 3;

    /**
     * @param MediaModel|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(MediaModel $media = null): void
    {
        $this->addMediaConversion('avatar')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 165, 165)
            ->nonQueued();

        $this->addMediaConversion('min_avatar')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 50, 50)
            ->nonQueued();
    }

    /**
     * @param string $collectionName
     * @return array|string[]
     */
    public function getAllConversions(string $collectionName = 'main_photo')
    {
        $media = $this->getFirstMedia($collectionName);

        if ($media) {
            return [
                'avatar' => $this->getFirstMediaUrl($collectionName, 'avatar'),
                'min_avatar' => $this->getFirstMediaUrl($collectionName, 'min_avatar'),
            ];
        }

        return [
            'avatar' => env('APP_URL') . '/images/default-avatar.jpg',
            'min_avatar' => env('APP_URL') . '/images/default-avatar-min_avatar.jpg',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user')->withPivot('role_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }
}
