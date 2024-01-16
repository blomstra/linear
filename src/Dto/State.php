<?php

namespace Linear\Dto;

class State
{
    public function __construct(
        readonly string $id,
        readonly string $name,
        readonly string $type
    ) {}

}