<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Products;
use JsonException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Security;


final class ProductsAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {

    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->addIdentifier('id',null,['label'=>'ID'])
            ->addIdentifier('name',null,['label'=>'Наименование'])
            ->addIdentifier('code',null,['label'=>'Символьный код'])
            ->add('status',null,['label'=>'Акт'])
            ->add('sort',null,['label'=>'Сортировка'])
            ->add('tags',null,['label'=>'Тегирование'])
            ->add('filename', FieldDescriptionInterface::TYPE_HTML,['label'=>'Изображение','template' => 'image.html.twig'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }


    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('id',null,['label'=>'ID','disabled'=>true])
            ->add('name',null,['label'=>'Наименование'])
            ->add('code',null,['label'=>'Символьный код'])
            ->add('status',null,['label'=>'Акт'])
            ->add('sort',null,['label'=>'Сортировка'])
            ->add('tags', null,['label'=>'Тегирование'])
            ->add('file', FileType::class, $this->view(),['label'=>'Изображение']);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->with('')
                ->add('id',null,['label'=>'ID','disabled'=>true])
                ->add('name',null,['label'=>'Наименование'])
                ->add('code',null,['label'=>'Символьный код'])
                ->add('status',null,['label'=>'Акт'])
                ->add('sort',null,['label'=>'Сортировка'])
                ->add('tags', null,['label'=>'Тегирование'])
            ->end()
            ->with('')
                ->add('filename', FieldDescriptionInterface::TYPE_HTML,['label'=>'Изображение','template' => 'showImage.html.twig'])
            ->end()
        ;
    }

    public function prePersist(object $image): void
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate(object $image): void
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload(object $image): void
    {

        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
//        dd($user = $this->getConfigurationPool()->getAdminServiceIds());
        if ($this->isGranted('ROLE_MANAGER'))
        {
            $collection->clearExcept(['list', 'show','edit','create','delete']);
        }
    }

    private function view():array
    {
        $image = $this->getSubject();
        $fileFormOptions = ['required' => false];

        if ($image->getId() && ($webPath = $image->getWebPath())) {
            $request = $this->getRequest();
            $fullPath = $request->getBasePath().'/'.$webPath;
            $fileFormOptions['help'] = '<img width="400" height="auto" src="'.$fullPath.'"/>';
            $fileFormOptions['help_html'] = true;
        }
        return $fileFormOptions;
    }



    public function toString(object $object): string
    {
        return $object instanceof Products
            ? $object->getName()
            : 'Продукт';
    }

}
