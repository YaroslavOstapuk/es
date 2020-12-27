<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;

class Group extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'status'
    ];

    const GROUP_ACTIVE = 1;
    const GROUP_DISABLE = 0;

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @param $request
     * @return $this
     */
    public function setSlug($request)
    {
        if ($request->slug) {
            $this->update([
                'slug' => $request->slug
            ]);
        } else {
            set_slug($this, $request->name);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user')->withPivot('role_id')->withTimestamps();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function hasUser(User $user)
    {
        if ($this->users->find($user->id)) {
            return true;
        }

        return false;
    }
}
