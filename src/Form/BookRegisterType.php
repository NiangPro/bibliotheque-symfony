<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('gender')
            ->add('editeur')
            ->add('anneeParution')
            ->add('collection')
            ->add('countPage')
            ->add('filename', FileType::class, [
                'required'=>false,
                'label' => 'Image de couverture',
                'mapped' => false])
            ->add('document', FileType::class, [
                'label' => 'Document (Fichier PDF)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
