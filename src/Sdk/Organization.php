<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Linear\Utils\Mapper;
use Symfony\Contracts\Cache\ItemInterface;
use Linear\Dto;
use Exception;


class Organization extends Client
{
    public function get(): Dto\Organization
    {
        $query = "
            query Organization {
                organization {
                    id
                    name
                    urlKey
                }
            }
        ";

        $organisationArr = $this->cache->get('organization', function (ItemInterface $item) use ($query) {
            $response = $this->http->post('/', ['query' => $query]);
            return $this->process($response);
        });

        try {
            return Mapper::get()->map(Dto\Organization::class, Source::array($organisationArr['organization']));
        } catch (MappingError $error) {
            throw new Exception('Organization DTO Mapping error:' . $error->getMessage());
        }
    }

}