<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MovieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }


    public function configureFields(string $pageName): iterable
    {

        // récupère le mapping d'upload d'image dans la config
        $mappingsParams = $this->getParameter('vich_uploader.mappings');

        $moviesImagePath = $mappingsParams['movies']['uri_prefix'];


        yield   TextField::new('name', 'Nom');
        // textArea permet d'afficher l'image a dimension ds le formulaire
        yield TextareaField::new('imageFile', 'Affiche')->setFormType(VichImageType::class)->hideOnIndex();
        yield  ImageField::new('imageName')->setBasePath($moviesImagePath)->hideOnForm();
        yield   DateField::new('release_year', 'Date de sortie');
        yield   TextEditorField::new('synopsys', 'synopsis');
        yield   TimeField::new('duration', 'Durée');
        yield   AssociationField::new('directors', 'Réalisateurs');
        yield   AssociationField::new('genres', 'Genres');
    }
}
