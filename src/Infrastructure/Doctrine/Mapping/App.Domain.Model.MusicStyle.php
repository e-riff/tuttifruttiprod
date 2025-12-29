<?php

declare(strict_types=1);

use App\Domain\Model\Band;
use App\Domain\Repository\MusicStyleRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('musicstyle');
$builder->setCustomRepositoryClass(MusicStyleRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createField('name', 'string')
    ->length(100)
    ->build();
$builder->createManyToMany('bands', Band::class)
    ->inversedBy('musicStyles')
    ->setJoinTable('music_style_band')
    ->addJoinColumn('music_style_id', 'id', false, false, 'CASCADE')
    ->addInverseJoinColumn('band_id', 'id', false, false, 'CASCADE')
    ->build();
$builder->createField('slug', 'string')
    ->length(255)
    ->build();
