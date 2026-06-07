<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Form;

use App\Infrastructure\Doctrine\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MediaImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('pictureFile', VichImageType::class, [
            'label' => 'form.admin.image',
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
            'imagine_pattern' => 'upload_filter',
        ])
            ->add('save', SubmitType::class, [
                'label' => 'action.save',
                'attr' => ['class' => 'btn btn-primary'],
                'row_attr' => ['class' => 'text-center pb-2'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
            'translation_domain' => 'messages',
        ]);
    }
}
