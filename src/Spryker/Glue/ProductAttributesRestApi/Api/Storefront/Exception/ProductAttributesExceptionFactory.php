<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ProductAttributesRestApi\Api\Storefront\Exception;

use Spryker\ApiPlatform\Exception\GlueApiException;
use Symfony\Component\HttpFoundation\Response;

class ProductAttributesExceptionFactory
{
    protected const string ERROR_CODE_ATTRIBUTE_NOT_FOUND = '4201';

    protected const string ERROR_MESSAGE_ATTRIBUTE_NOT_FOUND = 'Attribute not found.';

    protected const string ERROR_MESSAGE_ATTRIBUTE_KEY_NOT_SPECIFIED = 'Attribute key is not specified.';

    public function createAttributeKeyNotSpecifiedException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            static::ERROR_CODE_ATTRIBUTE_NOT_FOUND,
            static::ERROR_MESSAGE_ATTRIBUTE_KEY_NOT_SPECIFIED,
        );
    }

    public function createAttributeNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            static::ERROR_CODE_ATTRIBUTE_NOT_FOUND,
            static::ERROR_MESSAGE_ATTRIBUTE_NOT_FOUND,
        );
    }
}
