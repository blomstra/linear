<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class OrganizationTest extends TestCase
{
    protected ?Sdk\Organization $organization;

    public function setUp(): void
    {
        $this->organization = new Sdk\Organization(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->organization = null;
    }

    public function testGet()
    {
        $response = $this->organization->get();
        $this->assertInstanceOf(Dto\Organization::class, $response);
    }

}