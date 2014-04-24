<?php

namespace src\Model;

use src\Model\om\BaseProduct;


/**
 * Skeleton subclass for representing a row from the 'product' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.up-sell
 */
class Product extends BaseProduct
{
	static function getProductFromArray($data, $shopDomain)
	{
		$product = new Product();
		$product->setShopDomain($shopDomain);
		$product->setShoploProductId($data['id']);
		$product->setName($data['name']);

		$images = $data['images'];

		if (count($images))
		{
			$firstImage = reset($images);
			$product->setImgUrl($firstImage['src']);
		}

		$product->setThumbnail($data['thumbnail']);
		$product->setDescription($data['description']);

		$variants = $data['variants'];
		$firstVariant = reset($variants);
		$product->setOriginalPrice($firstVariant['price']);

		$variantsData = [];
		if (count($variants) > 0)
		{
			foreach ($variants as $variant)
			{
				$propertyArray = null;

				if (false == intval($variant['availability']) || $variant['id'] == $data['id'])
				{
					continue;
				}

				if ($variant['property_name_1'] != null && $variant['property_name_1'] != '')
				{
					$propertyArray[] = $variant['property_name_1'];
				}

				if ($variant['property_name_2'] != null && $variant['property_name_2'] != '')
				{
					$propertyArray[] = $variant['property_name_2'];
				}

				if ($variant['property_name_3'] != null && $variant['property_name_3'] != '')
				{
					$propertyArray[] = $variant['property_name_3'];
				}

				if (count($propertyArray) > 0)
				{
					$variantsData[$variant['id']] = implode('-', $propertyArray);
				}
			}
		}

		if (count($variantsData) > 0)
		{
			$variantsData = json_encode($variantsData);
		}
		else
		{
			$variantsData = null;
		}
		$product->setVariants($variantsData);


		$product->setUrl($data['url']);
		$product->setSku($firstVariant['sku']);
		$product->save();

		return $product;
	}
}
