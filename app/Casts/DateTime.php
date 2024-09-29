<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class DateTime implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get($model, string $key, mixed $value, array $attributes)
    {
        return !\is_null($value) ? Carbon::parse($value)->format('d/m/Y - H:i:s') : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, mixed $value, array $attributes)
    {
        return !\is_null($value) ? Carbon::createFromFormat('d/m/Y - H:i:s', $value)->format('Y-m-d H:i:s') : null;
    }
}
