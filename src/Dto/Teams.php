<?php

namespace Linear\Dto;

final class Teams
{
    public function __construct(
        /** @var array<Team> */
        readonly array $nodes
    ) {}

}