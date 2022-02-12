<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected static function booted()
    {
         static::saving(function ($user){
             if(Hash::needsRehash(  $user->password)){
                 $user->password=Hash::make($user->password);
             }
         });
    }

    public function products(){
        return $this->hasMany(product::class);
    }
    public function profile(){
        return $this->hasOne(Profile::class,'user_id')->withDefault();
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public  function favouriteProducts(){

        return $this->belongsToMany(product::class,'favourites');
    }

    public function ratedProducts(){

        return $this->morphedByMany(product::class ,'rateable','ratings');
        //return product that user rate it
    }

    public function ratedUsers(){

        return $this->morphedByMany(User::class ,'rateable','ratings');
        //return user that user rate it
    }
    public function ratings(){
        return $this->morphToMany(User::class ,'rateable','ratings')
        ->withPivot([
            'rating','created_at','updated_at'
        ]);
        //return User rate that this user
    }

   /* public function routeNotificationForNexmo($notification = null){
         return $this->phone ;
    }*/
    /*
    public function routeNotificationForEmail($notification = null){
        return $this->email ;
    }
    public function routeNotificationForBroadcast($notification = null){
        return 'App.Models.User.'.$this->id ;
    }*/

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
