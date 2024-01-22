<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Symfony\Contracts\Cache\ItemInterface;
use Linear\Utils\Mapper;
use Linear\Dto;
use Exception;


class Projects extends Client
{
    public function getAll(): Dto\Projects
    {
        $query = "
            query Projects {
              projects {
                nodes {
                  id
                  name
                  description
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
                    }
                  }
                }
              }
            }
        ";

        $projectsArr = $this->cache->get('projects', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Projects::class, Source::array($projectsArr['projects']));
        } catch (MappingError $error) {
            throw new Exception('Projects DTO Mapping error:' . $error->getMessage());
        }
    }

    public function getOne(string $id): Dto\Project
    {
        $query = "
            query Project {
              project(id: \"$id\") {
                id
                name
                description
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
                  }
                }
              }
            }
        ";

        $projectsArr = $this->cache->get('project', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Project::class, Source::array($projectsArr['project']));
        } catch (MappingError $error) {
            throw new Exception('Project DTO Mapping error:' . $error->getMessage());
        }
    }

}