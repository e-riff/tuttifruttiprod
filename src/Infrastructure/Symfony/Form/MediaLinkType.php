<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Form;

use App\Domain\Enum\MediaTypeEnum;
use App\Infrastructure\Doctrine\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', UrlType::class, [
                'sanitize_html' => true,
                'label' => 'form.admin.full_link',
                'attr' => ['placeholder' => 'https://www.perdu.com'],
            ])
            ->add('mediaType', EnumType::class, [
                'class' => MediaTypeEnum::class,
                'expanded' => true,
                'multiple' => false,
                'choice_loader' => new CallbackChoiceLoader(function () {
                    return MediaTypeEnum::getLinks();
                }),
                'label' => 'form.admin.media_type',
                'choice_label' => function (MediaTypeEnum $choice) {
                    return $choice->value;
                },
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
