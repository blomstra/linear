<?php

namespace Linear\Dto;

final class States
{
    public function __construct(
        /** @var array<State> */
        readonly array $nodes
    ) {}

}