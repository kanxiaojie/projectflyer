<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
    protected $fillable = [
        'street',
        'city',
        'state',
        'country',
        'zip',
        'price',
        'description'
    ];

    /**
     * Scope query to those located at a given address.
     * @param $zip
     * @param $street
     * @return mixed
     * @internal param $query
     */
    public static function locatedAt($zip, $street)
    {
        $street = str_replace('-', ' ', $street);

        return static::where(compact('zip', 'street'))->first();
    }

    public function getPriceAttribute($price)
    {
        return '$'.number_format($price);
    }

    /**
     * Add a photo to the flyer.
     * @param Photo $photo
     * @return Model
     */
    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }
    /**
     * A flyer can have many photos;
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    /**
     * A flyer is owned by a user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     *Determine if the given user created the flyer.
     *
     * @param User $user
     * @return boolean
     */
    public function ownedBy(User $user)
    {
        return $this->user_id = $user->id;
    }

}
