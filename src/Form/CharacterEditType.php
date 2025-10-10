<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('level_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+1'],
            ])
            ->add('xp_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+1000'],
            ])
            ->add('xp_mj_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+1000'],
            ])
            ->add('gp_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+10'],
            ])
            ->add('pr_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+10'],
            ])
            ->add('activity_add', IntegerType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => '+1'],
            ])
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
