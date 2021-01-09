<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, '7.4');

    // here we can define, what sets of rules will be applied
    $parameters->set(
        Option::SETS,
        [
            SetList::CODE_QUALITY,
            SetList::DEAD_CODE,
            SetList::PHP_74,
            SetList::SYMFONY_44,
            SetList::SYMFONY_50,
            SetList::SYMFONY_50_TYPES,
            SetList::SYMFONY_CODE_QUALITY,
            SetList::SYMFONY_CONSTRUCTOR_INJECTION,
            SetList::DOCTRINE_SERVICES,
            SetList::TYPE_DECLARATION,
        ]
    );

    // is there a file you need to skip?
    $parameters->set(Option::SKIP, [
        __DIR__.'/tests/*',
        __DIR__.'/var/*',
    ]);

    // get services
    $services = $containerConfigurator->services();

    // register single rule
    $services->set(TypedPropertyRector::class);
};
