<?php

namespace App\Controller\Admin;

use App\Entity\AppCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AppCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AppCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('App Category')
            ->setEntityLabelInPlural('App Categories')
            ->setDefaultSort(['id' => 'DESC']);
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
