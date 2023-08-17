<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__,
    ]);

    $rectorConfig->skip([
        __DIR__.'/vendor',
        __DIR__.'/Tests',
        __DIR__.'/var',
    ]);

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
    $rectorConfig->parallel();

    $rectorConfig->import(LevelSetList::UP_TO_PHP_81);
    $rectorConfig->import(SymfonyLevelSetList::UP_TO_SYMFONY_60);
    $rectorConfig->import(SymfonySetList::SYMFONY_CODE_QUALITY);

    $services = $rectorConfig->services();

    $services->set(AddVoidReturnTypeWhereNoReturnRector::class);
};
