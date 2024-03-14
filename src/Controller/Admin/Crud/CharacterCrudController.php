<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Character;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CharacterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Character::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prenom'),
            IntegerField::new('height', 'Taille'),
            DateField::new('birthdate', 'Date de naissance'),
            TextField::new('hairColor', 'Couleur de cheveux'),
            TextField::new('astrologicalSign', 'Signe astrologique'),
            TextField::new('programmingLanguage', 'Langage de programmation'),
            AssociationField::new('anecdotes', 'Anecdotes'),
            AssociationField::new('images', 'Photos'),
        ];
    }
}
