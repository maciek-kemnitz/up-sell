<?php

namespace src\Lib;

use \Shoplo\ShoploApi;

class ShoploObject
{
	/** @var ShoploApi */
	protected $api;

	protected $shop;

	public function __construct(ShoploApi $api)
	{
		$this->api = $api;
	}

	public function getShop()
	{
		if (null == $this->shop)
		{
			$this->shop = $this->api->shop->retrieve();
		}

		return $this->shop;
	}

	public function getProducts()
	{
		return $this->api->product->retrieve();
	}

}
