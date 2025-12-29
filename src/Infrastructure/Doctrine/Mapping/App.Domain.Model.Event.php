<?php

declare(strict_types=1);

use App\Domain\Model\Band;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('event');
$builder->setCustomRepositoryClass(EventRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('name', 'string')
    ->length(100)
    ->build();
$builder->createManyToMany('bands', Band::class)
    ->inversedBy('events')
    ->setJoinTable('event_band')
    ->addJoinColumn('event_id', 'id', false, false, 'CASCADE')
    ->addInverseJoinColumn('band_id', 'id', false, false, 'CASCADE')
    ->build();
$builder->createField('slug', 'string')
    ->length(255)
    ->build();
