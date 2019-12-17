<?php
namespace Magenest\Rules\Model;

class Rule extends \Magento\Framework\Model\AbstractModel
{
    protected $_eventPrefix = 'model_rules';
    protected function _construct()
    {
        $this->_init(\Magenest\Rules\Model\ResourceModel\Rule::class);
    }
}