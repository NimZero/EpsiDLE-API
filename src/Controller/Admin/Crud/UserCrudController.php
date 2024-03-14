<?php

namespace App\Controller\Admin\Crud;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firebaseUUID')->setDisabled(),
            TextField::new('name')->setDisabled(),
            EmailField::new('email')->setDisabled(),
            ChoiceField::new('roles')->setFormTypeOptions(['multiple' => true])->setChoices([
                'Admin' => 'ROLE_ADMIN',
            ]),
        ];
    }
}
