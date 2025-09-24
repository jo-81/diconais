<?php

namespace App\Controller\Admin;

use App\Entity\Vocabulary;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VocabularyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vocabulary::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(15)
            ->setPageTitle('index', 'Liste des mots de vocabulaire')
            ->setPageTitle('detail', 'Consulter un mot de vocabulaire')
            ->setPageTitle('new', 'Ajouter un mot de vocabulaire')
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('signification')
                ->setColumns('col-12 col-md-6'),
            TextField::new('reading', 'Lecture')
                ->setHelp('Si le contenue de contient pas que des kanji alors laisser ce champs vide.')
                ->setColumns('col-12 col-md-6'),
            TextField::new('romaji')
                ->setColumns('col-12 col-md-6'),
            AssociationField::new('theme')
                ->setColumns('col-12 col-md-6'),
            ArrayField::new('kanjis')
                ->onlyOnIndex()
                ->setTemplatePath('admin/fields/vocabulary/kanjis.html.twig'),
            ArrayField::new('kanjis')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/vocabulary/kanjis_detail.html.twig')
                ->setColumns('col-12 col-md-6'),
            AssociationField::new('kanjis')->onlyOnForms()
                ->setColumns('col-12 col-xl-6'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('signification')
            ->add('reading')
            ->add('theme')
            ->add('kanjis')
        ;
    }
}
