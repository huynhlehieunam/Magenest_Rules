<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magenest\Rules\DataConverter;

use Magento\Framework\DB\DataConverter\DataConversionException;
use Magento\Framework\DB\DataConverter\DataConverterInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;

/**
 * Convert from serialized to JSON format
 */
class JsonToSerialize implements DataConverterInterface
{
    /**
     * @var Serialize
     */
    private $serialize;

    /**
     * @var Json
     */
    private $json;

    /**
     * Constructor
     *
     * @param Serialize $serialize
     * @param Json $json
     */
    public function __construct(
        Serialize $serialize,
        Json $json
    ) {
        $this->serialize = $serialize;
        $this->json = $json;
    }

    /**
     * Convert from serialized to JSON format
     *
     * @param string $value
     * @return string
     * @throws DataConversionException
     */
    public function convert($value)
    {
        return $this->convertJsonToSerialize($value);
    }


    private function convertJsonToSerialize($value)
    {
        $data = $this->json->unserialize($value);
        return $this->serialize->serialize($data);
    }

}
