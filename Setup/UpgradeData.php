<?php

namespace Magenest\Rules\Setup;

use Magenest\Rules\DataConverter\JsonToSerialize;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\DB\DataConverter\SerializedToJson;
use Magento\Framework\DB\FieldDataConversionException;
use Magento\Framework\DB\FieldDataConverter;
use Magento\Framework\DB\FieldDataConverterFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    const TABLE_NAME = 'magenest_rules';
    const TABLE_INDEX_NAME = 'id';
    const TABLE_SERIALIZE_FIELD_NAME = 'condition_serialized';
    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;
    /**
     * @var FieldDataConverterFactory
     */
    private $fieldDataConverterFactory;

    public function __construct(
                                ProductMetadataInterface $productMetadata,
                                FieldDataConverterFactory $fieldDataConverterFactory)
    {
        $this->productMetadata = $productMetadata;
        $this->fieldDataConverterFactory = $fieldDataConverterFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $currentVersion = $this->productMetadata->getVersion();
        $compareVersion = '2.2';

        if (version_compare($currentVersion, $compareVersion, '<')) {
            $this->convertData($setup,true);
        } else {
            $this->convertData($setup,false);
        }
    }

    private function convertData(ModuleDataSetupInterface $setup,$isConvertJsonToSerialize)
    {
        /** @var FieldDataConverter $converter */

       if ($isConvertJsonToSerialize == true){
           $converter = $this->fieldDataConverterFactory->create(JsonToSerialize::class);
       }else{
           $converter = $this->fieldDataConverterFactory->create(SerializedToJson::class);
       }

        try {
            $converter->convert(
                $setup->getConnection(),
                $setup->getTable(self::TABLE_NAME),
                self::TABLE_INDEX_NAME,
                self::TABLE_SERIALIZE_FIELD_NAME
            );
        } catch (FieldDataConversionException $e) {
           echo $e->getMessage();
           return;
        }

        echo "\nData is converted";
       return;
    }
}
