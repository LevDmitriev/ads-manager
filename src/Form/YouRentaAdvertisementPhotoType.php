<?php

namespace App\Form;

use App\Entity\YouRenta\YouRentaAdvertisementPhoto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 * Форма загрузки файла объявления
 */
class YouRentaAdvertisementPhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('imageFile', VichFileType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YouRentaAdvertisementPhoto::class,
        ]);
    }
}
