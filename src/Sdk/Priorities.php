<?php

namespace Linear\Sdk;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use Exception;
use Linear\Dto;
use Linear\Utils\Mapper;


class Priorities extends Client
{
    public function get(): Dto\Priorities
    {
        $query = "
            query Priorities {
              issuePriorityValues {
                priority
                label
              }
            }
        ";
        $response = $this->http->post('/', ['query' => $query]);

        $prioritiesArr = $this->process($response);

        try {
            return Mapper::get()->map(Dto\Priorities::class, Source::array($prioritiesArr));
        } catch (MappingError $error) {
            throw new Exception('Priorities DTO Mapping error:' . $error->getMessage());
        }
    }

}