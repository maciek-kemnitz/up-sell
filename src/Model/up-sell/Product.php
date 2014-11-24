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
		$product->setShoploProductId($firstVariant['id']);
		$product->setOriginalPrice($firstVariant['price']/100);

		$variantsData = [];
		if (count($variants) > 0)
		{
			foreach ($variants as $variant)
			{
				$propertyArray = null;

				if (false == intval($variant['availability']))
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
					$variantsData[$variant['id']]['var_type'] = implode('-', $propertyArray);
					$variantsData[$variant['id']]['price'] = $variant['price']/100;
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
		$product->setAvailability((int) $firstVariant['availability']);
		$product->setOriginalPrice((int) $firstVariant['price_regular']/100);
		$product->setCurrentPrice((int) $firstVariant['price']/100);
		$product->save();

		return $product;
	}

	public static function updateProductFromArray($data, $shopId)
	{
		$upSell = UpSellQuery::create()->findOneByShopId($shopId);
		if (null === $upSell)
		{
			return;
		}

		$shopDomain = $upSell->getShopDomain();

		$variants = $data['variants'];
		$firstVariant = reset($variants);
		$firstVariantId = $firstVariant['id'];

		$product = ProductQuery::create()
			->filterByShopDomain($shopDomain)
			->filterByShoploProductId($firstVariantId)
			->findOne();

		if (null === $product)
		{
			$product = new Product();
		}

		$images = $data['images'];

		if (count($images))
		{
			$firstImage = reset($images);
			$product->setImgUrl($firstImage['src']);
		}

		$product->setShopDomain($shopDomain);
		$product->setName($data['name']);

		$product->setShoploProductId($firstVariant['id']);
		$product->setOriginalPrice($firstVariant['price']/100);

		$product->setThumbnail($data['thumbnail']);
		$product->setDescription($data['description']);

		$variantsData = [];
		if (count($variants) > 0)
		{
			foreach ($variants as $variant)
			{
				$propertyArray = null;

				if (false == intval($variant['availability']))
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
					$variantsData[$variant['id']]['var_type'] = implode('-', $propertyArray);
					$variantsData[$variant['id']]['price'] = $variant['price']/100;
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
		$product->setAvailability((int) $firstVariant['availability']);
		$product->setOriginalPrice((int) $firstVariant['price_regular']/100);
		$product->setCurrentPrice((int) $firstVariant['price']/100);
		$product->save();

		return $product;
	}

	/**
	 * @return array
	 */
	public function getVariantArray()
	{
		return json_decode($this->getVariants(), true);
	}
}
