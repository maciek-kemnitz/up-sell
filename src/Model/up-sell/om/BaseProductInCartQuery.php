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
use src\Model\ProductInCartPeer;
use src\Model\ProductInCartQuery;
use src\Model\UpSell;

/**
 * Base class that represents a query for the 'product_in_cart' table.
 *
 *
 *
 * @method ProductInCartQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProductInCartQuery orderByUpSellId($order = Criteria::ASC) Order by the up_sell_id column
 * @method ProductInCartQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method ProductInCartQuery orderByVariantSelected($order = Criteria::ASC) Order by the variant_selected column
 *
 * @method ProductInCartQuery groupById() Group by the id column
 * @method ProductInCartQuery groupByUpSellId() Group by the up_sell_id column
 * @method ProductInCartQuery groupByProductId() Group by the product_id column
 * @method ProductInCartQuery groupByVariantSelected() Group by the variant_selected column
 *
 * @method ProductInCartQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProductInCartQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProductInCartQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProductInCartQuery leftJoinUpSell($relationAlias = null) Adds a LEFT JOIN clause to the query using the UpSell relation
 * @method ProductInCartQuery rightJoinUpSell($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UpSell relation
 * @method ProductInCartQuery innerJoinUpSell($relationAlias = null) Adds a INNER JOIN clause to the query using the UpSell relation
 *
 * @method ProductInCart findOne(PropelPDO $con = null) Return the first ProductInCart matching the query
 * @method ProductInCart findOneOrCreate(PropelPDO $con = null) Return the first ProductInCart matching the query, or a new ProductInCart object populated from the query conditions when no match is found
 *
 * @method ProductInCart findOneByUpSellId(int $up_sell_id) Return the first ProductInCart filtered by the up_sell_id column
 * @method ProductInCart findOneByProductId(int $product_id) Return the first ProductInCart filtered by the product_id column
 * @method ProductInCart findOneByVariantSelected(int $variant_selected) Return the first ProductInCart filtered by the variant_selected column
 *
 * @method array findById(int $id) Return ProductInCart objects filtered by the id column
 * @method array findByUpSellId(int $up_sell_id) Return ProductInCart objects filtered by the up_sell_id column
 * @method array findByProductId(int $product_id) Return ProductInCart objects filtered by the product_id column
 * @method array findByVariantSelected(int $variant_selected) Return ProductInCart objects filtered by the variant_selected column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseProductInCartQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProductInCartQuery object.
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
            $modelName = 'src\\Model\\ProductInCart';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProductInCartQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProductInCartQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProductInCartQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProductInCartQuery) {
            return $criteria;
        }
        $query = new ProductInCartQuery(null, null, $modelAlias);

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
     * @return   ProductInCart|ProductInCart[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductInCartPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProductInCartPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProductInCart A model object, or null if the key is not found
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
     * @return                 ProductInCart A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `up_sell_id`, `product_id`, `variant_selected` FROM `product_in_cart` WHERE `id` = :p0';
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
            $obj = new ProductInCart();
            $obj->hydrate($row);
            ProductInCartPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProductInCart|ProductInCart[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProductInCart[]|mixed the list of results, formatted by the current formatter
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
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductInCartPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductInCartPeer::ID, $keys, Criteria::IN);
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
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductInCartPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductInCartPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductInCartPeer::ID, $id, $comparison);
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
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterByUpSellId($upSellId = null, $comparison = null)
    {
        if (is_array($upSellId)) {
            $useMinMax = false;
            if (isset($upSellId['min'])) {
                $this->addUsingAlias(ProductInCartPeer::UP_SELL_ID, $upSellId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($upSellId['max'])) {
                $this->addUsingAlias(ProductInCartPeer::UP_SELL_ID, $upSellId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductInCartPeer::UP_SELL_ID, $upSellId, $comparison);
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
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(ProductInCartPeer::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(ProductInCartPeer::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductInCartPeer::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the variant_selected column
     *
     * Example usage:
     * <code>
     * $query->filterByVariantSelected(1234); // WHERE variant_selected = 1234
     * $query->filterByVariantSelected(array(12, 34)); // WHERE variant_selected IN (12, 34)
     * $query->filterByVariantSelected(array('min' => 12)); // WHERE variant_selected >= 12
     * $query->filterByVariantSelected(array('max' => 12)); // WHERE variant_selected <= 12
     * </code>
     *
     * @param     mixed $variantSelected The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function filterByVariantSelected($variantSelected = null, $comparison = null)
    {
        if (is_array($variantSelected)) {
            $useMinMax = false;
            if (isset($variantSelected['min'])) {
                $this->addUsingAlias(ProductInCartPeer::VARIANT_SELECTED, $variantSelected['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($variantSelected['max'])) {
                $this->addUsingAlias(ProductInCartPeer::VARIANT_SELECTED, $variantSelected['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductInCartPeer::VARIANT_SELECTED, $variantSelected, $comparison);
    }

    /**
     * Filter the query by a related UpSell object
     *
     * @param   UpSell|PropelObjectCollection $upSell The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProductInCartQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUpSell($upSell, $comparison = null)
    {
        if ($upSell instanceof UpSell) {
            return $this
                ->addUsingAlias(ProductInCartPeer::UP_SELL_ID, $upSell->getId(), $comparison);
        } elseif ($upSell instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductInCartPeer::UP_SELL_ID, $upSell->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ProductInCartQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ProductInCart $productInCart Object to remove from the list of results
     *
     * @return ProductInCartQuery The current query, for fluid interface
     */
    public function prune($productInCart = null)
    {
        if ($productInCart) {
            $this->addUsingAlias(ProductInCartPeer::ID, $productInCart->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
