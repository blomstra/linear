<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class LabelsTest extends TestCase
{
    protected ?Sdk\Labels $labels;
    protected ?Sdk\Teams $teams;

    public function setUp(): void
    {
        $this->labels = new Sdk\Labels(getenv('LINEAR_API_KEY'), 1);
        $this->teams = new Sdk\Teams(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->labels = null;
        $this->teams = null;
    }

    public function testGetAll()
    {
        $response = $this->labels->getAll();

        $this->assertInstanceOf(Dto\Labels::class, $response);
    }

    public function testGetOne()
    {
        $response = $this->labels->getOne('4704736f-cdd4-40e2-831c-3b372e8f3077');
        $this->assertInstanceOf(Dto\Label::class, $response);
    }

}