<?php

namespace App;

use App\Casts\DateTime;
use App\Casts\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject
{
    use Notifiable, SoftDeletes, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_id',
        'avatar',
        'name',
        'username',
        'phone',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'profile_id' => 'integer',
        'avatar' => File::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Mapping columns to a user-friendly name
     *
     * @var array
     */
    protected $logAttributes = [
        'profile_id' => 'Perfil',
        'avatar' => 'Foto de perfil',
        'name' => 'Nome',
        'username' => 'Usuário',
        'phone' => 'Telefone',
        'email' => 'Email',
        'status' => 'Situação',
    ];

    /**
     * Get all of the tokens for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany('App\Models\Token', 'user_id', 'id');
    }

    /**
     * Get all of the passwords for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passwords()
    {
        return $this->hasMany('App\Models\Password', 'user_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile');
    }

    public function shelters()
    {
        return $this->belongsToMany('App\Models\Shelter', 'user_shelter')->withPivot('owner');
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
