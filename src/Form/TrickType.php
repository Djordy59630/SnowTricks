<?php

namespace App\Form;

use App\Entity\Trick;
use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('images', FileType::class,[
                'label' => true,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'label' => 'Vidéos',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('name')
            ->add('content')
            ->add('trickGroup')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
