<?php

namespace Linear\Dto;

class Priority
{
    public function __construct(
        readonly int $priority,
        readonly string $label,
    ) {}

}