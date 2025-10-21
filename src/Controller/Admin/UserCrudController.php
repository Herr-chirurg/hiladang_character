<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        $roles = [
            'User' => 'ROLE_USER',
            'Gamemaster' => 'ROLE_GAMEMASTER',
            'Architect' => 'ROLE_ARCHITECT',
            'Administrator' => 'ROLE_ADMIN',
            'Super Admin' => 'ROLE_SUPER_ADMIN',
        ];

        $rolesFiled = ChoiceField::new('roles');

        yield IdField::new('id');
        yield TextField::new('username');
        yield NumberField::new('nb_character_max');

        yield ChoiceField::new('roles')
            // 2. Pass the list of available choices (key is displayed, value is stored)
            ->setChoices($roles)

            // 3. IMPORTANT: Tell the underlying form type that this field can hold multiple values (an array)
            ->setFormTypeOption('multiple', true)

            // 4. Optional: Render the roles as badges/tags in the list view
            ->renderAsBadges();

    }

}
