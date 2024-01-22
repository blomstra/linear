<?php

namespace Linear\Dto;

final class Issue
{
    public function __construct(
        readonly ?string $id,
        readonly string $title,
        readonly string $description,
        readonly int $number,
        readonly int $priority,
        readonly string $priorityLabel,
        readonly ?State $state,
        readonly ?Project $project,
    ) {}

}