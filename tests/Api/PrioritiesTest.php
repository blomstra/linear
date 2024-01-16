<?php

namespace Linear\Tests\Api;

use Linear\Dto;
use Linear\Sdk;
use PHPUnit\Framework\TestCase;

class PrioritiesTest extends TestCase
{
    protected ?Sdk\Priorities $t;

    public function setUp(): void
    {
        $this->t = new Sdk\Priorities(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->t = null;
    }

    public function testGet()
    {
        $response = $this->t->get();
        $this->assertInstanceOf(Dto\Priorities::class, $response);
    }

}