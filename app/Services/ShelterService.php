<?php

namespace App\Services;

use App\Repository\ShelterRepository;

class ShelterService
{
    public function __construct( protected ShelterRepository $shelterRepository ) {}

    public function managementRequest(int $id): bool
    {
        $shelter = $this->shelterRepository->find($id);

        if (!$shelter) {
            return false;
        }

        $this->shelterRepository->managementRequest($shelter->id);

        return true;
    }
}
