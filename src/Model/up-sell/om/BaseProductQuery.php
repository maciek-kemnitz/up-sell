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
use src\Model\Product;
use src\Model\ProductPeer;
use src\Model\ProductQuery;

/**
 * Base class that represents a query for the 'product' table.
 *
 *
 *
 * @method ProductQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ProductQuery orderByShoploProductId($order = Criteria::ASC) Order by the shoplo_product_id column
 * @method ProductQuery orderByShopId($order = Criteria::ASC) Order by the shop_id column
 * @method ProductQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProductQuery orderByImgUrl($order = Criteria::ASC) Order by the img_url column
 * @method ProductQuery orderByOriginalPrice($order = Criteria::ASC) Order by the original_price column
 * @method ProductQuery orderByUrl($order = Criteria::ASC) Order by the url column
 *
 * @method ProductQuery groupById() Group by the id column
 * @method ProductQuery groupByShoploProductId() Group by the shoplo_product_id column
 * @method ProductQuery groupByShopId() Group by the shop_id column
 * @method ProductQuery groupByName() Group by the name column
 * @method ProductQuery groupByImgUrl() Group by the img_url column
 * @method ProductQuery groupByOriginalPrice() Group by the original_price column
 * @method ProductQuery groupByUrl() Group by the url column
 *
 * @method ProductQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProductQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProductQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Product findOne(PropelPDO $con = null) Return the first Product matching the query
 * @method Product findOneOrCreate(PropelPDO $con = null) Return the first Product matching the query, or a new Product object populated from the query conditions when no match is found
 *
 * @method Product findOneByShoploProductId(int $shoplo_product_id) Return the first Product filtered by the shoplo_product_id column
 * @method Product findOneByShopId(int $shop_id) Return the first Product filtered by the shop_id column
 * @method Product findOneByName(string $name) Return the first Product filtered by the name column
 * @method Product findOneByImgUrl(string $img_url) Return the first Product filtered by the img_url column
 * @method Product findOneByOriginalPrice(string $original_price) Return the first Product filtered by the original_price column
 * @method Product findOneByUrl(string $url) Return the first Product filtered by the url column
 *
 * @method array findById(int $id) Return Product objects filtered by the id column
 * @method array findByShoploProductId(int $shoplo_product_id) Return Product objects filtered by the shoplo_product_id column
 * @method array findByShopId(int $shop_id) Return Product objects filtered by the shop_id column
 * @method array findByName(string $name) Return Product objects filtered by the name column
 * @method array findByImgUrl(string $img_url) Return Product objects filtered by the img_url column
 * @method array findByOriginalPrice(string $original_price) Return Product objects filtered by the original_price column
 * @method array findByUrl(string $url) Return Product objects filtered by the url column
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseProductQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProductQuery object.
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
            $modelName = 'src\\Model\\Product';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProductQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProductQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProductQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProductQuery) {
            return $criteria;
        }
        $query = new ProductQuery(null, null, $modelAlias);

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
     * @return   Product|Product[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Product A model object, or null if the key is not found
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
     * @return                 Product A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `shoplo_product_id`, `shop_id`, `name`, `img_url`, `original_price`, `url` FROM `product` WHERE `id` = :p0';
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
            $obj = new Product();
            $obj->hydrate($row);
            ProductPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Product|Product[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Product[]|mixed the list of results, formatted by the current formatter
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
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductPeer::ID, $keys, Criteria::IN);
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
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ProductPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ProductPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the shoplo_product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShoploProductId(1234); // WHERE shoplo_product_id = 1234
     * $query->filterByShoploProductId(array(12, 34)); // WHERE shoplo_product_id IN (12, 34)
     * $query->filterByShoploProductId(array('min' => 12)); // WHERE shoplo_product_id >= 12
     * $query->filterByShoploProductId(array('max' => 12)); // WHERE shoplo_product_id <= 12
     * </code>
     *
     * @param     mixed $shoploProductId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByShoploProductId($shoploProductId = null, $comparison = null)
    {
        if (is_array($shoploProductId)) {
            $useMinMax = false;
            if (isset($shoploProductId['min'])) {
                $this->addUsingAlias(ProductPeer::SHOPLO_PRODUCT_ID, $shoploProductId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shoploProductId['max'])) {
                $this->addUsingAlias(ProductPeer::SHOPLO_PRODUCT_ID, $shoploProductId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductPeer::SHOPLO_PRODUCT_ID, $shoploProductId, $comparison);
    }

    /**
     * Filter the query on the shop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShopId(1234); // WHERE shop_id = 1234
     * $query->filterByShopId(array(12, 34)); // WHERE shop_id IN (12, 34)
     * $query->filterByShopId(array('min' => 12)); // WHERE shop_id >= 12
     * $query->filterByShopId(array('max' => 12)); // WHERE shop_id <= 12
     * </code>
     *
     * @param     mixed $shopId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByShopId($shopId = null, $comparison = null)
    {
        if (is_array($shopId)) {
            $useMinMax = false;
            if (isset($shopId['min'])) {
                $this->addUsingAlias(ProductPeer::SHOP_ID, $shopId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shopId['max'])) {
                $this->addUsingAlias(ProductPeer::SHOP_ID, $shopId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductPeer::SHOP_ID, $shopId, $comparison);
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
     * @return ProductQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the img_url column
     *
     * Example usage:
     * <code>
     * $query->filterByImgUrl('fooValue');   // WHERE img_url = 'fooValue'
     * $query->filterByImgUrl('%fooValue%'); // WHERE img_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imgUrl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByImgUrl($imgUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imgUrl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $imgUrl)) {
                $imgUrl = str_replace('*', '%', $imgUrl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductPeer::IMG_URL, $imgUrl, $comparison);
    }

    /**
     * Filter the query on the original_price column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginalPrice(1234); // WHERE original_price = 1234
     * $query->filterByOriginalPrice(array(12, 34)); // WHERE original_price IN (12, 34)
     * $query->filterByOriginalPrice(array('min' => 12)); // WHERE original_price >= 12
     * $query->filterByOriginalPrice(array('max' => 12)); // WHERE original_price <= 12
     * </code>
     *
     * @param     mixed $originalPrice The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByOriginalPrice($originalPrice = null, $comparison = null)
    {
        if (is_array($originalPrice)) {
            $useMinMax = false;
            if (isset($originalPrice['min'])) {
                $this->addUsingAlias(ProductPeer::ORIGINAL_PRICE, $originalPrice['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($originalPrice['max'])) {
                $this->addUsingAlias(ProductPeer::ORIGINAL_PRICE, $originalPrice['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductPeer::ORIGINAL_PRICE, $originalPrice, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductPeer::URL, $url, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Product $product Object to remove from the list of results
     *
     * @return ProductQuery The current query, for fluid interface
     */
    public function prune($product = null)
    {
        if ($product) {
            $this->addUsingAlias(ProductPeer::ID, $product->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
