<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Transaction;
use AppBundle\Entity\TreasureType;
use Exporter\Source\DoctrineORMQuerySourceIterator;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
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
        '_per_page' => 25,
        '_sort_order' => 'DESC',
        '_sort_by' => 'date',
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
        $today = new \DateTime();
        $formMapper->add('date', 'sonata_type_date_picker', [
            'label' => 'app.transaction.form.date',
            'data' => $this->getSubject()->getDate() ? $this->getSubject()->getDate() : $today,
            'dp_max_date' => $today->format('Y-m-d'),
            'format' => 'yyyy-MM-dd',
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
            'format' => 'Y-m-d',
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

    /**
     * @return array
     */
    public function getExportFields()
    {
        return [
            $this->trans('app.transaction.list.id') => 'id',
            $this->trans('app.transaction.list.date') => 'date',
            $this->trans('app.transaction.list.transactionType') => 'transactionTypeCode',
            $this->trans('app.transaction.list.amount') => 'amount',
            $this->trans('app.transaction.list.treasureType') => 'treasureType.title',
        ];
    }

    /**
     * @return \Exporter\Source\SourceIteratorInterface
     */
    public function getDataSourceIterator()
    {
        /** @var DoctrineORMQuerySourceIterator $iterator */
        $iterator = parent::getDataSourceIterator();
        $iterator->setDateTimeFormat('Y-m-d');
        return $iterator;
    }
}
