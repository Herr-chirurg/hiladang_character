<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Transfer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gp')
            ->add('pr')
            ->add('extra_pr')
            ->add('initiator', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'id',
            ])
            ->add('recipient', EntityType::class, [
                'class' => Character::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transfer::class,
        ]);
    }
}
