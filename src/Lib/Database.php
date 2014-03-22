<?php


namespace src\Lib;


class Database
{
	/** @var  \PDO */
	static $db;
	const DATABASE_HOST = 'local.phpmyadmin.pl';
	const DATABASE_USER = 'root';
	const DATABASE_PASSWORD = 'maciekmarekmama';

	/**
	 * @param UpSell $upSell
	 * @return RelatedProduct[]
	 */
	public static function getRelatedProductByUpSell(UpSell $upSell)
	{
		self::connect();

		$result = self::$db->query("SELECT * FROM related_product WHERE up_sell_id = {$upSell->getId()}")->fetchAll();

		$relatedProducts = [];

		foreach($result as $item)
		{
			$relatedProducts[] = new RelatedProduct($item['up_sell_id'], $item['product_id']);
		}

		return $relatedProducts;
	}

	/**
	 * @param $productId
	 * @return RelatedProduct[]
	 */
	public static function getRelatedProductByProductId($productId)
	{
		self::connect();

		$result = self::$db->query("SELECT * FROM related_product WHERE product_id = {$productId}")->fetchAll();

		$relatedProducts = [];

		foreach($result as $item)
		{
			$relatedProducts[] = new RelatedProduct($item['up_sell_id'], $item['product_id'], $item['id']);
		}

		return $relatedProducts;
	}



	/**
	 * @return UpSell[]
	 */
	public static function getAppSells()
	{
		self::connect();

		$result = self::$db->query("SELECT * FROM up_sell")->fetchAll();

		$upSells = [];

		foreach($result as $item)
		{
			$upSells[] = new UpSell($item['name'], $item['headline'], $item['description']);
		}

		return $upSells;
	}

	/**
	 * @param UpSell $uspSell
	 * @return int
	 */
	public static function saveUpSell(UpSell $uspSell)
	{
		self::connect();
		$stm = self::$db->prepare('INSERT INTO `up_sell` (`name`, `headline`, `description`, `price_from`, `price_to`) VALUES (:name, :headline, :description, :price_from, :price_to)');

		$stm->execute([
			"name" => $uspSell->getName(),
			"headline" => $uspSell->getHeadline(),
			"description" => $uspSell->getDescription(),
			"price_from" => $uspSell->getPriceFrom(),
			"price_to" => $uspSell->getPriceTo()
		]);

		return self::$db->lastInsertId();
	}

	/**
	 * @param RelatedProduct $relatedProduct
	 * @return int
	 */
	public static function saveRelatedProduct(RelatedProduct $relatedProduct)
	{
		self::connect();
		$stm = self::$db->prepare('INSERT INTO `related_product` (`up_sell_id`, `product_id`) VALUES (:up_sell_id, :product_id)');

		$stm->execute([
			"up_sell_id" => $relatedProduct->getUpSellId(),
			"product_id" => $relatedProduct->getProductId(),

		]);

		return self::$db->lastInsertId();
	}


	/**
	 * @param ProductInCart $productInCart
	 * @return int
	 */
	public static function saveProductInCart(ProductInCart $productInCart)
	{
		self::connect();
		$stm = self::$db->prepare('INSERT INTO `product_in_cart` (`up_sell_id`, `product_id`) VALUES (:up_sell_id, :product_id)');

		$stm->execute([
			"up_sell_id" => $productInCart->getUpSellId(),
			"product_id" => $productInCart->getProductId(),

		]);

		return self::$db->lastInsertId();
	}


	protected function connect()
	{
		if(null === self::$db)
		{
			self::$db = new \PDO('mysql:host='.self::DATABASE_HOST.';dbname=shoplo_up_sell', self::DATABASE_USER, self::DATABASE_PASSWORD);
			self::$db->exec("set names utf8");
		}
	}
}

