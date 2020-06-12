<?php

namespace App\Form;

use App\Entity\Poste;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 
                  TextType::class,
                  $this->getConfiguration("Titre", "Tapez le titre de votre poste"))
            ->add('description', 
                  TextType::class,
                  $this->getConfiguration("Description", "Tapez la description de votre annonce"))
            ->add('ville',
                  TextType::class,
                  $this->getConfiguration("Ville", "Taper le nom de la ville"))
            ->add('photos',
                  CollectionType::class,
                  [
                      'entry_type' => PhotoType::class,
                      'allow_add' => true

                  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Poste::class,
        ]);
    }
}
