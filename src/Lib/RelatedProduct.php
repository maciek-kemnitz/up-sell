<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maciek
 * Date: 13.03.14
 * Time: 23:38
 * To change this template use File | Settings | File Templates.
 */

namespace src\Lib;


class RelatedProduct {

	public $id;
	public $upSellId;
	public $productId;

	public function __construct($upSellId, $productId, $id=null)
	{
		$this->upSellId = $upSellId;
		$this->productId = $productId;
		$this->id = $id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $productId
	 */
	public function setProductId($productId)
	{
		$this->productId = $productId;
	}

	/**
	 * @return mixed
	 */
	public function getProductId()
	{
		return $this->productId;
	}

	/**
	 * @param mixed $upSellId
	 */
	public function setUpSellId($upSellId)
	{
		$this->upSellId = $upSellId;
	}

	/**
	 * @return mixed
	 */
	public function getUpSellId()
	{
		return $this->upSellId;
	}

	public function save()
	{
		$id = Database::saveRelatedProduct($this);
		$id = intval($id);

		if (null == $this->getId() && is_int($id))
		{
			$this->id = $id;
		}
	}
}