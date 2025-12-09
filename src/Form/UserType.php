<?php

namespace App\Form;

use App\Entity\Token;
use App\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tokens', CollectionType::class, [
                'entry_type' => MJListedTokenType::class,
                'entry_options' => ['label' => false],
                'data' => $builder->getData()
                    ?->getTokens()?->matching(
                        Criteria::create()->where(Criteria::expr()->eq('status', Token::STATUS_AWARDED))
            )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
