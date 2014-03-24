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
		$relatedProductIds = $this->getRelatedProducts()->toKeyValue('productId', 'productId');

		$products = ProductQuery::create()
						->findByShopDomain($this->getShopDomain())
						->filterByShoploProductId($relatedProductIds)
						->find();

		return $products;

	}

	/**
	 * @return bool
	 */
	public function isActive()
	{
		return $this->getStatus() == UpSellPeer::STATUS_ACTIVE;
	}
}
