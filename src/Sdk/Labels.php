<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Linear\Utils\Mapper;
use Linear\Dto;
use Exception;
use Symfony\Contracts\Cache\ItemInterface;


class Labels extends Client
{
    public function getAll(): Dto\Labels
    {
        $query = "
        query Labels {
            issueLabels {
                nodes {
                    id
                    name
                    isGroup
                }
            }
        }
        ";

        $labelsArr = $this->cache->get('labels', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Labels::class, Source::array($labelsArr['issueLabels']));
        } catch (MappingError $error) {
            throw new Exception('Teams DTO Mapping error:' . $error->getMessage());
        }
    }

    public function getWorkspaceLabels(): Dto\Labels
    {
        $query = "
            query Labels {
                issueLabels(filter: {
                    team: { null: null }
                }) {
                    nodes {
                        id
                        name
                        isGroup
                    }
                }
            }
        ";

        $labelsArr = $this->cache->get('labels', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Labels::class, Source::array($labelsArr['issueLabels']));
        } catch (MappingError $error) {
            throw new Exception('Teams DTO Mapping error:' . $error->getMessage());
        }
    }

    public function getOne(string $id): Dto\Label
    {
        $query = "
            query Label {
                issueLabel(id: \"$id\" ) {
                    id
                    name
                    isGroup
                }
            }";


        $response = $this->cache->get('label_' . $id, function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);

            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Label::class, Source::array($response['issueLabel']));
        } catch (MappingError $error) {
            throw new Exception('Team DTO Mapping error:' . $error->getMessage());
        }
    }

}
