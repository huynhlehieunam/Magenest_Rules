<?php

namespace Magenest\Rules\Controller\Adminhtml\Mrules;

use Magenest\Rules\Model\ResourceModel\Rule\Collection;
use Magenest\Rules\Model\ResourceModel\Rule\CollectionFactory;
use Magenest\Rules\Model\Rule;
use Magenest\Rules\Model\RuleFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;

class TestGetItems extends Action{
    /**
     * @var Json
     */
    private $json;
    /**
     * @var Serialize
     */
    private $serialize;
    /**
     * @var RuleFactory
     */
    private $ruleFactory;
    /**
     * @var ProductMetadata
     */
    private $productMetadata;
    /**
     * @var CollectionFactory
     */
    private $ruleCollectionFactory;

    public function __construct(
        Action\Context $context,
        CollectionFactory $ruleCollectionFactory,
        Serialize $serialize,
        Json $json,
        ProductMetadata $productMetadata
    )
    {
        $this->ruleCollectionFactory = $ruleCollectionFactory;
        $this->serialize = $serialize;
        $this->json = $json;
        $this->productMetadata = $productMetadata;
        parent::__construct($context);
    }

    public function execute()
    {
        $ruleCollection = $this->ruleCollectionFactory->create();
        $allPendingItems = $ruleCollection->getItems();
        foreach ($allPendingItems as $item){
            $data = $item->getData();
            var_dump($data);
        }
    }
}