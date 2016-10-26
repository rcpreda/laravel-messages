<?php

namespace App\Http\Repositories;

interface MessageRepositoryInterface
{
    public function saveEntity(array $request);
}