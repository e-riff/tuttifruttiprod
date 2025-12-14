<?php

declare(strict_types=1);

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'sanitize_html' => true,
                'row_attr' => ['class' => 'form-floating mb-3'],
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', TextType::class, [
                'row_attr' => ['class' => 'form-floating mb-3'],
                'label' => 'Votre email (obligatoire)',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ])
            ->add('phone', TextType::class, [
                'sanitize_html' => true,
                'row_attr' => ['class' => 'form-floating mb-3'],
                'required' => false,
                'label' => 'Votre numéro de téléphone',
            ])
            ->add('message', CKEditorType::class, [
                'sanitize_html' => true,
                'attr' => ['data-ckeditor' => true],
                'config_name' => 'light',
                'config' => ['editorplaceholder' => "Besoin d'informations ? D'un devis ?"],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Publier',
                'row_attr' => ['class' => 'd-flex justify-content-center'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
