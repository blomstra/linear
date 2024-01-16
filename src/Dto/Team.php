<?php

namespace Linear\Dto;

final class Team
{
    public function __construct(
        readonly ?string $id,
        readonly string $name,
        readonly ?States $states,
        readonly ?Issues $issues,
    ) {}

}