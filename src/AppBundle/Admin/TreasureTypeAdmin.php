<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

/**
 * Class TreasureTypeAdmin
 * @package AppBundle\Admin
 */
class TreasureTypeAdmin extends AbstractAdmin
{

    /**
     * @return string
     */
    public function configure()
    {
        $this->classnameLabel = $this->trans('app.treasure_type.title');
        $this->maxPerPage = 25;
        $this->perPageOptions = [10, 25, 100, 500 ];
        $this->datagridValues = [
            '_page'       => 1,
            '_per_page' => 25,
            '_sort_order' => 'DESC',
            '_sort_by' => 'totalValue',
        ];

        return;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', null, [
            'label' => 'app.treasure_type.form.title',
        ]);
        $formMapper->add('pictureUrl', null, [
            'label' => 'app.treasure_type.form.pictureUrl',
        ]);
        $formMapper->add('description', 'textarea', [
            'label' => 'app.treasure_type.form.description',
            'attr' => [
                'rows' => 5,
            ],
            'required' => false,
        ]);
        $formMapper->add('valueOfOne', null, [
            'label' => 'app.treasure_type.form.valueOfOne',
        ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title', null, [
            'label' => 'app.treasure_type.list.title',
            'header_style' => 'width: 40%',
            'template' => 'AppBundle:treasureType:list_title.html.twig',
        ]);
        $listMapper->add('totalCount', null, [
            'label' => 'app.treasure_type.list.totalCount',
            'header_style' => 'width: 20%',
        ]);
        $listMapper->add('valueOfOne', null, [
            'label' => 'app.treasure_type.list.valueOfOne',
            'header_style' => 'width: 20%',
            'template' => 'AppBundle:treasureType:money.html.twig',
        ]);
        $listMapper->add('totalValue', null, [
            'label' => 'app.treasure_type.list.totalValue',
            'header_style' => 'width: 20%',
            'template' => 'AppBundle:treasureType:money.html.twig',
        ]);
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return [
            $this->trans('app.treasure_type.list.title') => 'title',
            $this->trans('app.treasure_type.list.totalCount') => 'totalCount',
            $this->trans('app.treasure_type.list.valueOfOne') => 'valueOfOne',
            $this->trans('app.treasure_type.list.totalValue') => 'totalValue',
        ];
    }

    /**
     * @param MenuItemInterface   $menu
     * @param string              $action
     * @param AdminInterface|null $childAdmin
     *
     * @return null
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit', 'show'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');

        if ($this->isGranted('EDIT')) {
            $menu->addChild('app.treasure_type.menu.treasure_type', [
                'uri' => $admin->generateUrl('edit', array('id' => $id))
            ]);
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('app.treasure_type.menu.transactions', array(
                'uri' => $admin->generateUrl('app.admin.transaction.list', ['id' => $id]),
            ));
        }

        return;
    }
}
