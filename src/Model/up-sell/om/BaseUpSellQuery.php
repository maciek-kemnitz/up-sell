<?php

namespace src\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use src\Model\ProductInCart;
use src\Model\RelatedProduct;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;

/**
 * Base class that represents a query for the 'up_sell' table.
 *
 *
 *
 * @method UpSellQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UpSellQuery orderByShopDomain($order = Criteria::ASC) Order by the shop_domain column
 * @method UpSellQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method UpSellQuery orderByHeadline($order = Criteria::ASC) Order by the headline column
 * @method UpSellQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method UpSellQuery orderByPriceFrom($order = Criteria::ASC) Order by the price_from column
 * @method UpSellQuery orderByPriceTo($order = Criteria::ASC) Order by the price_to column
 * @method UpSellQuery orderByOrder($order = Criteria::ASC) Order by the order column
 * @method UpSellQuery orderByUsePriceRange($order = Criteria::ASC) Order by the use_price_range column
 * @method UpSellQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method UpSellQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method UpSellQuery orderByDiscountType($order = Criteria::ASC) Order by the discount_type column
 * @method UpSellQuery orderByDiscountAmount($order = Criteria::ASC) Order by the discount_amount column
 * @method UpSellQuery orderByPlacement($order = Criteria::ASC) Order by the placement column
 *
 * @method UpSellQuery groupById() Group by the id column
 * @method UpSellQuery groupByShopDomain() Group by the shop_domain column
 * @method UpSellQuery groupByName() Group by the name column
 * @method UpSellQuery groupByHeadline() Group by the headline column
 * @method UpSellQuery groupByDescription() Group by the description column
 * @method UpSellQuery groupByPriceFrom() Group by the price_from column
 * @method UpSellQuery groupByPriceTo() Group by the price_to column
 * @method UpSellQuery groupByOrder() Group by the order column
 * @method UpSellQuery groupByUsePriceRange() Group by the use_price_range column
 * @method UpSellQuery groupByCreatedAt() Group by the created_at column
 * @method UpSellQuery groupByStatus() Group by the status column
 * @method UpSellQuery groupByDiscountType() Group by the discount_type column
 * @method UpSellQuery groupByDiscountAmount() Group by the discount_amount column
 * @method UpSellQuery groupByPlacement() Group by the placement column
 *
 * @method UpSellQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UpSellQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UpSellQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UpSellQuery leftJoinProductInCart($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductInCart relation
 * @method UpSellQuery rightJoinProductInCart($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductInCart relation
 * @method UpSellQuery innerJoinProductInCart($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductInCart relation
 *
 * @method UpSellQuery leftJoinRelatedProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the RelatedProduct relation
 * @method UpSellQuery rightJoinRelatedProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RelatedProduct relation
 * @method UpSellQuery innerJoinRelatedProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the RelatedProduct relation
 *
 * @method UpSell findOne(PropelPDO $con = null) Return the first UpSell matching the query
 * @method UpSell findOneOrCreate(PropelPDO $con = null) Return the first UpSell matching the query, or a new UpSell object populated from the query conditions when no match is found
 *
 * @method UpSell findOneByShopDomain(string $shop_domain) Return the first UpSell filtered by the shop_domain column
 * @method UpSell findOneByName(string $name) Return the first UpSell filtered by the name column
 * @method UpSell findOneByHeadline(string $headline) Return the first UpSell filtered by the headline column
 * @method UpSell findOneByDescription(string $description) Return the first UpSell filtered by the description column
 * @method UpSell findOneByPriceFrom(double $price_from) Return the first UpSell filtered by the price_from column
 * @method UpSell findOneByPriceTo(double $price_to) Return the first UpSell filtered by the price_to column
 * @method UpSell findOneByOrder(int $order) Return the first UpSell filtered by the order column
 * @method UpSell findOneByUsePriceRange(string $use_price_range) Return the first UpSell filtered by the use_price_range column
 * @method UpSell findOneByCreatedAt(string $created_at) Return the first UpSell filtered by the created_at column
 * @method UpSell findOneByStatus(string $status) Return the first UpSell filtered by the status column
 * @method UpSell findOneByDiscountType(string $discount_type) Return the first UpSell filtered by the discount_type column
 * @method UpSell findOneByDiscountAmount(double $discount_amount) Return the first UpSell filtered by the discount_amount column
 * @method UpSell findOneByPlacement(string $placement) Return the first UpSell filtered by the placement column
 *
 * @method array findById(int $id) Return UpSell objects filtered by the id column
 * @method array findByShopDomain(string $shop_domain) Return UpSell objects filtered by the shop_domain column
 * @method array findByName(string $name) Return UpSell objects filtered by the name column
 * @method array findByHeadline(string $headline) Return UpSell objects filtered by the headline column
 * @method array findByDescription(string $description) Return UpSell objects filtered by the description column
 * @method array findByPriceFrom(double $price_from) Return UpSell objects filtered by the price_from column
 * @method array findByPriceTo(double $price_to) Return UpSell objects filtered by the price_to column
 * @method array findByOrder(int $order) Return UpSell objects filtered by the order column
 * @method array findByUsePriceRange(string $use_price_range) Return UpSell objects filtered by the use_price_range column
 * @method array findByCreatedAt(string $created_at) Return UpSell objects filtered by the created_at column
 * @method array findByStatus(string $status) Return UpSell objects filtered by the status column
 * @method array findByDiscountType(string $discount_type) Return UpSell objects filtered by the discount_type column
 * @method array findByDiscountAmount(double $discount_amount) Return UpSell objects filtered by the discount_amount column
 * @method array findByPlacement(string $placement) Return UpSell objects filtered by the placement column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseUpSellQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUpSellQuery object.
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
            $modelName = 'src\\Model\\UpSell';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UpSellQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UpSellQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UpSellQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UpSellQuery) {
            return $criteria;
        }
        $query = new UpSellQuery(null, null, $modelAlias);

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
     * @return   UpSell|UpSell[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UpSellPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 UpSell A model object, or null if the key is not found
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
     * @return                 UpSell A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shop_domain`, `name`, `headline`, `description`, `price_from`, `price_to`, `order`, `use_price_range`, `created_at`, `status`, `discount_type`, `discount_amount`, `placement` FROM `up_sell` WHERE `id` = :p0';
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
            $obj = new UpSell();
            $obj->hydrate($row);
            UpSellPeer::addInstanceToPool($obj, (string) $key);
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
     * @return UpSell|UpSell[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|UpSell[]|mixed the list of results, formatted by the current formatter
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
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UpSellPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UpSellPeer::ID, $keys, Criteria::IN);
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
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UpSellPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UpSellPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::ID, $id, $comparison);
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
     * @return UpSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UpSellPeer::SHOP_DOMAIN, $shopDomain, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the headline column
     *
     * Example usage:
     * <code>
     * $query->filterByHeadline('fooValue');   // WHERE headline = 'fooValue'
     * $query->filterByHeadline('%fooValue%'); // WHERE headline LIKE '%fooValue%'
     * </code>
     *
     * @param     string $headline The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByHeadline($headline = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($headline)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $headline)) {
                $headline = str_replace('*', '%', $headline);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::HEADLINE, $headline, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the price_from column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceFrom(1234); // WHERE price_from = 1234
     * $query->filterByPriceFrom(array(12, 34)); // WHERE price_from IN (12, 34)
     * $query->filterByPriceFrom(array('min' => 12)); // WHERE price_from >= 12
     * $query->filterByPriceFrom(array('max' => 12)); // WHERE price_from <= 12
     * </code>
     *
     * @param     mixed $priceFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByPriceFrom($priceFrom = null, $comparison = null)
    {
        if (is_array($priceFrom)) {
            $useMinMax = false;
            if (isset($priceFrom['min'])) {
                $this->addUsingAlias(UpSellPeer::PRICE_FROM, $priceFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceFrom['max'])) {
                $this->addUsingAlias(UpSellPeer::PRICE_FROM, $priceFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::PRICE_FROM, $priceFrom, $comparison);
    }

    /**
     * Filter the query on the price_to column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceTo(1234); // WHERE price_to = 1234
     * $query->filterByPriceTo(array(12, 34)); // WHERE price_to IN (12, 34)
     * $query->filterByPriceTo(array('min' => 12)); // WHERE price_to >= 12
     * $query->filterByPriceTo(array('max' => 12)); // WHERE price_to <= 12
     * </code>
     *
     * @param     mixed $priceTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByPriceTo($priceTo = null, $comparison = null)
    {
        if (is_array($priceTo)) {
            $useMinMax = false;
            if (isset($priceTo['min'])) {
                $this->addUsingAlias(UpSellPeer::PRICE_TO, $priceTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceTo['max'])) {
                $this->addUsingAlias(UpSellPeer::PRICE_TO, $priceTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::PRICE_TO, $priceTo, $comparison);
    }

    /**
     * Filter the query on the order column
     *
     * Example usage:
     * <code>
     * $query->filterByOrder(1234); // WHERE order = 1234
     * $query->filterByOrder(array(12, 34)); // WHERE order IN (12, 34)
     * $query->filterByOrder(array('min' => 12)); // WHERE order >= 12
     * $query->filterByOrder(array('max' => 12)); // WHERE order <= 12
     * </code>
     *
     * @param     mixed $order The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByOrder($order = null, $comparison = null)
    {
        if (is_array($order)) {
            $useMinMax = false;
            if (isset($order['min'])) {
                $this->addUsingAlias(UpSellPeer::ORDER, $order['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order['max'])) {
                $this->addUsingAlias(UpSellPeer::ORDER, $order['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::ORDER, $order, $comparison);
    }

    /**
     * Filter the query on the use_price_range column
     *
     * Example usage:
     * <code>
     * $query->filterByUsePriceRange('fooValue');   // WHERE use_price_range = 'fooValue'
     * $query->filterByUsePriceRange('%fooValue%'); // WHERE use_price_range LIKE '%fooValue%'
     * </code>
     *
     * @param     string $usePriceRange The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByUsePriceRange($usePriceRange = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($usePriceRange)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $usePriceRange)) {
                $usePriceRange = str_replace('*', '%', $usePriceRange);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::USE_PRICE_RANGE, $usePriceRange, $comparison);
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
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UpSellPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UpSellPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the discount_type column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscountType('fooValue');   // WHERE discount_type = 'fooValue'
     * $query->filterByDiscountType('%fooValue%'); // WHERE discount_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $discountType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByDiscountType($discountType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($discountType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $discountType)) {
                $discountType = str_replace('*', '%', $discountType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UpSellPeer::DISCOUNT_TYPE, $discountType, $comparison);
    }

    /**
     * Filter the query on the discount_amount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscountAmount(1234); // WHERE discount_amount = 1234
     * $query->filterByDiscountAmount(array(12, 34)); // WHERE discount_amount IN (12, 34)
     * $query->filterByDiscountAmount(array('min' => 12)); // WHERE discount_amount >= 12
     * $query->filterByDiscountAmount(array('max' => 12)); // WHERE discount_amount <= 12
     * </code>
     *
     * @param     mixed $discountAmount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function filterByDiscountAmount($discountAmount = null, $comparison = null)
    {
        if (is_array($discountAmount)) {
            $useMinMax = false;
            if (isset($discountAmount['min'])) {
                $this->addUsingAlias(UpSellPeer::DISCOUNT_AMOUNT, $discountAmount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discountAmount['max'])) {
                $this->addUsingAlias(UpSellPeer::DISCOUNT_AMOUNT, $discountAmount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UpSellPeer::DISCOUNT_AMOUNT, $discountAmount, $comparison);
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
     * @return UpSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UpSellPeer::PLACEMENT, $placement, $comparison);
    }

    /**
     * Filter the query by a related ProductInCart object
     *
     * @param   ProductInCart|PropelObjectCollection $productInCart  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UpSellQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProductInCart($productInCart, $comparison = null)
    {
        if ($productInCart instanceof ProductInCart) {
            return $this
                ->addUsingAlias(UpSellPeer::ID, $productInCart->getUpSellId(), $comparison);
        } elseif ($productInCart instanceof PropelObjectCollection) {
            return $this
                ->useProductInCartQuery()
                ->filterByPrimaryKeys($productInCart->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProductInCart() only accepts arguments of type ProductInCart or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductInCart relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function joinProductInCart($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductInCart');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProductInCart');
        }

        return $this;
    }

    /**
     * Use the ProductInCart relation ProductInCart object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \src\Model\ProductInCartQuery A secondary query class using the current class as primary query
     */
    public function useProductInCartQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductInCart($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductInCart', '\src\Model\ProductInCartQuery');
    }

    /**
     * Filter the query by a related RelatedProduct object
     *
     * @param   RelatedProduct|PropelObjectCollection $relatedProduct  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UpSellQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRelatedProduct($relatedProduct, $comparison = null)
    {
        if ($relatedProduct instanceof RelatedProduct) {
            return $this
                ->addUsingAlias(UpSellPeer::ID, $relatedProduct->getUpSellId(), $comparison);
        } elseif ($relatedProduct instanceof PropelObjectCollection) {
            return $this
                ->useRelatedProductQuery()
                ->filterByPrimaryKeys($relatedProduct->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRelatedProduct() only accepts arguments of type RelatedProduct or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RelatedProduct relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function joinRelatedProduct($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RelatedProduct');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RelatedProduct');
        }

        return $this;
    }

    /**
     * Use the RelatedProduct relation RelatedProduct object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \src\Model\RelatedProductQuery A secondary query class using the current class as primary query
     */
    public function useRelatedProductQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRelatedProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RelatedProduct', '\src\Model\RelatedProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   UpSell $upSell Object to remove from the list of results
     *
     * @return UpSellQuery The current query, for fluid interface
     */
    public function prune($upSell = null)
    {
        if ($upSell) {
            $this->addUsingAlias(UpSellPeer::ID, $upSell->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
