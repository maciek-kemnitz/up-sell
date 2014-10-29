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
use src\Model\Product;
use src\Model\UpSell;
use src\Model\WidgetStats;
use src\Model\WidgetStatsPeer;
use src\Model\WidgetStatsQuery;

/**
 * Base class that represents a query for the 'widget_stats' table.
 *
 *
 *
 * @method WidgetStatsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method WidgetStatsQuery orderByShopDomain($order = Criteria::ASC) Order by the shop_domain column
 * @method WidgetStatsQuery orderByUpSellId($order = Criteria::ASC) Order by the up_sell_id column
 * @method WidgetStatsQuery orderByVariantId($order = Criteria::ASC) Order by the variant_id column
 * @method WidgetStatsQuery orderByPlacement($order = Criteria::ASC) Order by the placement column
 * @method WidgetStatsQuery orderByUserKey($order = Criteria::ASC) Order by the user_key column
 * @method WidgetStatsQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method WidgetStatsQuery groupById() Group by the id column
 * @method WidgetStatsQuery groupByShopDomain() Group by the shop_domain column
 * @method WidgetStatsQuery groupByUpSellId() Group by the up_sell_id column
 * @method WidgetStatsQuery groupByVariantId() Group by the variant_id column
 * @method WidgetStatsQuery groupByPlacement() Group by the placement column
 * @method WidgetStatsQuery groupByUserKey() Group by the user_key column
 * @method WidgetStatsQuery groupByCreatedAt() Group by the created_at column
 *
 * @method WidgetStatsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method WidgetStatsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method WidgetStatsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method WidgetStatsQuery leftJoinUpSell($relationAlias = null) Adds a LEFT JOIN clause to the query using the UpSell relation
 * @method WidgetStatsQuery rightJoinUpSell($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UpSell relation
 * @method WidgetStatsQuery innerJoinUpSell($relationAlias = null) Adds a INNER JOIN clause to the query using the UpSell relation
 *
 * @method WidgetStatsQuery leftJoinProduct($relationAlias = null) Adds a LEFT JOIN clause to the query using the Product relation
 * @method WidgetStatsQuery rightJoinProduct($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Product relation
 * @method WidgetStatsQuery innerJoinProduct($relationAlias = null) Adds a INNER JOIN clause to the query using the Product relation
 *
 * @method WidgetStats findOne(PropelPDO $con = null) Return the first WidgetStats matching the query
 * @method WidgetStats findOneOrCreate(PropelPDO $con = null) Return the first WidgetStats matching the query, or a new WidgetStats object populated from the query conditions when no match is found
 *
 * @method WidgetStats findOneByShopDomain(string $shop_domain) Return the first WidgetStats filtered by the shop_domain column
 * @method WidgetStats findOneByUpSellId(int $up_sell_id) Return the first WidgetStats filtered by the up_sell_id column
 * @method WidgetStats findOneByVariantId(int $variant_id) Return the first WidgetStats filtered by the variant_id column
 * @method WidgetStats findOneByPlacement(string $placement) Return the first WidgetStats filtered by the placement column
 * @method WidgetStats findOneByUserKey(string $user_key) Return the first WidgetStats filtered by the user_key column
 * @method WidgetStats findOneByCreatedAt(string $created_at) Return the first WidgetStats filtered by the created_at column
 *
 * @method array findById(int $id) Return WidgetStats objects filtered by the id column
 * @method array findByShopDomain(string $shop_domain) Return WidgetStats objects filtered by the shop_domain column
 * @method array findByUpSellId(int $up_sell_id) Return WidgetStats objects filtered by the up_sell_id column
 * @method array findByVariantId(int $variant_id) Return WidgetStats objects filtered by the variant_id column
 * @method array findByPlacement(string $placement) Return WidgetStats objects filtered by the placement column
 * @method array findByUserKey(string $user_key) Return WidgetStats objects filtered by the user_key column
 * @method array findByCreatedAt(string $created_at) Return WidgetStats objects filtered by the created_at column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseWidgetStatsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseWidgetStatsQuery object.
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
            $modelName = 'src\\Model\\WidgetStats';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new WidgetStatsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   WidgetStatsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return WidgetStatsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof WidgetStatsQuery) {
            return $criteria;
        }
        $query = new WidgetStatsQuery(null, null, $modelAlias);

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
     * @return   WidgetStats|WidgetStats[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WidgetStatsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(WidgetStatsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 WidgetStats A model object, or null if the key is not found
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
     * @return                 WidgetStats A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shop_domain`, `up_sell_id`, `variant_id`, `placement`, `user_key`, `created_at` FROM `widget_stats` WHERE `id` = :p0';
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
            $obj = new WidgetStats();
            $obj->hydrate($row);
            WidgetStatsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return WidgetStats|WidgetStats[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|WidgetStats[]|mixed the list of results, formatted by the current formatter
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
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WidgetStatsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WidgetStatsPeer::ID, $keys, Criteria::IN);
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
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(WidgetStatsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(WidgetStatsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetStatsPeer::ID, $id, $comparison);
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
     * @return WidgetStatsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WidgetStatsPeer::SHOP_DOMAIN, $shopDomain, $comparison);
    }

    /**
     * Filter the query on the up_sell_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUpSellId(1234); // WHERE up_sell_id = 1234
     * $query->filterByUpSellId(array(12, 34)); // WHERE up_sell_id IN (12, 34)
     * $query->filterByUpSellId(array('min' => 12)); // WHERE up_sell_id >= 12
     * $query->filterByUpSellId(array('max' => 12)); // WHERE up_sell_id <= 12
     * </code>
     *
     * @see       filterByUpSell()
     *
     * @param     mixed $upSellId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByUpSellId($upSellId = null, $comparison = null)
    {
        if (is_array($upSellId)) {
            $useMinMax = false;
            if (isset($upSellId['min'])) {
                $this->addUsingAlias(WidgetStatsPeer::UP_SELL_ID, $upSellId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($upSellId['max'])) {
                $this->addUsingAlias(WidgetStatsPeer::UP_SELL_ID, $upSellId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetStatsPeer::UP_SELL_ID, $upSellId, $comparison);
    }

    /**
     * Filter the query on the variant_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVariantId(1234); // WHERE variant_id = 1234
     * $query->filterByVariantId(array(12, 34)); // WHERE variant_id IN (12, 34)
     * $query->filterByVariantId(array('min' => 12)); // WHERE variant_id >= 12
     * $query->filterByVariantId(array('max' => 12)); // WHERE variant_id <= 12
     * </code>
     *
     * @see       filterByProduct()
     *
     * @param     mixed $variantId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByVariantId($variantId = null, $comparison = null)
    {
        if (is_array($variantId)) {
            $useMinMax = false;
            if (isset($variantId['min'])) {
                $this->addUsingAlias(WidgetStatsPeer::VARIANT_ID, $variantId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variantId['max'])) {
                $this->addUsingAlias(WidgetStatsPeer::VARIANT_ID, $variantId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetStatsPeer::VARIANT_ID, $variantId, $comparison);
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
     * @return WidgetStatsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WidgetStatsPeer::PLACEMENT, $placement, $comparison);
    }

    /**
     * Filter the query on the user_key column
     *
     * Example usage:
     * <code>
     * $query->filterByUserKey('fooValue');   // WHERE user_key = 'fooValue'
     * $query->filterByUserKey('%fooValue%'); // WHERE user_key LIKE '%fooValue%'
     * </code>
     *
     * @param     string $userKey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByUserKey($userKey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($userKey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $userKey)) {
                $userKey = str_replace('*', '%', $userKey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WidgetStatsPeer::USER_KEY, $userKey, $comparison);
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
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(WidgetStatsPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(WidgetStatsPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WidgetStatsPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related UpSell object
     *
     * @param   UpSell|PropelObjectCollection $upSell The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 WidgetStatsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUpSell($upSell, $comparison = null)
    {
        if ($upSell instanceof UpSell) {
            return $this
                ->addUsingAlias(WidgetStatsPeer::UP_SELL_ID, $upSell->getId(), $comparison);
        } elseif ($upSell instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WidgetStatsPeer::UP_SELL_ID, $upSell->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUpSell() only accepts arguments of type UpSell or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UpSell relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function joinUpSell($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UpSell');

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
            $this->addJoinObject($join, 'UpSell');
        }

        return $this;
    }

    /**
     * Use the UpSell relation UpSell object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \src\Model\UpSellQuery A secondary query class using the current class as primary query
     */
    public function useUpSellQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUpSell($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UpSell', '\src\Model\UpSellQuery');
    }

    /**
     * Filter the query by a related Product object
     *
     * @param   Product|PropelObjectCollection $product The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 WidgetStatsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProduct($product, $comparison = null)
    {
        if ($product instanceof Product) {
            return $this
                ->addUsingAlias(WidgetStatsPeer::VARIANT_ID, $product->getShoploProductId(), $comparison);
        } elseif ($product instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WidgetStatsPeer::VARIANT_ID, $product->toKeyValue('PrimaryKey', 'ShoploProductId'), $comparison);
        } else {
            throw new PropelException('filterByProduct() only accepts arguments of type Product or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Product relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function joinProduct($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Product');

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
            $this->addJoinObject($join, 'Product');
        }

        return $this;
    }

    /**
     * Use the Product relation Product object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \src\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduct($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Product', '\src\Model\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   WidgetStats $widgetStats Object to remove from the list of results
     *
     * @return WidgetStatsQuery The current query, for fluid interface
     */
    public function prune($widgetStats = null)
    {
        if ($widgetStats) {
            $this->addUsingAlias(WidgetStatsPeer::ID, $widgetStats->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
