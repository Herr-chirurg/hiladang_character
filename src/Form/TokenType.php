<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Scenario;
use App\Entity\Token;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TokenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('usage_rate')
            ->add('value')
            ->add('value_pr')
            ->add('date_of_reception')
            ->add('scenario', EntityType::class, [
                'class' => Scenario::class,
                'choice_label' => 'id',
            ])
            ->add('character', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Token::class,
        ]);
    }
}
