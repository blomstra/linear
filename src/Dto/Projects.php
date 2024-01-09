<?php

namespace Linear\Dto;

final class Projects
{
    public function __construct(
        /** @var array<Project> */
        readonly array $nodes
    ) {}

}