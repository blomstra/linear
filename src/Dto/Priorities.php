<?php

namespace Linear\Dto;

final class Priorities
{
    public function __construct(
        /** @var array<Priority> */
        readonly array $issuePriorityValues
    ) {}

}