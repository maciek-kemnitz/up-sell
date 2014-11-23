<?php

namespace src\Lib;

use \Shoplo\ShoploApi;

class ShoploObject
{
	/** @var ShoploApi */
	protected $api;

	protected $shop;

	protected $permanentDomain;

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

	public function getPermanentDomain()
	{
		if (null == $this->permanentDomain)
		{
			$this->permanentDomain = $this->getShop()['permanent_domain'];
		}

		return $this->permanentDomain;
	}

	public function getProduct($id)
	{
		return $this->api->product->retrieve($id)['products'];
	}

	public function getThemes()
	{
		return $this->api->theme->retrieve()['themes'];
	}

	public function getTheme($id)
	{
		return $this->api->theme->retrieve($id);
	}

	public function getActiveTheme()
	{
		$themes = $this->getThemes();
		foreach ($themes as $theme)
		{
			if ($theme['active'])
			{
				return $theme;
			}
		}
	}

	public function getActiveThemeId()
	{
		$theme = $this->getActiveTheme();
		return $theme['id'];
	}

	public function getAssetsByThemeId($id)
	{
		return $this->api->assets->retrieve($id);
	}

	public function getSnippetsByThemeId($id)
	{
		$assets = $this->getAssetsByThemeId($id);
		$snippets = [];

		foreach ($assets as $asset)
		{
			if (strpos($asset['key'], 'snippets/') !== false)
			{
				$snippets[] = $asset;
			}
		}

		return $snippets;
	}

	/**
	 * @param $id
	 * @param $name
	 *
	 * @return array|null
	 */
	public function getAssetByThemeIdAndName($id, $name)
	{
		$asset = $this->api->assets->retrieve($id, $name);

		if (array_key_exists('asset', $asset))
		{
			return $asset['asset'];
		}

		return null;
	}

	/**
	 * @param int    $themeId
	 * @param string $key
	 * @param string $content
	 * @param string $contentType
	 * @param string $publicUrl
	 *
	 * @return mixed
	 */
	public function createAsset($themeId, $key, $content, $contentType = 'text/plain', $publicUrl = null)
	{
		$fields = array(
			'key' => $key,
			'content' => $content,
			'content_type' => $contentType,
			'public_url' => $publicUrl,
		);


		return $this->api->assets->create($themeId, $fields);
	}

	/**
	 * @param int    $themeId
	 * @param        $id
	 * @param string $key
	 * @param string $content
	 * @param string $contentType
	 * @param string $publicUrl
	 */
	public function modifyAssetContent($themeId, $id, $key, $content, $contentType, $publicUrl)
	{
		$fields = [
//			'key' => $key,
			'content' => $content,
			'content_type' => $contentType,
			'public_url' => $publicUrl
		];

		$this->api->assets->modify($themeId, $id, $fields);
	}

	public function assetsCount()
	{
		return $this->api->assets->count();
	}

	public function getOrders()
	{
		return $this->api->order->retrieve(0,["page"=>1, "limit"=>1000, "created_at_min"=>"2014-10-01"])['orders'];
	}

	public function getCheckout($orderId)
	{
		return $this->api->checkout->retrieve(null, ["order_id" => $orderId])['cart'];
	}

	public function createApplicationCharge($fields)
	{
		return $this->api->application_charge->create($fields);
	}

	public function getApplicationCharges($id = 0)
	{
		return $this->api->application_charge->retrieve($id);
	}

	public function countApplicationCharges()
	{
		return $this->api->application_charge->count();
	}

	public function deleteApplicationCharge($id)
	{
		return $this->api->application_charge->delete($id);
	}

	public function activateApplicationCharge($id)
	{
		return $this->api->application_charge->activate($id);
	}

}
