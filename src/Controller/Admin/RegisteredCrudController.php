<?php

namespace App\Controller\Admin;

use App\Entity\Registered;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RegisteredCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Registered::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['registerAt' => 'DESC'])
            ->setPaginatorPageSize(10)
            ->setSearchFields(['username'])
            ->setEntityLabelInPlural('utilisateurs')
            ->setEntityLabelInSingular('utilisateur')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex(),
            TextField::new('username', 'Pseudo'),
            EmailField::new('email', 'Adresse email'),
            DateField::new('registerAt', 'Inscription')
                ->hideOnForm()
                ->setTimezone('Europe/Paris')
                ->setFormat('full'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::EDIT, Action::NEW)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('username')
            ->add('registerAt')
        ;
    }
}
