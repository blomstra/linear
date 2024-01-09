<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class ProjectsTest extends TestCase
{
    protected ?Sdk\Projects $t;

    public function setUp(): void
    {
        $this->t = new Sdk\Projects(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->t = null;
    }

    public function testGetAll()
    {
        $response = $this->t->getAll();
        $this->assertInstanceOf(Dto\Projects::class, $response);
    }

    public function testGetOne()
    {
        $response = $this->t->getOne('7dd5e633-1d7f-42b3-9bf4-546a23f15406');
        $this->assertInstanceOf(Dto\Project::class, $response);
    }

}