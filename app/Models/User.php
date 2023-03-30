<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Egulias\EmailValidator\Warning\Warning;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasSlug;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'status',
        'user_type',
        'activation',
        'email_verified_at',
        'national_code',
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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }



    public static $userActivations = [

        0 => 'inActive',
        1 => 'active'


    ];

    public function userActivations($activation){

        switch ($activation) {

            case 0 :
                return 'InActive';
            break;

            case 1 : 
                return 'Active';
            break;
            default : 
            return 'Active';

        }

    }

    public static $userTypes = [

        0 => 'User',
        1 => 'Admin'


    ];

    public function userTypes($user_type){

        switch ($user_type) {

            case 0 :
                return 'User';
            break;

            case 1 : 
                return 'Admin';
            break;
            default : 
            return 'User';

        }

    }



    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }



    public function wallets()
    {
        return $this->hasMany(wallet::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Wallet::class);
    }

    public function totalAmount($user_id)
    {

        $amount = Wallet::where('user_id', $user_id)->sum('amount');
        return $amount;
    }

    public function totalWalletAmount($wallet_id)
    {

        $wallet = Wallet::where('id', $wallet_id)->first();
        return $wallet;
    }

    public function lastCreatedWallet($user_id)
    {

        $wallet = Wallet::where('user_id', $user_id)->latest('created_at')->first();
        if (!$wallet == null) {

            return $wallet;
        } else {
            return null;
        }
    }

    public function lastTransaction($user_id)
    {

        $user = User::where('id', $user_id)->first();
        $transaction = $user->transactions()->latest('published_at')->first();
        if (!$transaction == null) {

            return $transaction;
        } else {
            return null;
        }
    }
    public function lastWalletTransaction($wallet_id, $user_id)
    {

        $user = User::where('id', $user_id)->first();
        $transaction = $user->transactions()->where('wallet_id', $wallet_id)->latest('published_at')->first();
        if (!$transaction == null) {

            return $transaction;
        } else {
            return null;
        }
    }

    public function depositCount($wallet_id)
    {
        $transactionCount = Transaction::where([['wallet_id', $wallet_id], ['status', '0']])->count();
        if (!$transactionCount== null) {

            return $transactionCount;
        } else {
            return null;
        }
    }

    public function withdrawCount($wallet_id)
    {

     $transactionCount = Transaction::where([['wallet_id', $wallet_id], ['status', '1']])->count();
        if (!$transactionCount== null) {

            return $transactionCount;
        } else {
            return null;
        }
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
}
