<?php


use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\ShortenElseIfRector;
use Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector;
use Rector\Config\RectorConfig;

use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Privatization\Rector\Class_\FinalizeTestCaseClassRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\SafeDeclareStrictTypesRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/lang',
        __DIR__ . '/public',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        naming: true,
        privatization: false,
        typeDeclarations: true,
        rectorPreset: true,
    )
    ->withComposerBased(
        twig: true,
        doctrine: true,
        phpunit: true,
        laravel: true,
    )
    ->withRules([
        CombineIfRector::class,
        ShortenElseIfRector::class,
        SimplifyIfElseToTernaryRector::class,

    ])
    ->withSkip([
        SafeDeclareStrictTypesRector::class,
        DeclareStrictTypesRector::class,
        AddClosureVoidReturnTypeWhereNoReturnRector::class,
        ClosureToArrowFunctionRector::class,
        FinalizeTestCaseClassRector::class,
        ReturnTypeFromStrictTypedCallRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
        ReturnTypeFromStrictTypedCallRector::class,
    ]);
