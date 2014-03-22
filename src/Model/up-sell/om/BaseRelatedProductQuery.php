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
use src\Model\RelatedProduct;
use src\Model\RelatedProductPeer;
use src\Model\RelatedProductQuery;

/**
 * Base class that represents a query for the 'related_product' table.
 *
 *
 *
 * @method RelatedProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method RelatedProductQuery orderByUpSellId($order = Criteria::ASC) Order by the up_sell_id column
 * @method RelatedProductQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 *
 * @method RelatedProductQuery groupById() Group by the id column
 * @method RelatedProductQuery groupByUpSellId() Group by the up_sell_id column
 * @method RelatedProductQuery groupByProductId() Group by the product_id column
 *
 * @method RelatedProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method RelatedProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method RelatedProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method RelatedProduct findOne(PropelPDO $con = null) Return the first RelatedProduct matching the query
 * @method RelatedProduct findOneOrCreate(PropelPDO $con = null) Return the first RelatedProduct matching the query, or a new RelatedProduct object populated from the query conditions when no match is found
 *
 * @method RelatedProduct findOneByUpSellId(int $up_sell_id) Return the first RelatedProduct filtered by the up_sell_id column
 * @method RelatedProduct findOneByProductId(int $product_id) Return the first RelatedProduct filtered by the product_id column
 *
 * @method array findById(int $id) Return RelatedProduct objects filtered by the id column
 * @method array findByUpSellId(int $up_sell_id) Return RelatedProduct objects filtered by the up_sell_id column
 * @method array findByProductId(int $product_id) Return RelatedProduct objects filtered by the product_id column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseRelatedProductQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseRelatedProductQuery object.
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
            $modelName = 'src\\Model\\RelatedProduct';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new RelatedProductQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   RelatedProductQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return RelatedProductQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof RelatedProductQuery) {
            return $criteria;
        }
        $query = new RelatedProductQuery(null, null, $modelAlias);

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
     * @return   RelatedProduct|RelatedProduct[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RelatedProductPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(RelatedProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 RelatedProduct A model object, or null if the key is not found
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
     * @return                 RelatedProduct A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `up_sell_id`, `product_id` FROM `related_product` WHERE `id` = :p0';
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
            $obj = new RelatedProduct();
            $obj->hydrate($row);
            RelatedProductPeer::addInstanceToPool($obj, (string) $key);
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
     * @return RelatedProduct|RelatedProduct[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|RelatedProduct[]|mixed the list of results, formatted by the current formatter
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
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RelatedProductPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RelatedProductPeer::ID, $keys, Criteria::IN);
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
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RelatedProductPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RelatedProductPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RelatedProductPeer::ID, $id, $comparison);
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
     * @param     mixed $upSellId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function filterByUpSellId($upSellId = null, $comparison = null)
    {
        if (is_array($upSellId)) {
            $useMinMax = false;
            if (isset($upSellId['min'])) {
                $this->addUsingAlias(RelatedProductPeer::UP_SELL_ID, $upSellId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($upSellId['max'])) {
                $this->addUsingAlias(RelatedProductPeer::UP_SELL_ID, $upSellId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RelatedProductPeer::UP_SELL_ID, $upSellId, $comparison);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id >= 12
     * $query->filterByProductId(array('max' => 12)); // WHERE product_id <= 12
     * </code>
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(RelatedProductPeer::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(RelatedProductPeer::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RelatedProductPeer::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   RelatedProduct $relatedProduct Object to remove from the list of results
     *
     * @return RelatedProductQuery The current query, for fluid interface
     */
    public function prune($relatedProduct = null)
    {
        if ($relatedProduct) {
            $this->addUsingAlias(RelatedProductPeer::ID, $relatedProduct->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
