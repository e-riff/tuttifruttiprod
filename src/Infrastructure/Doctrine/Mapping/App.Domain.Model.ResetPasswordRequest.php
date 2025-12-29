<?php

declare(strict_types=1);

use App\Domain\Model\User;
use App\Domain\Repository\ResetPasswordRequestRepositoryInterface;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/** @var ClassMetadata $metadata */
$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('resetpasswordrequest');
$builder->setCustomRepositoryClass(ResetPasswordRequestRepositoryInterface::class);
$builder->createField('id', 'integer')
    ->makePrimaryKey()
    ->generatedValue()
    ->build();
$builder->createManyToOne('user', User::class)
    ->addJoinColumn('user_id', 'id', false)
    ->build();
$builder->createField('selector', 'string')
    ->length(20)
    ->build();
$builder->createField('hashedToken', 'string')
    ->length(100)
    ->build();
$builder->createField('requestedAt', 'datetime_immutable')
    ->build();
$builder->createField('expiresAt', 'datetime_immutable')
    ->build();
