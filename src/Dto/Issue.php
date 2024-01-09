<?php

namespace Linear\Dto;

final class Issue
{
    public function __construct(
        readonly ?string $id,
        readonly string $title,
        readonly string $description,
        readonly ?Project $project,
    ) {}

}