<?php

namespace App\Observers;

class ShelterObserver extends BaseObserver
{
    protected string $screen = 'Abrigos';

    /**
     * Mapping columns to NOT log
     *
     * @var array
     */
    protected array $fieldsExcept = [];
}
