<?php

namespace App\Models;

use App\Casts\DateTime;

class ShelterManagementRequest extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'shelter_id',
        'user_id',
        'approved',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => DateTime::class,
    ];

    public function shelter()
    {
        return $this->belongsTo('App\Models\Shelter');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
