<?php

namespace src\Model;

use src\Model\om\BaseRelatedProduct;


/**
 * Skeleton subclass for representing a row from the 'related_product' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.up-sell
 */
class RelatedProduct extends BaseRelatedProduct
{
	/**
	 * @return Product
	 */
	public function getProduct()
	{
		$upSell = $this->getUpSell();
		$shopDomain = $upSell->getShopDomain();

		$product = ProductQuery::create()
			->filterByShopDomain($shopDomain)
			->filterByShoploProductId($this->getProductId())
			->findOne();

		return $product;
	}
}
