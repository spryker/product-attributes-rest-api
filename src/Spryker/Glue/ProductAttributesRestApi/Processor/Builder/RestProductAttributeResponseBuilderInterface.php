<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductAttributesRestApi\Processor\Builder;

use Generated\Shared\Transfer\ProductManagementAttributeCollectionTransfer;
use Generated\Shared\Transfer\ProductManagementAttributeFilterTransfer;
use Generated\Shared\Transfer\ProductManagementAttributeTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestProductAttributeResponseBuilderInterface
{
    public function createProductAttributeListRestResponse(
        ProductManagementAttributeFilterTransfer $productManagementAttributeFilterTransfer,
        ProductManagementAttributeCollectionTransfer $productManagementAttributeCollectionTransfer
    ): RestResponseInterface;

    public function createProductAttributeRestResponse(ProductManagementAttributeTransfer $productManagementAttributeTransfer): RestResponseInterface;

    public function createProductAttributeNotFoundErrorResponse(): RestResponseInterface;
}
