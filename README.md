# A PHP SDK for Linear

This is a typed PHP SDK for the [Linear](https://linear.app) API. It contains functionality that would be most commonly needed when integrating with Linear, but does 
not expose every GraphQL endpoint.

## Capabilities
Using this SDK you can:

* Create, retrieve, update, and delete issues
* Retrieve Teams
* Retrieve Projects
* Retrieve an organisation

## Requirements
* PHP 8.2+
* An token from Linear (the SDK does not support OAuth 2 authentication yet)

## Installation

Like all PHP packages, you can install this package using composer:

```
composer require blomstra/linear
```

## Usage

### Retrieve Current Organisation

```php
use Linear\Sdk\Organization;

$o = new Organization('your-token-here');
$organization = $o->get();

// $organization is now an instance of Linear\Dto\Organization
$organization->name;
$organization->id;
$organization->urlKey
```

### Retrieve Teams

A single team can be retrieved by ID:

```php
use Linear\Sdk\Teams;

$t = new Teams('your-token-here');
$team = $t->getOne('team-id-here');

// $team is now an instance of Linear\Dto\Team

```

Or all teams can be retrieved:

```php
use Linear\Sdk\Teams;

$t = new Teams('your-token-here');
$teams = $t->getAll();
// $teams is now an instance of Linear\Dto\Teams
```

### Retrieve Projects

A single project can be retrieved by ID:

```php
use Linear\Sdk\Projects;

$p = new Projects('your-token-here');
$project = $p->getOne('project-id-here');
// $project is now an instance of Linear\Dto\Project
```

Or all projects can be retrieved:

```php
use Linear\Sdk\Projects;
   
$p = new Projects('your-token-here');
$projects = $p->getAll();
// $projects is now an instance of Linear\Dto\Projects
```

#### Issues

### Retrieve an Issue

A single issue can be retrieved by ID:

```php
use Linear\Sdk\Issues;

$i = new Issues('your-token-here');
$issue = $i->getOne('issue-id-here');
// $issue is now an instance of Linear\Dto\Issue
```

Or all issues can be retrieved:

```php
use Linear\Sdk\Issues;

$i = new Issues('your-token-here');
$issues = $i->getAll();
// $issues is now an instance of Linear\Dto\Issues
```

### Create an Issue

```php
use Linear\Sdk\Issues;
use Linear\Dto\Issue;
use Linear\Sdk\Teams;

$t = new Teams('your-token-here');
$team = $t->getAll()->nodes[0];

$i = new Issues('your-token-here');
$title = 'My new issue';
$description = 'This is a description';

$createdIssue = $i->create($title, $description, $team);

// $createdIssue is now an instance of Linear\Dto\Issue
```

### Update an Issue

```php
use Linear\Sdk\Issues;
use Linear\Dto\Issue;

$i = new Issues('your-token-here');
$issue = $i->getOne('issue-id-here');

$updatedIssueDto = new Issue($issue->id, 'updated title', 'updated description');
$updatedIssue = $i->update($updatedIssue);

// $updatedIssue is now an instance of Linear\Dto\Issue
```

### Delete an Issue

```php
use Linear\Sdk\Issues;

$i = new Issues('your-token-here');
$issue = $i->getOne('issue-id-here');
$i->delete($issue); // returns true or false
```

## Testing

Every method in this SDK is unit tested. Please see the `tests/Api` folder for more details.

## Sponsor

This extension was sponsored by [Kagi Search](https://kagi.com/), an ad free search engine

## License

MIT