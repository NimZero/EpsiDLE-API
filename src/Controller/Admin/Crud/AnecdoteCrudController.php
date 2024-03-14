<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Anecdote;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class AnecdoteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Anecdote::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('character'),
            TextareaField::new('text'),
        ];
    }
}
