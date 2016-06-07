<?php

namespace Naldz\Bundle\DsnParserBundle\DsnParser\Driver;

interface DsnParserInterface
{
    public function parse($dsn);
}