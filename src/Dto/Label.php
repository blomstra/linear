<?php

namespace Linear\Dto;

final class Label
{
    public function __construct(
        readonly ?string $id,
        readonly string $name,
        readonly bool $isGroup,
    ) {}

}