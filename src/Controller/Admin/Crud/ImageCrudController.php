<?php

namespace App\Controller\Admin\Crud;

use App\Entity\Image;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('character'),
            ImageField::new('path')->setBasePath('uploads/images')->setUploadDir('public/uploads/images'),
        ];
    }
}
