<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => 'Savernis Flamen'],
            ])
            ->add('title', TextType::class, [
                'mapped' => false, 
                'required' => false,
                'attr' => ['placeholder' => 'Maitre Artisan'],
            ])
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
                'attr' => ['placeholder' => '+10'],
            ])/*
            ->add('last_action', ChoiceType::class, [
                'choices'  => [
                    'Transaction PNJ' => Character::TRADE_PNJ,
                    'Transaction PJ' => Character::TRADE_PJ,
                    'Correction' => Character::CORRECTION,
                ],
            ])*/
            ->add('last_action_description', TextType::class, [
                'attr' => ['class' => 'description-textarea', 'placeholder' => 'achat de 10 feu alchimistes'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
