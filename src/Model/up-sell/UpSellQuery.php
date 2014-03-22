<?php

namespace src\Model;

use src\Model\om\BaseUpSellQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'up_sell' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.up-sell
 */
class UpSellQuery extends BaseUpSellQuery
{

	public function priceInRange($price)
	{
		$query = $this->filterByPriceFrom($price, \Criteria::GREATER_EQUAL)
						->filterByPriceTo($price, \Criteria::LESS_EQUAL);

		return $query;
	}
}
