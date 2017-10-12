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
     * @var array
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page' => 25,
        '_sort_order' => 'DESC',
        '_sort_by' => 'totalValue',
    ];

    /**
     * @var array
     */
    protected $perPageOptions = [10, 25, 100, 500 ];

    /**
     * @var int
     */
    protected $maxPerPage = 25;

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', null, [
            'label' => 'app.treasure_type.form.title',
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
        ]);
        $listMapper->add('totalCount', null, [
            'label' => 'app.treasure_type.list.totalCount',
        ]);
        $listMapper->add('valueOfOne', null, [
            'label' => 'app.treasure_type.list.valueOfOne',
        ]);
        $listMapper->add('totalValue', null, [
            'label' => 'app.treasure_type.list.totalValue',
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
