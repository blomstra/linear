<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Linear\Utils\Mapper;
use Linear\Dto;
use Exception;
use Symfony\Contracts\Cache\ItemInterface;


class Teams extends Client
{
    public function getAll(): Dto\Teams
    {
        $query = "
            query Teams {
              teams {
                 nodes {
                  id
                  name
                  key
                  organization {
                    id
                    name
                    urlKey
                  }
                  states {
                    nodes {
                      id
                      name
                      type
                    }
                  }
                }
              }
            }
        ";

        $teamsArr = $this->cache->get('teams', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Teams::class, Source::array($teamsArr['teams']));
        } catch (MappingError $error) {
            throw new Exception('Teams DTO Mapping error:' . $error->getMessage());
        }
    }

    public function getOne(string $id, $includeIssues = false, $includeStates = false): Dto\Team
    {
        $query = "
            query Team {
              team(id: \"$id\" ) {
                id
                name
                key
                organization {
                  id
                  name
                  urlKey
                }";
        if ($includeStates) {
            $query .= "
                states {
                  nodes {
                    id
                    name
                    type
                  }
                }";
        }
        if ($includeIssues) {
            $query .="
                issues {
                  nodes {
                    id
                    title
                    description
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
                }";
              }
        $query .= "
              }
              }
        ";

        $teamsArr = $this->cache->get('team_' . $id, function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Team::class, Source::array($teamsArr['team']));
        } catch (MappingError $error) {
            throw new Exception('Team DTO Mapping error:' . $error->getMessage());
        }
    }

}