<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\TreasureType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class TransactionAdmin
 * @package AppBundle\Admin
 */
class TransactionAdmin extends AbstractAdmin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'date',
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('date', null, [
            'label' => 'app.transaction.form.date',
        ]);
        $formMapper->add('treasureType', 'entity', [
            'class' => TreasureType::class,
            'label' => 'app.transaction.form.treasureType',
            'choice_label' => 'title',
        ]);
        $formMapper->add('transactionType', 'choice', [
            'choices' => array_combine(
                Transaction::getTransactionTypeNames(),
                array_keys(Transaction::getTransactionTypeNames())
            ),
            'label' => 'app.transaction.form.transactionType',
        ]);
        $formMapper->add('amount', null, [
            'label' => 'app.transaction.form.amount',
        ]);
        $formMapper->add('comment', 'textarea', [
            'label' => 'app.transaction.form.comment',
            'attr' => [
                'rows' => 5,
            ],
            'required' => false,
        ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('id', null, [
            'label' => 'app.transaction.list.id',
        ]);
        $listMapper->add('date', null, [
            'label' => 'app.transaction.list.date',
        ]);
        $listMapper->add('transactionType', 'choice', [
            'label' => 'app.transaction.list.transactionType',
            'choices' => Transaction::getTransactionTypeNames(),
            'catalogue' => 'messages',
        ]);
        $listMapper->add('amount', null, [
            'label' => 'app.transaction.list.amount',
        ]);
        $listMapper->add('treasureType.title', null, [
            'label' => 'app.transaction.list.treasureType',
        ]);
    }
}
