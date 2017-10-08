<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TreasureType
 *
 * @ORM\Table(name="treasure_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TreasureTypeRepository")
 */
class TreasureType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Transaction[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Transaction", mappedBy="treasureType")
     */
    private $transactions;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     *
     * @Assert\Length(max = "255")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @Assert\Length(max = "10000")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="valueOfOne", type="decimal", precision=10, scale=2)
     *
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value = 0)
     * @Assert\Type(type = "numeric")
     */
    private $valueOfOne;

    /**
     * @var int
     */
    private $totalCount;

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
     * Set title
     *
     * @param string $title
     *
     * @return TreasureType
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TreasureType
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set valueOfOne
     *
     * @param string $valueOfOne
     *
     * @return TreasureType
     */
    public function setValueOfOne($valueOfOne)
    {
        $this->valueOfOne = $valueOfOne;

        return $this;
    }

    /**
     * Get valueOfOne
     *
     * @return string
     */
    public function getValueOfOne()
    {
        return $this->valueOfOne;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->transactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     *
     * @return TreasureType
     */
    public function addTransaction(\AppBundle\Entity\Transaction $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param \AppBundle\Entity\Transaction $transaction
     */
    public function removeTransaction(\AppBundle\Entity\Transaction $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection|\AppBundle\Entity\Transaction[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        if ($this->totalCount === null) {
            $totalCount = 0;
            foreach ($this->getTransactions() as $transaction) {
                if ($transaction->getTransactionType() == Transaction::TYPE_DEBIT) {
                    $totalCount -= $transaction->getAmount();
                } else {
                    $totalCount += $transaction->getAmount();
                }
            }
            $this->totalCount = $totalCount;
        }
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return float
     */
    public function getTotalValue()
    {
        return $this->getTotalCount() * $this->getValueOfOne();
    }
}
