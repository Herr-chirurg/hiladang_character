<?php

namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterChangesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Raison du Log',
                'attr' => [
                    'placeholder' => 'Décrivez la raison de ce changement (ex: "Gain de niveau suite à la quête d\'Or").',
                    'rows' => 3
                ]
            ])
            ->add('amount', IntegerType::class, [
                
                'label' => 'Montant du Changement',
                'help' => 'Exemple : +50 XP ou +1 Niveau',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
