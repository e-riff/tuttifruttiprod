<?php

declare(strict_types=1);

use App\Domain\Repository\AssociationRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('association');
$builder->setCustomRepositoryClass(AssociationRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('name', 'string')
    ->length(80)
    ->build();
$builder->createField('phone', 'string')
    ->length(20)
    ->nullable()
    ->build();
$builder->createField('address', 'string')
    ->length(255)
    ->build();
$builder->createField('zipCode', 'string')
    ->build();
$builder->createField('city', 'string')
    ->length(100)
    ->build();
$builder->createField('siret', 'string')
    ->build();
$builder->createField('createdAt', 'datetime_immutable')
    ->build();
$builder->createField('email', 'string')
    ->build();
$builder->createField('description', 'text')
    ->build();
