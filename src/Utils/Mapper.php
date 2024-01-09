<?php

namespace Linear\Utils;

use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;
use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use Monolog\Logger;

class Mapper
{
    public static function get(bool $flexible = true): TreeMapper
    {

        if ($flexible) {
            return (new MapperBuilder())
                ->enableFlexibleCasting()
                ->mapper();
        }

        return (new MapperBuilder())
            ->mapper();

    }

    public static function logErrors(Logger $logger, MappingError $error): void
    {
        foreach (Messages::flattenFromNode($error->node()) as $message) {
            $logger->error($message->originalMessage());
        }
    }

}