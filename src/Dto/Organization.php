<?php

namespace Linear\Dto;

final class Organization
{
    public function __construct(
        readonly ?string $id,
        readonly string $name,
        readonly string $urlKey,
    ) {}

}