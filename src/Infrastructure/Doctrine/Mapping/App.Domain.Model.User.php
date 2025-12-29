<?php

declare(strict_types=1);

use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('user');
$builder->setCustomRepositoryClass(UserRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('email', 'string')
    ->length(180)
    ->unique()
    ->build();
$builder->createField('roles', 'json')
    ->build();
$builder->createField('password', 'string')
    ->build();
$builder->createField('firstname', 'string')
    ->length(255)
    ->build();
$builder->createField('lastname', 'string')
    ->build();
