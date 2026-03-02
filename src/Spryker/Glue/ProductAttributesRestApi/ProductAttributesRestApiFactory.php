<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductAttributesRestApi;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\ProductAttributesRestApi\Dependency\Client\ProductAttributesRestApiToProductAttributeClientInterface;
use Spryker\Glue\ProductAttributesRestApi\Processor\Builder\RestProductAttributeResponseBuilder;
use Spryker\Glue\ProductAttributesRestApi\Processor\Builder\RestProductAttributeResponseBuilderInterface;
use Spryker\Glue\ProductAttributesRestApi\Processor\Formatter\MultiSelectAttributeFormatter;
use Spryker\Glue\ProductAttributesRestApi\Processor\Formatter\MultiSelectAttributeFormatterInterface;
use Spryker\Glue\ProductAttributesRestApi\Processor\Mapper\ProductAttributeMapper;
use Spryker\Glue\ProductAttributesRestApi\Processor\Mapper\ProductAttributeMapperInterface;
use Spryker\Glue\ProductAttributesRestApi\Processor\Reader\ProductAttributeReader;
use Spryker\Glue\ProductAttributesRestApi\Processor\Reader\ProductAttributeReaderInterface;

/**
 * @method \Spryker\Glue\ProductAttributesRestApi\ProductAttributesRestApiConfig getConfig()
 */
class ProductAttributesRestApiFactory extends AbstractFactory
{
    public function createProductAttributeReader(): ProductAttributeReaderInterface
    {
        return new ProductAttributeReader(
            $this->getProductAttributeClient(),
            $this->createRestProductAttributeResponseBuilder(),
        );
    }

    public function createRestProductAttributeResponseBuilder(): RestProductAttributeResponseBuilderInterface
    {
        return new RestProductAttributeResponseBuilder(
            $this->getResourceBuilder(),
            $this->createProductAttributeMapper(),
        );
    }

    public function createProductAttributeMapper(): ProductAttributeMapperInterface
    {
        return new ProductAttributeMapper();
    }

    public function createMultiSelectAttributeFormatter(): MultiSelectAttributeFormatterInterface
    {
        return new MultiSelectAttributeFormatter();
    }

    public function getProductAttributeClient(): ProductAttributesRestApiToProductAttributeClientInterface
    {
        return $this->getProvidedDependency(ProductAttributesRestApiDependencyProvider::CLIENT_PRODUCT_ATTRIBUTE);
    }
}
