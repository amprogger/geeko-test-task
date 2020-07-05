<?php

namespace App\Logging;

use Monolog\Logger;

/**
 * Class DBLogger
 * @package App\Logging
 */
class DBLogger
{
    /**
     * Create a custom Monolog instance.
     *
     *
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger("DBLogHandler");
        return $logger->pushHandler(new DBLogHandler());
    }
}
