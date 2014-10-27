<?php

namespace src\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use src\Model\UpSellStats;
use src\Model\UpSellStatsPeer;
use src\Model\UpSellStatsQuery;

/**
 * Base class that represents a query for the 'up_sell_stats' table.
 *
 *
 *
 * @method UpSellStatsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UpSellStatsQuery orderByShopDomain($order = Criteria::ASC) Order by the shop_domain column
 * @method UpSellStatsQuery orderByFullValue($order = Criteria::ASC) Order by the full_value column
 * @method UpSellStatsQuery orderByUpSellValue($order = Criteria::ASC) Order by the up_sell_value column
 * @method UpSellStatsQuery orderByPlacement($order = Criteria::ASC) Order by the placement column
 * @method UpSellStatsQuery orderByOrderId($order = Criteria::ASC) Order by the order_id column
 * @method UpSellStatsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method UpSellStatsQuery groupById() Group by the id column
 * @method UpSellStatsQuery groupByShopDomain() Group by the shop_domain column
 * @method UpSellStatsQuery groupByFullValue() Group by the full_value column
 * @method UpSellStatsQuery groupByUpSellValue() Group by the up_sell_value column
 * @method UpSellStatsQuery groupByPlacement() Group by the placement column
 * @method UpSellStatsQuery groupByOrderId() Group by the order_id column
 * @method UpSellStatsQuery groupByCreatedAt() Group by the created_at column
 *
 * @method UpSellStatsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UpSellStatsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UpSellStatsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UpSellStats findOne(PropelPDO $con = null) Return the first UpSellStats matching the query
 * @method UpSellStats findOneOrCreate(PropelPDO $con = null) Return the first UpSellStats matching the query, or a new UpSellStats object populated from the query conditions when no match is found
 *
 * @method UpSellStats findOneByShopDomain(string $shop_domain) Return the first UpSellStats filtered by the shop_domain column
 * @method UpSellStats findOneByFullValue(double $full_value) Return the first UpSellStats filtered by the full_value column
 * @method UpSellStats findOneByUpSellValue(double $up_sell_value) Return the first UpSellStats filtered by the up_sell_value column
 * @method UpSellStats findOneByPlacement(string $placement) Return the first UpSellStats filtered by the placement column
 * @method UpSellStats findOneByOrderId(int $order_id) Return the first UpSellStats filtered by the order_id column
 * @method UpSellStats findOneByCreatedAt(string $created_at) Return the first UpSellStats filtered by the created_at column
 *
 * @method array findById(int $id) Return UpSellStats objects filtered by the id column
 * @method array findByShopDomain(string $shop_domain) Return UpSellStats objects filtered by the shop_domain column
 * @method array findByFullValue(double $full_value) Return UpSellStats objects filtered by the full_value column
 * @method array findByUpSellValue(double $up_sell_value) Return UpSellStats objects filtered by the up_sell_value column
 * @method array findByPlacement(string $placement) Return UpSellStats objects filtered by the placement column
 * @method array findByOrderId(int $order_id) Return UpSellStats objects filtered by the order_id column
 * @method array findByCreatedAt(string $created_at) Return UpSellStats objects filtered by the created_at column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseUpSellStatsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUpSellStatsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'up-sell';
        }
        if (null === $modelName) {
            $modelName = 'src\\Model\\UpSellStats';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UpSellStatsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UpSellStatsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UpSellStatsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UpSellStatsQuery) {
            return $criteria;
        }
        $query = new UpSellStatsQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   UpSellStats|UpSellStats[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UpSellStatsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UpSellStatsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UpSellStats A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 UpSellStats A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shop_domain`, `full_value`, `up_sell_value`, `placement`, `order_id`, `created_at` FROM `up_sell_stats` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new UpSellStats();
            $obj->hydrate($row);
            UpSellStatsPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return UpSellStats|UpSellStats[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|UpSellStats[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UpSellStatsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UpSellStatsPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UpSellStatsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UpSellStatsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the shop_domain column
     *
     * Example usage:
     * <code>
     * $query->filterByShopDomain('fooValue');   // WHERE shop_domain = 'fooValue'
     * $query->filterByShopDomain('%fooValue%'); // WHERE shop_domain LIKE '%fooValue%'
     * </code>
     *
     * @param     string $shopDomain The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByShopDomain($shopDomain = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($shopDomain)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $shopDomain)) {
                $shopDomain = str_replace('*', '%', $shopDomain);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::SHOP_DOMAIN, $shopDomain, $comparison);
    }

    /**
     * Filter the query on the full_value column
     *
     * Example usage:
     * <code>
     * $query->filterByFullValue(1234); // WHERE full_value = 1234
     * $query->filterByFullValue(array(12, 34)); // WHERE full_value IN (12, 34)
     * $query->filterByFullValue(array('min' => 12)); // WHERE full_value >= 12
     * $query->filterByFullValue(array('max' => 12)); // WHERE full_value <= 12
     * </code>
     *
     * @param     mixed $fullValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByFullValue($fullValue = null, $comparison = null)
    {
        if (is_array($fullValue)) {
            $useMinMax = false;
            if (isset($fullValue['min'])) {
                $this->addUsingAlias(UpSellStatsPeer::FULL_VALUE, $fullValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fullValue['max'])) {
                $this->addUsingAlias(UpSellStatsPeer::FULL_VALUE, $fullValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::FULL_VALUE, $fullValue, $comparison);
    }

    /**
     * Filter the query on the up_sell_value column
     *
     * Example usage:
     * <code>
     * $query->filterByUpSellValue(1234); // WHERE up_sell_value = 1234
     * $query->filterByUpSellValue(array(12, 34)); // WHERE up_sell_value IN (12, 34)
     * $query->filterByUpSellValue(array('min' => 12)); // WHERE up_sell_value >= 12
     * $query->filterByUpSellValue(array('max' => 12)); // WHERE up_sell_value <= 12
     * </code>
     *
     * @param     mixed $upSellValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByUpSellValue($upSellValue = null, $comparison = null)
    {
        if (is_array($upSellValue)) {
            $useMinMax = false;
            if (isset($upSellValue['min'])) {
                $this->addUsingAlias(UpSellStatsPeer::UP_SELL_VALUE, $upSellValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($upSellValue['max'])) {
                $this->addUsingAlias(UpSellStatsPeer::UP_SELL_VALUE, $upSellValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::UP_SELL_VALUE, $upSellValue, $comparison);
    }

    /**
     * Filter the query on the placement column
     *
     * Example usage:
     * <code>
     * $query->filterByPlacement('fooValue');   // WHERE placement = 'fooValue'
     * $query->filterByPlacement('%fooValue%'); // WHERE placement LIKE '%fooValue%'
     * </code>
     *
     * @param     string $placement The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByPlacement($placement = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($placement)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $placement)) {
                $placement = str_replace('*', '%', $placement);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::PLACEMENT, $placement, $comparison);
    }

    /**
     * Filter the query on the order_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderId(1234); // WHERE order_id = 1234
     * $query->filterByOrderId(array(12, 34)); // WHERE order_id IN (12, 34)
     * $query->filterByOrderId(array('min' => 12)); // WHERE order_id >= 12
     * $query->filterByOrderId(array('max' => 12)); // WHERE order_id <= 12
     * </code>
     *
     * @param     mixed $orderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByOrderId($orderId = null, $comparison = null)
    {
        if (is_array($orderId)) {
            $useMinMax = false;
            if (isset($orderId['min'])) {
                $this->addUsingAlias(UpSellStatsPeer::ORDER_ID, $orderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderId['max'])) {
                $this->addUsingAlias(UpSellStatsPeer::ORDER_ID, $orderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::ORDER_ID, $orderId, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UpSellStatsPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UpSellStatsPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellStatsPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   UpSellStats $upSellStats Object to remove from the list of results
     *
     * @return UpSellStatsQuery The current query, for fluid interface
     */
    public function prune($upSellStats = null)
    {
        if ($upSellStats) {
            $this->addUsingAlias(UpSellStatsPeer::ID, $upSellStats->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
