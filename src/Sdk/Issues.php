<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Symfony\Contracts\Cache\ItemInterface;
use Linear\Utils\Mapper;
use Linear\Dto;
use Exception;


class Issues extends Client
{
    public function getAll(): Dto\Issues
    {
        $query = "
            query Issues {
              issues {
                nodes {
                  id
                  title
                  description
                  number
                  priority
                  priorityLabel
                  state {
                    id
                    name
                    type
                  }
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";

        $issuesArr = $this->cache->get('issues', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Issues::class, Source::array($issuesArr['issues']));
        } catch (MappingError $error) {
            throw new Exception('Issues DTO Mapping error:' . $error->getMessage());
        }
    }

    public function getOne(string $id): Dto\Issue
    {
        $query = "
            query Issue {
              issue(id: \"$id\") {
                id
                title
                description
                number
                priority
                priorityLabel
                state {
                  id
                  name
                  type
                }
                project {
                  id
                  name
                  description
                }
              }
            }
        ";

        $issueArr = $this->cache->get('issue_' . $id, function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Issue::class, Source::array($issueArr['issue']));
        } catch (MappingError $error) {
            throw new Exception('Issue DTO Mapping error:' . $error->getMessage());
        }
    }

    public function delete(Dto\Issue $issue): bool
    {
        $query = "
            mutation DeleteIssue {
              issueDelete(id: \"{$issue->id}\") {
                success
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issueArr = $this->process($response);

        return $issueArr['issueDelete']['success'];
    }

    public function create(string $title, string $description, Dto\Team $team, ?int $priority = 0, ?Dto\Project $project = null, array $labels = []): Dto\Issue
    {
        $input = [
            'title' => $title,
            'description' => $description,
            'teamId' => $team->id,
            'priority' => $priority,
            'projectId' => $issue->project->id ?? null,
            'labelIds' => $labels ?? [],
        ];

        $query = "
            mutation (\$input: IssueCreateInput!) {
              issueCreate(input: \$input) {
                issue {
                  id
                  title
                  description
                  number
                  priority
                  priorityLabel
                  labelIds
                  state {
                    id
                    name
                    type
                  }
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";

        $qx = ['query' => $query, 'variables' => ['input' => $input]];

        $response = $this->http->post('/', $qx);

        $issueArr = $this->process($response);

        unset($issueArr['issueCreate']['issue']['labelIds']);

        try {
            return Mapper::get()->map(Dto\Issue::class, Source::array($issueArr['issueCreate']['issue']));
        } catch (MappingError $error) {
            throw new Exception('Issue DTO Mapping error:' . $error->getMessage());
        }
    }

    public function update(Dto\Issue $issue): Dto\Issue
    {
        $input = [
            'title' => $issue->title,
            'description' => $issue->description,
            'projectId' => $issue->project->id ?? null,
            'priority' => $issue->priority,
        ];

        $query = "
            mutation (\$input: IssueUpdateInput!) {
              issueUpdate(
                id: \"{$issue->id}\",
                input: \$input) {
                issue {
                  id
                  title
                  description
                  number
                  priority
                  priorityLabel
                  state {
                    id
                    name
                    type
                  }
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";
        $qx = ['query' => $query, 'variables' => ['input' => $input]];

        $response = $this->http->post('/', $qx);

        $issueArr = $this->process($response);

        try {
            return Mapper::get()->map(Dto\Issue::class, Source::array($issueArr['issueUpdate']['issue']));
        } catch (MappingError $error) {
            throw new Exception('Issue DTO Mapping error:' . $error->getMessage());
        }
    }

}