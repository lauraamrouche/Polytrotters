<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',
            TextType::class,
            $this->getConfiguration("Nom", "Entrez le nom de votre photo"))
            ->add('urlPhoto',
            UrlType::class,
            $this->getConfiguration("URL", "Entrez l'URL de votre photo"))
            ->add('descriptionPhoto',
            TextType::class,
            $this->getConfiguration("Description", "Décrivez votre photo"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
