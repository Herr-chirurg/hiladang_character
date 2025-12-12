<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Item;
use App\Entity\Scenario;
use App\Entity\Token;
use Proxies\__CG__\App\Entity\Character as EntityCharacter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function __construct() {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) { 

                $form = $event->getForm()
                    ->add("name")
                    ->add("quantity")
                    ->add("price")
                    ->add("ratio_pr");
            });

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
