<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }


    public function configureFields(string $pageName): iterable
    {
        // qd on veut modifier qu'un seul champ on apelle le parent est on modifie les champs qu'on veux 
        yield from parent::configureFields($pageName);

        yield ChoiceField::new('rate', 'Note')->setChoices([
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
        ])->renderExpanded();
        yield AssociationField::new('movie', 'Film');
        yield AssociationField::new('user', 'Abonné');
    }
}
