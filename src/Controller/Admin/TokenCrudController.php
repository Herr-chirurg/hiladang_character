<?php

namespace App\Controller\Admin;

use App\Entity\Token;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TokenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Token::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield TextField::new('type');
        yield IntegerField::new('usage_rate');
        yield IntegerField::new('totalPr');
        yield IntegerField::new('usage_rate');
        yield DateTimeField::new('date_of_reception');
        yield AssociationField::new('character')
            ->setCustomOption('field_label', 'name');
        yield AssociationField::new('owner_user')
            ->setCustomOption('field_label', 'username');

    }

}
