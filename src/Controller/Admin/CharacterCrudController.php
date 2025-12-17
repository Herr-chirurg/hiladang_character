<?php

namespace App\Controller\Admin;

use App\Entity\Character;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Date;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('title');
        yield AssociationField::new('owner')
            ->setCustomOption('field_label', 'username');
        yield IntegerField::new('level');
        yield IntegerField::new('xp_current');
        yield IntegerField::new('xp_current_mj');
        yield IntegerField::new('gp');
        yield IntegerField::new('pr');
        yield DateTimeField::new('end_activity');
        yield TextField::new('webhook_link');
        yield TextField::new('last_action');
        yield TextField::new('last_action_description');

    }

}
