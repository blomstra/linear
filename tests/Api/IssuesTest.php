<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class IssuesTest extends TestCase
{
    protected ?Sdk\Issues $t;

    public function setUp(): void
    {
        $this->t = new Sdk\Issues(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->t = null;
    }

    public function testGetAll()
    {
        $response = $this->t->getAll();
        $this->assertInstanceOf(Dto\Issues::class, $response);
    }

    public function testGetOne()
    {
        $response = $this->t->getOne('d0e5d7a1-b445-464a-b99e-235d80587b43');
        $this->assertInstanceOf(Dto\Issue::class, $response);
    }

}