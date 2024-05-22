<?php

namespace App\Observers;

class PetObserver extends BaseObserver
{
    protected string $screen = 'Pets';

    /**
     * Mapping columns to NOT log
     *
     * @var array
     */
    protected array $fieldsExcept = [
        'image'
    ];
}
