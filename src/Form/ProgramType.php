<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Actor;
use App\Entity\Season;
use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('summary')
            ->add('poster',TextType::class)
            ->add('category',EntityType::class,['class'=>Category::class,'choice_label'=>'name'])
            ->add('actors',EntityType::class,['class'=>Actor::class,'choice_label'=>'name','expanded'=>true,'multiple'=>true])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
