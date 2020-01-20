<?php
namespace Magenest\Rules\Model\ResourceModel;


class Rule extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const   TABLE_NAME = 'magenest_rules';
    const   INDEX_NAME = 'id';

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME,self::INDEX_NAME);
    }
}