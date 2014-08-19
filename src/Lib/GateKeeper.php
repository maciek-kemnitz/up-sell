<?php

namespace src\Lib;


use src\Model\GatekeeperQuery;

class GateKeeper
{
	const GATE_CROSS_SELL = 'cross_sell';

	/** @var  ShoploObject */
	private $shoploApi;


	/**
	 * @param ShoploObject $shoploApi
	 */
	public function __construct($shoploApi)
	{
		$this->shoploApi = $shoploApi;
	}

	/**
	 * @param $gateName
	 * @return bool
	 */
	public function hasAccess($gateName)
	{
		$shopDomain = $this->getShopDomain();

		$access = GatekeeperQuery::create()
			->filterByShopDomain($shopDomain)
			->filterByName($gateName)
			->exists();

		return $access;
	}

	protected function getShopDomain()
	{
		return $this->shoploApi->getPermanentDomain();
	}
}