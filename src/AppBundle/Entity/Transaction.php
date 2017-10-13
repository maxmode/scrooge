<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionRepository")
 */
class Transaction
{
    const TYPE_DEBIT = 1;
    const TYPE_CREDIT = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var TreasureType
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\TreasureType", inversedBy="transactions")
     * @ORM\JoinColumn(name="treasureTypeId", referencedColumnName="id")
     *
     * @Assert\NotBlank()
     */
    private $treasureType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     *
     * @Assert\NotBlank()
     * @Assert\LessThanOrEqual("today")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     *
     * @Assert\Type(type = "integer")
     * @Assert\GreaterThan(value = 0)
     * @Assert\NotBlank()
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="transactionType", type="integer")
     *
     * @Assert\NotBlank()
     */
    private $transactionType;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     *
     * @Assert\Length(max = "255")
     */
    private $comment;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set transactionType
     *
     * @param integer $transactionType
     *
     * @return Transaction
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return int
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Transaction
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set treasureType
     *
     * @param \AppBundle\Entity\TreasureType $treasureType
     *
     * @return Transaction
     */
    public function setTreasureType(\AppBundle\Entity\TreasureType $treasureType = null)
    {
        $this->treasureType = $treasureType;

        return $this;
    }

    /**
     * Get treasureType
     *
     * @return \AppBundle\Entity\TreasureType
     */
    public function getTreasureType()
    {
        return $this->treasureType;
    }

    /**
     * @return array
     */
    public static function getTransactionTypeNames()
    {
        return [
            static::TYPE_CREDIT => 'app.transaction.type.credit',
            static::TYPE_DEBIT => 'app.transaction.type.debit',
        ];
    }

    /**
     * @return bool
     *
     * @Assert\IsTrue(message = "app.transaction.error.not_enough_founds")
     */
    public function isEnoughForAmmountForTransaction()
    {
        if (!$this->getId()
            && $this->getTransactionType() == static::TYPE_DEBIT
            && $this->getAmount() > $this->getTreasureType()->getTotalCount()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getTransactionTypeCode()
    {
        if ($this->getTransactionType() == static::TYPE_CREDIT) {
            return 'CREDIT';
        } else {
            return 'DEBIT';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
