<?php

declare(strict_types=1);

use App\Domain\Model\Band;
use App\Domain\Repository\MusicianRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('musician');
$builder->setCustomRepositoryClass(MusicianRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('firstname', 'string')
    ->length(80)
    ->build();
$builder->createField('lastname', 'string')
    ->build();
$builder->createField('email', 'string')
    ->length(255)
    ->build();
$builder->createField('phone', 'string')
    ->length(20)
    ->nullable()
    ->build();
$builder->createField('isActive', 'boolean')
    ->option('default', true)
    ->build();
$builder->createManyToMany('bands', Band::class)
    ->inversedBy('musicians')
    ->setJoinTable('musician_band')
    ->addJoinColumn('musician_id', 'id', false, false, 'CASCADE')
    ->addInverseJoinColumn('band_id', 'id', false, false, 'CASCADE')
    ->build();
$builder->createField('picture', 'string')
    ->build();
$builder->createField('updatedAt', 'datetime_immutable')
    ->build();
$builder->createOneToMany('leadingBands', Band::class)
    ->mappedBy('leader')
    ->build();
