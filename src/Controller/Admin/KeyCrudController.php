<?php

namespace App\Controller\Admin;

use App\Entity\Key;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KeyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Key::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['number' => 'ASC'])
            ->setPaginatorPageSize(15)
            ->setEntityLabelInPlural('clés')
            ->setEntityLabelInSingular('clé')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('detail', fn (Key $key) => sprintf('La clé n° %s', $key->getNumber()))
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            IntegerField::new('number', 'Numéro'),
            TextField::new('ideogramme'),
            TextField::new('signification'),
            TextField::new('kunyomi'),
            IntegerField::new('numberStroke', 'Nombre de traits'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE, Action::EDIT, Action::NEW)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('ideogramme')
            ->add('signification')
            ->add('number')
            ->add('numberStroke')
        ;
    }
}
