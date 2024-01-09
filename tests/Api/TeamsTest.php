<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class TeamsTest extends TestCase
{
    protected ?Sdk\Teams $t;

    public function setUp(): void
    {
        $this->t = new Sdk\Teams(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->t = null;
    }

    public function testGetAll()
    {
        $response = $this->t->getAll();
        $this->assertInstanceOf(Dto\Teams::class, $response);
    }

    public function testGetOne()
    {
        $response = $this->t->getOne('7b4f758f-dade-471e-a7ce-1647940efeb5');
        $this->assertInstanceOf(Dto\Team::class, $response);
    }

}