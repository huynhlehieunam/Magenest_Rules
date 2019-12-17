<?php

namespace Magenest\Rules\Controller\Adminhtml\Mrules;

use Magenest\Rules\Model\RuleFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\ProductMetadata;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;

class TestSaveRule extends Action{
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

    public function __construct(
        Action\Context $context,
        RuleFactory $ruleFactory,
        Serialize $serialize,
        Json $json,
        ProductMetadata $productMetadata
    )
    {
        $this->ruleFactory = $ruleFactory;
        $this->serialize = $serialize;
        $this->json = $json;
        $this->productMetadata = $productMetadata;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = [
            'title' => 'Test',
            'status' => 'pending',
            'rule_type' => 100000,
            'condition_serialized'=>'test'
        ];
       $result = $this->createRule($data);
       if ($result){
           echo "Data saved!";
       }else{
           echo "Failed.";
       }
       
    }

    private function createRule($data)
    {
        $condition = [
            'a'=>'aaa',
            'b'=>'daaa',
        ];

        if (version_compare($this->productMetadata->getVersion(),'2.2','<')){
            $condition = $this->serialize->serialize($condition);
        }else{
            $condition = $this->json->serialize($condition);
        }

        $data['condition_serialized'] = $condition;
        $newRule = $this->ruleFactory->create();

        try {
            $newRule->setData($data);
            $newRule->save();
            return $newRule;
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo "\n";
            return false;
        }
    }
}