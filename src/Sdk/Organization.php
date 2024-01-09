<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Linear\Utils\Mapper;
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
        $response = $this->http->post('/', ['query' => $query]);

        $organisationArr = $this->process($response);

        try {
            return Mapper::get()->map(Dto\Organization::class, Source::array($organisationArr['organization']));
        } catch (MappingError $error) {
            throw new Exception('Organization DTO Mapping error:' . $error->getMessage());
        }
    }

}