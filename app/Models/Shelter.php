<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'state_id',
        'city_id',
        'zip_code',
        'district',
        'address',
        'address_number',
        'address_note',
    ];

    protected $casts = [
        'state_id' => 'integer',
        'city_id' => 'integer',
    ];

    protected $logAttributes = [
        'name' => 'Nome',
        'state_id' => 'Estado',
        'city_id' => 'Cidade',
        'zip_code' => 'CEP',
        'district' => 'Bairro',
        'address' => 'Logradouro',
        'address_number' => 'Número',
        'address_note' => 'Complemento',
    ]; 

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    } 

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_shelter');
    }
}
