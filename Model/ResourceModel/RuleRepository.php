<?php

class RuleRepository implements RulesRepositoryInterface{
    /**
     * @var \Magenest\Rules\Model\ResourceModel\RuleFactory
     */
    private $ruleModelFactory;
    /**
     * @var \Magenest\Rule\Helper\Cache
     */
    private $cacheHelper;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Serialize
     */
    private $serialize;

    public function __construct(
        \Magenest\Rules\Model\ResourceModel\RuleFactory $ruleModelFactory,
        \Magenest\Rule\Helper\Cache $cache,
        \Magento\Framework\Serialize\Serializer\Serialize $serialize
)
    {
        $this->ruleModelFactory = $ruleModelFactory;
        $this->cacheHelper = $cache;
        $this->serialize = $serialize;
    }

    public function load($ruleId)
    {
        if ($cachedRule = $this->cacheHelper->load($ruleId)){
            return $this->serialize->unserialize($cachedRule);
        }else{
            /** @var \Magenest\Rules\Model\ResourceModel\Rule $needCachedRule */
            $needCachedRule =  $this->ruleModelFactory->create()->load($ruleId);
            $this->cacheHelper->save($needCachedRule,$ruleId);
        }
    }

    public function save(\Magenest\Rules\Model\ResourceModel\Rule $rule)
    {
        if (!$rule->getId()){
            $rule->save();
            $this->cacheHelper->save($this->serialize->serialize($rule),$rule->getId());
            return $rule;
        }
        throw new Exception("Rule has been saved.", "RULE_EXISTED");
    }

    public function delete(\Magenest\Rules\Model\ResourceModel\Rule $rule)
    {
        if ($rule->getId()){
            try {
                $rule->delete();
                $this->cacheHelper->remove($rule->getId());
                return $rule;
            } catch (Exception $e) {
                throwException($e);
            }
        }
        throw new Exception("Rule does not exist in the database.","RULE_NOT_FOUND");
    }
}