<?php

namespace Linear\Dto;

final class Project
{
    public function __construct(
        readonly ?string $id,
        readonly string $name,
        readonly string $description,
        readonly Issues $issues,
    ) {}

}