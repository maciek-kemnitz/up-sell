<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maciek
 * Date: 13.03.14
 * Time: 23:38
 * To change this template use File | Settings | File Templates.
 */

namespace src\Lib;


class UpSell
{
	public $id;
	public $name;
	public $headline;
	public $description;
	public $priceFrom;
	public $priceTo;

	public function __construct($name, $headline, $description)
	{
		$this->name = $name;
		$this->headline = $headline;
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getHeadline()
	{
		return $this->headline;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	public function save()
	{
		$id = Database::saveUpSell($this);
		$id = intval($id);

		if (null == $this->getId() && is_int($id))
		{
			$this->id = $id;
		}
	}

	/**
	 * @param mixed $priceTo
	 */
	public function setPriceTo($priceTo)
	{
		$this->priceTo = $priceTo;
	}

	/**
	 * @return mixed
	 */
	public function getPriceTo()
	{
		return $this->priceTo;
	}

	/**
	 * @param mixed $priceFrom
	 */
	public function setPriceFrom($priceFrom)
	{
		$this->priceFrom = $priceFrom;
	}

	/**
	 * @return mixed
	 */
	public function getPriceFrom()
	{
		return $this->priceFrom;
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




}