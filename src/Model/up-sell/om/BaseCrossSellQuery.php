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
use src\Model\CrossSell;
use src\Model\CrossSellPeer;
use src\Model\CrossSellQuery;

/**
 * Base class that represents a query for the 'cross_sell' table.
 *
 *
 *
 * @method CrossSellQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CrossSellQuery orderByShopDomain($order = Criteria::ASC) Order by the shop_domain column
 * @method CrossSellQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CrossSellQuery orderByHeadline($order = Criteria::ASC) Order by the headline column
 * @method CrossSellQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method CrossSellQuery orderByOrder($order = Criteria::ASC) Order by the order column
 * @method CrossSellQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method CrossSellQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method CrossSellQuery groupById() Group by the id column
 * @method CrossSellQuery groupByShopDomain() Group by the shop_domain column
 * @method CrossSellQuery groupByName() Group by the name column
 * @method CrossSellQuery groupByHeadline() Group by the headline column
 * @method CrossSellQuery groupByDescription() Group by the description column
 * @method CrossSellQuery groupByOrder() Group by the order column
 * @method CrossSellQuery groupByStatus() Group by the status column
 * @method CrossSellQuery groupByCreatedAt() Group by the created_at column
 *
 * @method CrossSellQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CrossSellQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CrossSellQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CrossSell findOne(PropelPDO $con = null) Return the first CrossSell matching the query
 * @method CrossSell findOneOrCreate(PropelPDO $con = null) Return the first CrossSell matching the query, or a new CrossSell object populated from the query conditions when no match is found
 *
 * @method CrossSell findOneByShopDomain(string $shop_domain) Return the first CrossSell filtered by the shop_domain column
 * @method CrossSell findOneByName(string $name) Return the first CrossSell filtered by the name column
 * @method CrossSell findOneByHeadline(string $headline) Return the first CrossSell filtered by the headline column
 * @method CrossSell findOneByDescription(string $description) Return the first CrossSell filtered by the description column
 * @method CrossSell findOneByOrder(int $order) Return the first CrossSell filtered by the order column
 * @method CrossSell findOneByStatus(string $status) Return the first CrossSell filtered by the status column
 * @method CrossSell findOneByCreatedAt(string $created_at) Return the first CrossSell filtered by the created_at column
 *
 * @method array findById(int $id) Return CrossSell objects filtered by the id column
 * @method array findByShopDomain(string $shop_domain) Return CrossSell objects filtered by the shop_domain column
 * @method array findByName(string $name) Return CrossSell objects filtered by the name column
 * @method array findByHeadline(string $headline) Return CrossSell objects filtered by the headline column
 * @method array findByDescription(string $description) Return CrossSell objects filtered by the description column
 * @method array findByOrder(int $order) Return CrossSell objects filtered by the order column
 * @method array findByStatus(string $status) Return CrossSell objects filtered by the status column
 * @method array findByCreatedAt(string $created_at) Return CrossSell objects filtered by the created_at column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseCrossSellQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCrossSellQuery object.
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
            $modelName = 'src\\Model\\CrossSell';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CrossSellQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CrossSellQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CrossSellQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CrossSellQuery) {
            return $criteria;
        }
        $query = new CrossSellQuery(null, null, $modelAlias);

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
     * @return   CrossSell|CrossSell[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CrossSellPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CrossSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 CrossSell A model object, or null if the key is not found
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
     * @return                 CrossSell A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shop_domain`, `name`, `headline`, `description`, `order`, `status`, `created_at` FROM `cross_sell` WHERE `id` = :p0';
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
            $obj = new CrossSell();
            $obj->hydrate($row);
            CrossSellPeer::addInstanceToPool($obj, (string) $key);
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
     * @return CrossSell|CrossSell[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|CrossSell[]|mixed the list of results, formatted by the current formatter
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
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CrossSellPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CrossSellPeer::ID, $keys, Criteria::IN);
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
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CrossSellPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CrossSellPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrossSellPeer::ID, $id, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrossSellPeer::SHOP_DOMAIN, $shopDomain, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrossSellPeer::NAME, $name, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrossSellPeer::HEADLINE, $headline, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrossSellPeer::DESCRIPTION, $description, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function filterByOrder($order = null, $comparison = null)
    {
        if (is_array($order)) {
            $useMinMax = false;
            if (isset($order['min'])) {
                $this->addUsingAlias(CrossSellPeer::ORDER, $order['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($order['max'])) {
                $this->addUsingAlias(CrossSellPeer::ORDER, $order['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrossSellPeer::ORDER, $order, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CrossSellPeer::STATUS, $status, $comparison);
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
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CrossSellPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CrossSellPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CrossSellPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   CrossSell $crossSell Object to remove from the list of results
     *
     * @return CrossSellQuery The current query, for fluid interface
     */
    public function prune($crossSell = null)
    {
        if ($crossSell) {
            $this->addUsingAlias(CrossSellPeer::ID, $crossSell->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
