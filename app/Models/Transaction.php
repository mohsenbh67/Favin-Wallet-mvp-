<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class Transaction extends Model
{
    use HasFactory, HasSlug;


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'wallet_id',
        'title',
        'description',
        'status',
        'amount',
        'slug',
        'published_at'
    ];

    public function status($status){

        switch ($status) {

            case 0 :
                return 'deposit';
            break;

            case 1 : 
                return 'withdraw';
            break;
            default : 
            return 'deposit';

        }

    }



    public function wallet()
    {
        return $this->belongsTo(wallet::class);
    }


}
