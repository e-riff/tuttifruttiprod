<?php

declare(strict_types=1);

use App\Domain\Model\Concert;
use App\Domain\Model\Event;
use App\Domain\Model\Media;
use App\Domain\Model\Musician;
use App\Domain\Model\MusicStyle;
use App\Domain\Repository\BandRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('band');
$builder->setCustomRepositoryClass(BandRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('name', 'string')
    ->length(255)
    ->build();
$builder->createField('description', 'text')
    ->nullable()
    ->build();
$builder->createField('isActive', 'boolean')
    ->option('default', true)
    ->build();
$builder->createOneToMany('concerts', Concert::class)
    ->mappedBy('band')
    ->orphanRemoval()
    ->build();
$builder->createField('flashInformation', 'text')
    ->build();
$builder->createField('tagline', 'string')
    ->build();
$builder->createManyToMany('events', Event::class)
    ->mappedBy('bands')
    ->build();
$builder->createManyToMany('musicStyles', MusicStyle::class)
    ->mappedBy('bands')
    ->build();
$builder->createOneToMany('medias', Media::class)
    ->mappedBy('band')
    ->orphanRemoval()
    ->build();
$builder->createField('slug', 'string')
    ->build();
$builder->createField('picture', 'string')
    ->build();
$builder->createField('isOnHomepage', 'boolean')
    ->option('default', false)
    ->build();
$builder->createManyToMany('musicians', Musician::class)
    ->mappedBy('bands')
    ->build();
$builder->createField('updatedAt', 'datetime_immutable')
    ->build();
$builder->createField('priceCategory', 'string')
    ->length(32)
    ->option('enumType', 'App\Enums\BandPriceEnum')
    ->build();
$builder->createField('color', 'string')
    ->length(7)
    ->option('default', '#000000')
    ->build();
$builder->createManyToOne('leader', Musician::class)
    ->inversedBy('leadingBands')
    ->build();
