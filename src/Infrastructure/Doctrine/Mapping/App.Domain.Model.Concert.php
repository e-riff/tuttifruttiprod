<?php

declare(strict_types=1);

use App\Domain\Model\Band;
use App\Domain\Repository\ConcertRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('concert');
$builder->setCustomRepositoryClass(ConcertRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('clientName', 'string')
    ->length(255)
    ->build();
$builder->createField('address', 'string')
    ->nullable()
    ->build();
$builder->createField('zipCode', 'string')
    ->length(20)
    ->build();
$builder->createField('city', 'string')
    ->length(100)
    ->build();
$builder->createField('date', 'datetime_immutable')
    ->build();
$builder->createField('otherInformations', 'text')
    ->build();
$builder->createField('isConfirmed', 'boolean')
    ->build();
$builder->createManyToOne('band', Band::class)
    ->inversedBy('concerts')
    ->addJoinColumn('band_id', 'id', false)
    ->build();
