<?php

namespace App\Models;

use App\Casts\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'shelter_id',
        'image',
        'personality',
        'found',
        'owner_name',
        'owner_email',
        'owner_phone',
    ];

    protected $casts = [
        'image' => File::class,
        'shelter_id' => 'integer',
        'found' => 'boolean',
    ];

    protected $logAttributes = [
        'shelter_id' => 'Abrigo',
        'personality' => 'Personalidade',
        'found' => 'Encontrado',
        'owner_name' => 'Nome do dono',
        'owner_email' => 'Email do dono',
        'owner_phone' => 'Telefone do dono',
    ];

    public function shelter()
    {
        return $this->belongsTo(Shelter::class);
    } 
}
