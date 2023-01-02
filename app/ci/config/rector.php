<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SOURCE, __DIR__ . '/../../../src');
    $parameters->set(Option::CACHE_DIR, __DIR__ . '/../cache');
    $parameters->set(Option::ENABLE_CACHE, true);


    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::CODE_QUALITY_STRICT,
        SetList::DEAD_CODE,
        SetList::DEAD_DOC_BLOCK,
        SetList::DEAD_CODE_STRICT,
        SetList::DOCTRINE_CODE_QUALITY,
        SetList::DOCTRINE_DBAL_211,
        SetList::FRAMEWORK_EXTRA_BUNDLE_50,
        SetList::PHP_80,
    ]);
};
