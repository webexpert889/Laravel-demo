<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tour extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'description',
        'price_range',
        'zip',
        'status',
        'season_start',
        'season_end',
        'auto_renewal',
        'enable_purse',
        'money_purse'
    ];

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function latestImages() {
        return $this->hasOne(TourImage::class)->latest();
    }

    public function tournaments()
    {
        return $this->hasMany(TourTournament::class);
    }

    public function representative()
    {
        return $this->hasMany(Representative::class);
    }

    public function players(){
        return $this->hasMany(TournamentPlayer::class);
    }
}
