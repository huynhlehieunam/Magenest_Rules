<?php

namespace Magenest\Rules\Observer;

use Magenest\Rules\Model\ResourceModel\Rule\Collection;
use Magenest\Rules\Model\ResourceModel\Rule\CollectionFactory;
use Magenest\Rules\Model\Rule;
use Magenest\Rules\Model\RuleFactory;
use Magento\Framework\DB\Select;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

class LogTimeAfterSave  implements ObserverInterface{
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var RuleFactory
     */
    private $ruleModelFactory;
    /**
     * @var CollectionFactory
     */
    private $ruleCollectionFactory;
    /**
     * @var Select
     */
    private $select;

    public function __construct(
        TimezoneInterface $timezone,
        RuleFactory $ruleModelFactory,
        CollectionFactory $ruleCollectionFactory

    )
    {
        $this->timezone = $timezone;
        $this->ruleModelFactory = $ruleModelFactory;
        $this->ruleCollectionFactory = $ruleCollectionFactory;
    }


    public function execute(Observer $observer)
    {
        /** @var Rule $rule */
        $rule = $observer->getData('object');
        $id = $rule->getId();
        $current = $this->timezone->date()->format("Y-m-d H:i:s");
        $ruleCollection = $this->ruleCollectionFactory->create();
        $ruleCollection->getConnection()
            ->update(
                $ruleCollection->getResource()->getTable('magenest_rules'),
                ['updated_at'=>$current],
                ['id = ?'=>$id]
            );
    }
}