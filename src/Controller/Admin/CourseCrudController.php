<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * @extends AbstractCrudController<Course>
 */
class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(10)
            ->setSearchFields(['name'])
            ->setEntityLabelInPlural('cours')
            ->setEntityLabelInSingular('cours')
            ->setPageTitle('index', 'Liste des %entity_label_plural%')
            ->setPageTitle('detail', fn (Course $course) => sprintf('%s', ucfirst($course->getName())))
            ->setPageTitle('new', 'Ajouter un %entity_label_singular%')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('slug')
                ->onlyOnDetail()
                ->setLabel('Lien vers le cours')
                ->setTemplatePath('admin/fields/course/course_front_link.html.twig'),
            TextField::new('name', 'Titre')
                ->setColumns('col-12 col-sm-6 col-md-4'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex()
                ->setColumns('col-12 col-sm-6 col-md-4'),
            DateField::new('createdAt', 'Date de publication')->hideOnForm(),
            AssociationField::new('category', 'Catégorie')
                ->setColumns('col-12 col-md-4'),
            BooleanField::new('published', 'Publié ?'),
            TextEditorField::new('content', 'Contenue du cours')
                ->hideOnIndex()
                ->setColumns('col-12'),
        ];
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('published')
            ->add('category')
            ->add('createdAt')
        ;
    }
}
