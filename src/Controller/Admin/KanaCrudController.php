<?php

namespace App\Controller\Admin;

use App\Entity\Kana;
use App\Enum\KanaTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KanaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Kana::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['position' => 'ASC'])
            ->setPaginatorPageSize(10)
            ->setSearchFields(['name'])
            ->setEntityLabelInPlural('kana')
            ->setEntityLabelInSingular('kana')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter');
            })
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('ideogramme')->setColumns('col-sm-6 col-md-4'),
            ChoiceField::new('type')->setColumns('col-sm-6 col-md-4'),
            IntegerField::new('position')->setColumns('col-md-4'),
            TextField::new('romaji')->setColumns('col-sm-6'),
            TextField::new('kunrei')->setColumns('col-sm-6'),
            BooleanField::new('accent')->setColumns('col-6'),
            BooleanField::new('combination', 'Combinaison')->setColumns('col-6'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        $choices = array_combine(
            array_map(fn ($c) => ucfirst(strtolower($c->name)), KanaTypeEnum::cases()),
            array_map(fn ($c) => $c->value, KanaTypeEnum::cases())
        );

        return $filters
            ->add('ideogramme')
            ->add('accent')
            ->add('combination')
            ->add(ChoiceFilter::new('type')->setChoices($choices))
        ;
    }
}
