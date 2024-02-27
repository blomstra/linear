<?php

namespace Linear\Dto;

final class Labels
{
    public function __construct(
        /** @var array<Label> */
        readonly array $nodes
    ) {}

}