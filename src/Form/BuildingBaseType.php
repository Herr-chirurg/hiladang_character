<?php

namespace App\Form;

use App\Entity\BuildingBase;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuildingBaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('type')
            ->add('production')
            ->add('bonus')
            ->add('upgrade_to', EntityType::class, [
                'class' => BuildingBase::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('upgrade_from', EntityType::class, [
                'class' => BuildingBase::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BuildingBase::class,
        ]);
    }
}
