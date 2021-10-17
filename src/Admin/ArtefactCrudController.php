<?php

namespace App\Admin;

use App\Entity\Artefact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArtefactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artefact::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            DateField::new('createdAt'),
        ];
    }
}
