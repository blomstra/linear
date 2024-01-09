<?php

namespace Linear\Dto;

final class Issues
{
    public function __construct(
        /** @var array<Issue> */
        readonly array $nodes
    ) {}

}