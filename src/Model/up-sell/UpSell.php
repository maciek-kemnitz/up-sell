<?php

namespace src\Model;

use src\Model\om\BaseUpSell;


/**
 * Skeleton subclass for representing a row from the 'up_sell' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.up-sell
 */
class UpSell extends BaseUpSell
{

	/**
	 * @return \PropelObjectCollection
	 */
	public function getProducts()
	{
		$relatedProductIds = $this->getRelatedProducts()->toKeyValue('id', 'productId');

		$products = ProductQuery::create()
						->filterByShopDomain($this->getShopDomain())
						->filterByShoploProductId($relatedProductIds)
						->find();

		return $products;

	}

	public function getSelectedVariant(Product $product)
	{
		/** @var RelatedProduct $relatedProduct */
		$relatedProduct = RelatedProductQuery::create()
						->filterByUpSell($this)
						->filterByProductId($product->getShoploProductId())
						->findOne();

		if (null === $relatedProduct)
		{
			return null;
		}

		return $relatedProduct->getVariantSelected();
	}

	public function getSelectedVariantPIC(Product $product)
	{
		/** @var ProductInCart $productInCart */
		$productInCart = ProductInCartQuery::create()
			->filterByUpSell($this)
			->filterByProductId($product->getShoploProductId())
			->findOne();

		if (null === $productInCart)
		{
			return null;
		}

		return $productInCart->getVariantSelected();
	}
	

	/**
	 * @return bool
	 */
	public function isActive()
	{
		return $this->getStatus() == UpSellPeer::STATUS_ACTIVE;
	}

	public function usePriceRange()
	{
		return $this->getUsePriceRange() == UpSellPeer::USE_PRICE_RANGE_1;
	}

	public function hasProductIdInCart($productId)
	{
		$connectedProducts = $this->getProductInCarts();
		$connectedProducts = $connectedProducts->getArrayCopy('productId');

		return array_key_exists($productId, $connectedProducts);
	}

	public function hasRelatedProductId($productId)
	{
		$connectedProducts = $this->getRelatedProducts();
		$connectedProducts = $connectedProducts->getArrayCopy('productId');

		return array_key_exists($productId, $connectedProducts);
	}
}
