<?php
namespace Magenest\Rules\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    const TABLE_NAME = 'magenest_rules';
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.1.0', '<')) {
            $this->setUpRulesTable($installer);
        }

        if (version_compare($context->getVersion(),'1.1.2','<')){
            $this->addFieldUpdate($installer);
        }

        $installer->endSetup();
    }

    public function setUpRulesTable(SchemaSetupInterface $installer)
    {
        if(!$installer->getConnection()->isTableExists(self::TABLE_NAME)){
            $table = $installer->getConnection()->newTable(
                $installer->getTable(self::TABLE_NAME)
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                [
                    'auto_increment' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true
                ],
                'ID'
            )->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                50,
                [
                    'nullable' => false
                ],
                'Title'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                10,
                [
                    'nullable' => false
                ],
                'Status'
            )->addColumn(
                'rule_type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                11,
                [
                    'nullable' => false
                ],
                'Rule Type'
            )->addColumn(
                'condition_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [
                    'nullable' => true
                ],
                'Conditions'
            )->setComment('Rules ');

            $installer->getConnection()->createTable($table);
        }
    }

    private function addFieldUpdate(SchemaSetupInterface $installer)
    {
        if($installer->getConnection()->isTableExists(self::TABLE_NAME)){
            $installer->getConnection()->addColumn(
                $installer->getTable(self::TABLE_NAME),
                'updated_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'nullable' => true,
                    'comment' => 'updated at'
                ]);
        }
    }

}
