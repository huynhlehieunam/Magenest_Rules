<?php

namespace Magenest\Rules\Controller\Adminhtml\Mrules;

use Magenest\Rules\Model\ResourceModel\Rule\Collection;
use Magenest\Rules\Model\ResourceModel\Rule\CollectionFactory;
use Magenest\Rules\Model\Rule;
use Magenest\Rules\Model\RuleFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Magenest\Rules\Controller\Adminhtml\Mrules
 */
class Create extends Action{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * Index constructor.
     * @param Action\Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
       return $this->pageFactory->create();
    }
}