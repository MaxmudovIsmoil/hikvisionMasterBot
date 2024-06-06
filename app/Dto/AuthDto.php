<?php

namespace App\Dto;

readonly class AuthDto
{
    public function __construct(
        public string $username,
        public string $password
    ) {}
}
