<?php

namespace src\Lib;


use Silex\Application;

use src\Model\TmpRequest;
use src\Model\TmpRequestPeer;
use src\Model\TmpRequestQuery;
use src\Model\UpSellStats;
use src\Model\UpSellStatsQuery;
use src\Model\WidgetStats;
use src\Model\WidgetStatsPeer;
use src\Model\WidgetStatsQuery;

class Stats
{
	/** @var  ShoploObject */
	private $shoploApi;


	/**
	 * @param ShoploObject $shoploApi
	 */
	public function __construct(ShoploObject $shoploApi)
	{
		$this->shoploApi = $shoploApi;
	}

	public function calculateStats()
	{
		$shop = $this->shoploApi->getShop();

		/** @var TmpRequest[] $tmpRequests */
		$tmpRequests = TmpRequestQuery::create()
			->filterByStatus(TmpRequestPeer::STATUS_NEW)
			->filterByShopId($shop['id'])
			->find();


		foreach($tmpRequests as $tmpRequest)
		{
			$data = json_decode($tmpRequest->getData(), true);
			$orderId = $data['id'];
			$orderCreatedAt = new \DateTime($data['created_at']);
			$checkout = $this->shoploApi->getCheckout($orderId);
			$userKey = $checkout['user_key'];
			$orderItems = $data["order_items"];
			$variants = [];

			foreach ($orderItems as $item)
			{
				$variantId = $item["variant_id"];
				$variants[$variantId] = $item;

			}

			/** @var WidgetStats[]|\PropelObjectCollection $widgetStats */
			$widgetStats = WidgetStatsQuery::create()
				->filterByUserKey($userKey)
				->filterByVariantId(array_keys($variants), \Criteria::IN)
				->filterByShopDomain($this->shoploApi->getPermanentDomain())
				->filterByStatus(WidgetStatsPeer::STATUS_NEW)
				->find();

			$upSellVariants = [];

			if ($widgetStats->count() > 0)
			{
				$upSellVariants = $widgetStats->toKeyValue('variantId', 'variantId');
			}

			$upSellSum = 0;
			$sum = 0;

			foreach ($variants as $key => $variant)
			{
				if (in_array($key, $upSellVariants))
				{
					$upSellSum += $variant['price'];
				}

				$sum += $variant['price'];
			}

			$newUpsellStats = new UpSellStats();
			$newUpsellStats->setFullValue($sum);
			$newUpsellStats->setUpSellValue($upSellSum);
			$newUpsellStats->setOrderId($orderId);
			$newUpsellStats->setCreatedAt($orderCreatedAt);
			$newUpsellStats->setShopDomain($this->shoploApi->getPermanentDomain());
			$newUpsellStats->save();

			$tmpRequest->setStatus(TmpRequestPeer::STATUS_CALCULATED);
			$tmpRequest->save();

			if ($widgetStats->count() > 0)
			{
				foreach ($widgetStats as $widgetStat)
				{
					$widgetStat->setStatus(WidgetStatsPeer::STATUS_CALCULATED);
					$widgetStat->save();
				}
			}
		}
	}

	public function prepareChartData($range, $interval, $format, $hoursMatter = false)
	{
		$upSellShowRate = 0;
		$upSellRevenue = 0;
		$avgCartValue = 0;
		$cartValue = 0;


		$range['min'] = $range['min']->setTime(00,00,00);
		$range['max'] = $range['max']->setTime(23,59,59);


		/** @var WidgetStats[] $widgetStats */
		$widgetStats = WidgetStatsQuery::create()
			->filterByShopDomain($this->shoploApi->getPermanentDomain())
			->filterByCreatedAt($range)
			->orderByCreatedAt()
			->find();

		foreach ($widgetStats as $widget)
		{
			if (null === $widget->getVariantId())
			{
				$upSellShowRate++;
			}
		}

		/** @var UpSellStats[] $stats */
		$stats = UpSellStatsQuery::create()
			->filterByShopDomain($this->shoploApi->getPermanentDomain())
			->filterByCreatedAt($range)
			->orderByCreatedAt()
			->find()
			->getArrayCopy();

		$statsCount = count($stats);

		if (!$hoursMatter)
		{
			$range['min'] = $range['min']->setTime(23,59,59);
		}

		/** @var \DateTime[] $statsRange */
		$statsRange = new \DatePeriod($range['min'], $interval, $range['max']);

		$statsData = [];
		$lastDate = null;

		foreach ($statsRange as $date)
		{
			$dateString = $date->format($format);

			if (false == isset($statsData[$dateString]))
			{
				$statsData[$dateString]['upSellValue'] = 0;
				$statsData[$dateString]['fullValue'] = 0;
			}

			foreach ($stats as $key => $stat)
			{

				if ($stat->getCreatedAt(null) > $date)
				{
					break;
				}

				if ($this->isDateInInterval($stat->getCreatedAt(null), $date, $lastDate))
				{
					$statsData[$dateString]['upSellValue'] += round($stat->getUpSellValue() / 100,2);
					$statsData[$dateString]['fullValue'] += round($stat->getFullValue() / 100, 2);

					$upSellRevenue += round($stat->getUpSellValue() / 100,2);
					$cartValue += round($stat->getFullValue() / 100,2);

					unset($stats[$key]);
				}
			}

			$lastDate = $date;
		}

		$avgCartValue = $cartValue ? round($cartValue / $statsCount, 2) : 0;

		$chartData = [
			'statsNumbers' => [
				'avgCartValue' => $avgCartValue,
				'upSellRevenue' => $upSellRevenue,
				'upSellShowRate' => $upSellShowRate
			],
			'statsData' => $statsData,
		];

		return $chartData;
	}

	/**
	 * @param \DateTime $dateToCheck
	 * @param \DateTime $end
	 * @param \DateTime $start
	 *
	 * @return bool
	 */
	private function isDateInInterval(\DateTime $dateToCheck, \DateTime $end, \DateTime $start = null)
	{
		if (null !== $start && $start >= $dateToCheck)
		{
			return false;
		}

		return $dateToCheck <= $end;
	}
}