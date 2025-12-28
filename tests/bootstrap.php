<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    new Dotenv()->bootEnv(dirname(__DIR__).'/.env');
}

$commands = [
    'doctrine:d:drop --if-exists --force --no-interaction --quiet',
    'doctrine:d:create --if-not-exists --no-interaction --quiet',
    'doctrine:s:create --no-interaction --quiet',
    'doctrine:m:migrate --no-interaction --allow-no-migration --quiet',
];

foreach ($commands as $command) {
    passthru(sprintf(
        'APP_ENV=%s php "%s/../bin/console" %s',
        $_ENV['APP_ENV'] ?? 'test',
        __DIR__,
        $command
    ));
}
