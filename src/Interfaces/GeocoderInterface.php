<?php

declare(strict_types=1);

namespace App\Interfaces;

interface GeocoderInterface
{
    public function search(string $query);
}