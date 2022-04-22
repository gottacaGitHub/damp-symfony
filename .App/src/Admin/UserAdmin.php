<?php

namespace App\Admin;

use App\Entity\Products;
use App\Form\DataTransformer\RolesDataTransformer;
use App\Model\Roles;
use JsonException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\FieldDescription\FieldDescriptionInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Security\Core\Role\Role;

class UserAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {

    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id',null,['label'=>'ID'])
            ->addIdentifier('email',null,['label'=>'Логин'])
            ->addIdentifier('fio',null,['label'=>'ФИО'])
            ->add('role',FieldDescriptionInterface::TYPE_CHOICE,[
                'choices' => Roles::choices(),
                'data_transformer' => new RolesDataTransformer(),
                'label'=>'Роль'])
            ->add('isSuspended', null, ['required' => false, 'label' => 'Активность'])
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('id',null,['label'=>'ID','disabled'=>true])
            ->add('email',null,['label'=>'Логин'])
            ->add('plainPassword', TextType::class, [
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                'label'=> 'Пароль'
            ])
            ->add('fio',null,['label'=>'ФИО'])
            ->add('role',ChoiceType::class,[
                'choices' => [
                    'ROLE_MANAGER',
                    'ROLE_ADMIN'],
                'choice_label' => function ($choice, $key, $value)
                {
                    if ('ROLE_MANAGER' === $choice)
                        return 'Менеджер';
                    if ('ROLE_ADMIN' === $choice)
                        return 'Администратор';
                },
                'label'=>'Роль'])
            ->add('isSuspended', null, ['required' => false, 'label' => 'Активность']);
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id',null,['label'=>'ID','disabled'=>true])
            ->add('email',null,['label'=>'Логин'])
            ->add('fio',null,['label'=>'ФИО'])
            ->add('role',FieldDescriptionInterface::TYPE_CHOICE,[
                'choices' => Roles::choices(),
                'data_transformer' => new RolesDataTransformer(),
                'label'=>'Роль'])
            ->add('isSuspended', null, ['required' => false, 'label' => 'Активность']);
    }


    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        if ($this->isGranted('ROLE_MANAGER'))
        {
            $collection->clearExcept(['list', 'show','edit','create','delete']);
        }

    }

    public function toString(object $object): string
    {
        return $object instanceof User
            ? $object->getName()
            : 'Пользователь';
    }
}