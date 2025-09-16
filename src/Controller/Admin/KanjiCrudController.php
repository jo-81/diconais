<?php

namespace App\Controller\Admin;

use App\Entity\Kanji;
use App\Enum\JlptLevelEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class KanjiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Kanji::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(15)
            ->setPageTitle('index', 'Liste des kanji')
            ->setPageTitle('detail', 'Consulter un kanji')
            ->setPageTitle('new', 'Ajouter un kanji')
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
            TextField::new('ideogramme')->setColumns('col-md-6'),
            IntegerField::new('id')
                ->onlyOnDetail()
                ->setLabel('Lien vers le kanji')
                ->setTemplatePath('admin/fields/kanji/kanji_front_link.html.twig')
                ->setColumns('col-md-6'),
            TextField::new('signification')->setColumns('col-md-6'),
            IntegerField::new('numberStroke', 'Nombre de trait')->setColumns('col-md-6'),
            ChoiceField::new('level', 'JLPT')->setColumns('col-md-6'),
            TextField::new('onyomi')
                ->setColumns('col-md-6')
                ->setHelp('Lecture sino-japonaise'),
            TextField::new('kunyomi')
                ->setColumns('col-md-6')
                ->setHelp('Lecture purement japonaise'),
            AssociationField::new('associatedKey', 'Clé(s) associée(s)')
                ->onlyOnForms()
                ->setColumns('col-md-6'),
            AssociationField::new('similars', 'Kanji similaire(s)')
                ->onlyOnForms()
                ->setColumns('col-md-6'),
            AssociationField::new('associatedKey', 'Clé(s) associée(s)')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/kanji/associed_keys.html.twig'),
            AssociationField::new('similars', 'Kanji similaire(s)')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/kanji/similars.html.twig'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        $choices = array_combine(
            array_map(fn ($c) => ucfirst(strtolower($c->name)), JlptLevelEnum::cases()),
            array_map(fn ($c) => $c->value, JlptLevelEnum::cases())
        );

        $choices['Aucun'] = null;

        return $filters
            ->add('ideogramme')
            ->add(ChoiceFilter::new('level')->setChoices($choices))
        ;
    }
}
