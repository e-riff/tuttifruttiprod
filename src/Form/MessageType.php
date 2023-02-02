<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr' => ['class' => 'form-floating mb-3'],
                'label' => 'Votre nom'
            ])
            ->add('email', TextType::class, [
                'row_attr' => ['class' => 'form-floating mb-3'],
                'label' => 'Votre email (obligatoire)'
            ])
            ->add('phone', TextType::class, [
                'row_attr' => ['class' => 'form-floating mb-3'],
                'label' => 'Votre nom'
            ])
            ->add('message', CKEditorType::class, [
                'attr' => ['data-ckeditor' => true],
                'config_name' => 'light',
                'config' => ['editorplaceholder' => "Besoin d'informations ? D'un devis ?"]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Publier',
                'row_attr' => ['class' => 'd-flex justify-content-center']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
