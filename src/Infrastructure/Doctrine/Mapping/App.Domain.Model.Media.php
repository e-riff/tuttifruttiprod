<?php

declare(strict_types=1);

use App\Domain\Model\Band;
use App\Domain\Repository\MediaRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('media');
$builder->setCustomRepositoryClass(MediaRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('link', 'string')
    ->length(255)
    ->build();
$builder->createManyToOne('band', Band::class)
    ->inversedBy('medias')
    ->addJoinColumn('band_id', 'id', false)
    ->build();
$builder->createField('mediaType', 'string')
    ->length(80)
    ->option('enumType', 'App\Enums\MediaTypeEnum')
    ->build();
$builder->createField('pictureSize', 'integer')
    ->nullable()
    ->build();
$builder->createField('updatedAt', 'datetime_immutable')
    ->build();
$builder->createField('isActive', 'boolean')
    ->option('default', true)
    ->build();
