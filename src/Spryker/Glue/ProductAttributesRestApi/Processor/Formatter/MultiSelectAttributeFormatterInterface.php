<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductAttributesRestApi\Processor\Formatter;

use Generated\Shared\Transfer\AbstractProductsRestAttributesTransfer;
use Generated\Shared\Transfer\ConcreteProductsRestAttributesTransfer;

interface MultiSelectAttributeFormatterInterface
{
    public function formatAbstractMultiSelectAttributesToString(
        AbstractProductsRestAttributesTransfer $abstractProductsRestAttributesTransfer
    ): AbstractProductsRestAttributesTransfer;

    public function formatConcreteMultiSelectAttributesToString(
        ConcreteProductsRestAttributesTransfer $concreteProductsRestAttributesTransfer
    ): ConcreteProductsRestAttributesTransfer;
}
