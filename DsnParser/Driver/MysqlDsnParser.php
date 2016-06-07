<?php

namespace Naldz\Bundle\DsnParserBundle\DsnParser\Driver;

use Naldz\Bundle\DsnParserBundle\DsnParser\Driver\DsnParserInterface;
use Naldz\Bundle\DsnParserBundle\DsnParser\Exception\InvalidDsnException;

class MysqlDsnParser implements DsnParserInterface
{
    public function parse($dsn)
    {
        $urlComponents = parse_url($dsn);
        $dsnComponents = array();
        if (!isset($urlComponents['scheme']) || strtolower($urlComponents['scheme']) != 'mysql') {
            throw new InvalidDsnException(sprintf('Invalid database type detected while parsing DSN: %s', $dsn));
        }
        $dsnComponents['type'] = $urlComponents['scheme'];
        $dsnComponents['user'] = (isset($urlComponents['user']) ? $urlComponents['user'] : null);
        $dsnComponents['password'] = (isset($urlComponents['pass']) ? $urlComponents['pass'] : null);
        $dsnComponents['host'] = (isset($urlComponents['host']) ? $urlComponents['host'] : null);
        $dsnComponents['port'] = (isset($urlComponents['port']) ? $urlComponents['port'] : null);
        $dsnComponents['database'] = (isset($urlComponents['path']) ? substr($urlComponents['path'], 1) : null);

        return $dsnComponents;
    }
}