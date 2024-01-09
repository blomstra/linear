<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
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
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issuesArr = $this->process($response);

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
                project {
                  id
                  name
                  description
                }
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issueArr = $this->process($response);

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
              issueDelete(input: {
                id: \"{$issue->id}\"
              }) {
                success
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issueArr = $this->process($response);

        return $issueArr['issueDelete']['success'];
    }

    public function create(string $title, string $description, Dto\Team $team, ?Dto\Project $project): Dto\Issue
    {
        $query = "
            mutation CreateIssue {
              issueCreate(input: {
                title: \"$title\",
                description: \"$description\",
                teamId: \"{$team->id}\",
                projectId: \"{$project->id}\"
              }) {
                issue {
                  id
                  title
                  description
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issueArr = $this->process($response);

        try {
            return Mapper::get()->map(Dto\Issue::class, Source::array($issueArr['issueCreate']['issue']));
        } catch (MappingError $error) {
            throw new Exception('Issue DTO Mapping error:' . $error->getMessage());
        }
    }

    public function update(Dto\Issue $issue): Dto\Issue
    {
        $query = "
            mutation UpdateIssue {
              issueUpdate(input: {
                id: \"{$issue->id}\",
                title: \"{$issue->title}\",
                description: \"{$issue->description}\"
                projectId: \"{$issue->project->id}\"
              }) {
                issue {
                  id
                  title
                  description
                  project {
                    id
                    name
                    description
                  }
                }
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $issueArr = $this->process($response);

        try {
            return Mapper::get()->map(Dto\Issue::class, Source::array($issueArr['issueUpdate']['issue']));
        } catch (MappingError $error) {
            throw new Exception('Issue DTO Mapping error:' . $error->getMessage());
        }
    }

}