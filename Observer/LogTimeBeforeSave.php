<?php

namespace Magenest\Rules\Observer;

use Magenest\Rules\Model\Rule;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Psr\Log\LoggerInterface;

class LogTimeBeforeSave  implements ObserverInterface{
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(TimezoneInterface $timezone, LoggerInterface $logger)
    {
        $this->timezone = $timezone;
        $this->logger = $logger;
    }
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {

    }
}