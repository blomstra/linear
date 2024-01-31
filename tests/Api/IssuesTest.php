<?php

namespace Linear\Tests\Api;

use Linear\Sdk;
use Linear\Dto;
use PHPUnit\Framework\TestCase;

class IssuesTest extends TestCase
{
    protected ?Sdk\Issues $issues;
    protected ?Sdk\Teams $teams;
    public function setUp(): void
    {
        $this->issues = new Sdk\Issues(getenv('LINEAR_API_KEY'), 1);
        $this->teams = new Sdk\Teams(getenv('LINEAR_API_KEY'));
    }

    public function tearDown(): void
    {
        $this->issues = null;
        $this->teams = null;
    }

    public function testGetAll()
    {
        $response = $this->issues->getAll();
        $this->assertInstanceOf(Dto\Issues::class, $response);
    }

    public function testGetOne()
    {
        $response = $this->issues->getOne('d0e5d7a1-b445-464a-b99e-235d80587b43');
        $this->assertInstanceOf(Dto\Issue::class, $response);
    }

    public function testLifecycle()
    {
        $team = $this->teams->getAll()->nodes[0];
        $issue = $this->issues->create('Test issue', 'Test issue description', $team, 1);
        $this->assertInstanceOf(Dto\Issue::class, $issue);
        $this->assertEquals('Test issue', $issue->title);
        $this->assertEquals('Test issue description', $issue->description);


        $issueRemote = new Dto\Issue($issue->id, $issue->title . ' updated', $issue->description . ' updated',
            $issue->number, $issue->priority, $issue->priorityLabel, $issue->state, $issue->project);

        $this->issues->update($issueRemote);
        $this->assertEquals('Test issue updated', $issueRemote->title);
        $this->assertEquals('Test issue description updated', $issueRemote->description);

        $this->assertTrue($this->issues->delete($issueRemote));
    }

}