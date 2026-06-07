<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Form;

use App\Infrastructure\Doctrine\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.admin.email',
                'required' => true,
            ])
            ->add('firstname', null, [
                'label' => 'form.admin.first_name',
            ])
            ->add('lastname', null, [
                'label' => 'form.admin.last_name',
            ])
            ->add('Valider', SubmitType::class, [
                'label' => 'action.validate',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'messages',
        ]);
    }
}
