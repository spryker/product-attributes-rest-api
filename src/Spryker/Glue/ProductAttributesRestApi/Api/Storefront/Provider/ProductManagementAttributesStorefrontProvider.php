<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ProductAttributesRestApi\Api\Storefront\Provider;

use Generated\Api\Storefront\ProductManagementAttributesStorefrontResource;
use Generated\Shared\Transfer\ProductManagementAttributeFilterTransfer;
use Generated\Shared\Transfer\ProductManagementAttributeTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Client\ProductAttribute\ProductAttributeClientInterface;
use Spryker\Glue\ProductAttributesRestApi\Api\Storefront\Exception\ProductAttributesExceptionFactory;
use Spryker\Service\Serializer\SerializerServiceInterface;

class ProductManagementAttributesStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string URI_VARIABLE_ATTRIBUTE_KEY = 'attributeKey';

    public function __construct(
        protected ProductAttributeClientInterface $productAttributeClient,
        protected SerializerServiceInterface $serializer,
        protected ProductAttributesExceptionFactory $exceptionFactory = new ProductAttributesExceptionFactory(),
    ) {
    }

    protected function provideItem(): object|null
    {
        $attributeKey = $this->getUriVariables()[static::URI_VARIABLE_ATTRIBUTE_KEY] ?? null;

        if ($attributeKey === null || $attributeKey === '') {
            throw $this->exceptionFactory->createAttributeKeyNotSpecifiedException();
        }

        $filterTransfer = (new ProductManagementAttributeFilterTransfer())
            ->setKeys([(string)$attributeKey]);

        $collectionTransfer = $this->productAttributeClient->getProductManagementAttributes($filterTransfer);

        foreach ($collectionTransfer->getProductManagementAttributes() as $attributeTransfer) {
            if ($attributeTransfer->getKey() === $attributeKey) {
                return $this->serializer->denormalize(
                    $this->prepareResourceData($attributeTransfer),
                    ProductManagementAttributesStorefrontResource::class,
                );
            }
        }

        throw $this->exceptionFactory->createAttributeNotFoundException();
    }

    /**
     * @return array<\Generated\Api\Storefront\ProductManagementAttributesStorefrontResource>
     */
    protected function provideCollection(): array
    {
        $filterTransfer = (new ProductManagementAttributeFilterTransfer())
            ->setFilter($this->buildFilterTransfer());

        $collectionTransfer = $this->productAttributeClient->getProductManagementAttributes($filterTransfer);

        $resources = [];
        foreach ($collectionTransfer->getProductManagementAttributes() as $attributeTransfer) {
            $resources[] = $this->serializer->denormalize(
                $this->prepareResourceData($attributeTransfer),
                ProductManagementAttributesStorefrontResource::class,
            );
        }

        return $resources;
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepareResourceData(ProductManagementAttributeTransfer $attributeTransfer): array
    {
        $localizedKeys = [];
        foreach ($attributeTransfer->getLocalizedKeys() as $localizedKeyTransfer) {
            $localizedKeys[] = [
                'localeName' => $localizedKeyTransfer->getLocaleName(),
                'translation' => $localizedKeyTransfer->getKeyTranslation(),
            ];
        }

        $values = [];
        foreach ($attributeTransfer->getValues() as $valueTransfer) {
            $localizedValues = [];
            foreach ($valueTransfer->getLocalizedValues() as $localizedValueTransfer) {
                $localizedValues[] = [
                    'localeName' => $localizedValueTransfer->getLocaleName(),
                    'translation' => $localizedValueTransfer->getTranslation(),
                ];
            }

            $values[] = [
                'value' => $valueTransfer->getValue(),
                'localizedValues' => $localizedValues,
            ];
        }

        return [
            'attributeKey' => $attributeTransfer->getKey(),
            'key' => $attributeTransfer->getKey(),
            'inputType' => $attributeTransfer->getInputType(),
            'isSuper' => $attributeTransfer->getIsSuper() ?? false,
            'allowInput' => $attributeTransfer->getAllowInput() ?? false,
            'localizedKeys' => $localizedKeys,
            'values' => $values,
        ];
    }
}
