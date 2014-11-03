<?php

namespace src\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\WidgetStatsPeer;
use src\Model\map\UpSellTableMap;

/**
 * Base static class for performing query and update operations on the 'up_sell' table.
 *
 *
 *
 * @package propel.generator.up-sell.om
 */
abstract class BaseUpSellPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'up-sell';

    /** the table name for this class */
    const TABLE_NAME = 'up_sell';

    /** the related Propel class for this table */
    const OM_CLASS = 'src\\Model\\UpSell';

    /** the related TableMap class for this table */
    const TM_CLASS = 'src\\Model\\map\\UpSellTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 15;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 15;

    /** the column name for the id field */
    const ID = 'up_sell.id';

    /** the column name for the shop_domain field */
    const SHOP_DOMAIN = 'up_sell.shop_domain';

    /** the column name for the shop_id field */
    const SHOP_ID = 'up_sell.shop_id';

    /** the column name for the name field */
    const NAME = 'up_sell.name';

    /** the column name for the headline field */
    const HEADLINE = 'up_sell.headline';

    /** the column name for the description field */
    const DESCRIPTION = 'up_sell.description';

    /** the column name for the price_from field */
    const PRICE_FROM = 'up_sell.price_from';

    /** the column name for the price_to field */
    const PRICE_TO = 'up_sell.price_to';

    /** the column name for the order field */
    const ORDER = 'up_sell.order';

    /** the column name for the use_price_range field */
    const USE_PRICE_RANGE = 'up_sell.use_price_range';

    /** the column name for the created_at field */
    const CREATED_AT = 'up_sell.created_at';

    /** the column name for the status field */
    const STATUS = 'up_sell.status';

    /** the column name for the discount_type field */
    const DISCOUNT_TYPE = 'up_sell.discount_type';

    /** the column name for the discount_amount field */
    const DISCOUNT_AMOUNT = 'up_sell.discount_amount';

    /** the column name for the placement field */
    const PLACEMENT = 'up_sell.placement';

    /** The enumerated values for the use_price_range field */
    const USE_PRICE_RANGE_0 = '0';
    const USE_PRICE_RANGE_1 = '1';

    /** The enumerated values for the status field */
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';

    /** The enumerated values for the discount_type field */
    const DISCOUNT_TYPE_NONE = 'none';
    const DISCOUNT_TYPE_PERCENT = 'percent';
    const DISCOUNT_TYPE_AMOUNT = 'amount';

    /** The enumerated values for the placement field */
    const PLACEMENT_PRODUCT = 'product';
    const PLACEMENT_CART = 'cart';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of UpSell objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array UpSell[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. UpSellPeer::$fieldNames[UpSellPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'ShopDomain', 'ShopId', 'Name', 'Headline', 'Description', 'PriceFrom', 'PriceTo', 'Order', 'UsePriceRange', 'CreatedAt', 'Status', 'DiscountType', 'DiscountAmount', 'Placement', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'shopDomain', 'shopId', 'name', 'headline', 'description', 'priceFrom', 'priceTo', 'order', 'usePriceRange', 'createdAt', 'status', 'discountType', 'discountAmount', 'placement', ),
        BasePeer::TYPE_COLNAME => array (UpSellPeer::ID, UpSellPeer::SHOP_DOMAIN, UpSellPeer::SHOP_ID, UpSellPeer::NAME, UpSellPeer::HEADLINE, UpSellPeer::DESCRIPTION, UpSellPeer::PRICE_FROM, UpSellPeer::PRICE_TO, UpSellPeer::ORDER, UpSellPeer::USE_PRICE_RANGE, UpSellPeer::CREATED_AT, UpSellPeer::STATUS, UpSellPeer::DISCOUNT_TYPE, UpSellPeer::DISCOUNT_AMOUNT, UpSellPeer::PLACEMENT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'SHOP_DOMAIN', 'SHOP_ID', 'NAME', 'HEADLINE', 'DESCRIPTION', 'PRICE_FROM', 'PRICE_TO', 'ORDER', 'USE_PRICE_RANGE', 'CREATED_AT', 'STATUS', 'DISCOUNT_TYPE', 'DISCOUNT_AMOUNT', 'PLACEMENT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'shop_domain', 'shop_id', 'name', 'headline', 'description', 'price_from', 'price_to', 'order', 'use_price_range', 'created_at', 'status', 'discount_type', 'discount_amount', 'placement', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. UpSellPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ShopDomain' => 1, 'ShopId' => 2, 'Name' => 3, 'Headline' => 4, 'Description' => 5, 'PriceFrom' => 6, 'PriceTo' => 7, 'Order' => 8, 'UsePriceRange' => 9, 'CreatedAt' => 10, 'Status' => 11, 'DiscountType' => 12, 'DiscountAmount' => 13, 'Placement' => 14, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'shopDomain' => 1, 'shopId' => 2, 'name' => 3, 'headline' => 4, 'description' => 5, 'priceFrom' => 6, 'priceTo' => 7, 'order' => 8, 'usePriceRange' => 9, 'createdAt' => 10, 'status' => 11, 'discountType' => 12, 'discountAmount' => 13, 'placement' => 14, ),
        BasePeer::TYPE_COLNAME => array (UpSellPeer::ID => 0, UpSellPeer::SHOP_DOMAIN => 1, UpSellPeer::SHOP_ID => 2, UpSellPeer::NAME => 3, UpSellPeer::HEADLINE => 4, UpSellPeer::DESCRIPTION => 5, UpSellPeer::PRICE_FROM => 6, UpSellPeer::PRICE_TO => 7, UpSellPeer::ORDER => 8, UpSellPeer::USE_PRICE_RANGE => 9, UpSellPeer::CREATED_AT => 10, UpSellPeer::STATUS => 11, UpSellPeer::DISCOUNT_TYPE => 12, UpSellPeer::DISCOUNT_AMOUNT => 13, UpSellPeer::PLACEMENT => 14, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'SHOP_DOMAIN' => 1, 'SHOP_ID' => 2, 'NAME' => 3, 'HEADLINE' => 4, 'DESCRIPTION' => 5, 'PRICE_FROM' => 6, 'PRICE_TO' => 7, 'ORDER' => 8, 'USE_PRICE_RANGE' => 9, 'CREATED_AT' => 10, 'STATUS' => 11, 'DISCOUNT_TYPE' => 12, 'DISCOUNT_AMOUNT' => 13, 'PLACEMENT' => 14, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'shop_domain' => 1, 'shop_id' => 2, 'name' => 3, 'headline' => 4, 'description' => 5, 'price_from' => 6, 'price_to' => 7, 'order' => 8, 'use_price_range' => 9, 'created_at' => 10, 'status' => 11, 'discount_type' => 12, 'discount_amount' => 13, 'placement' => 14, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        UpSellPeer::USE_PRICE_RANGE => array(
            UpSellPeer::USE_PRICE_RANGE_0,
            UpSellPeer::USE_PRICE_RANGE_1,
        ),
        UpSellPeer::STATUS => array(
            UpSellPeer::STATUS_ACTIVE,
            UpSellPeer::STATUS_DISABLED,
        ),
        UpSellPeer::DISCOUNT_TYPE => array(
            UpSellPeer::DISCOUNT_TYPE_NONE,
            UpSellPeer::DISCOUNT_TYPE_PERCENT,
            UpSellPeer::DISCOUNT_TYPE_AMOUNT,
        ),
        UpSellPeer::PLACEMENT => array(
            UpSellPeer::PLACEMENT_PRODUCT,
            UpSellPeer::PLACEMENT_CART,
        ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = UpSellPeer::getFieldNames($toType);
        $key = isset(UpSellPeer::$fieldKeys[$fromType][$name]) ? UpSellPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(UpSellPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, UpSellPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return UpSellPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return UpSellPeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = UpSellPeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = UpSellPeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. UpSellPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(UpSellPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UpSellPeer::ID);
            $criteria->addSelectColumn(UpSellPeer::SHOP_DOMAIN);
            $criteria->addSelectColumn(UpSellPeer::SHOP_ID);
            $criteria->addSelectColumn(UpSellPeer::NAME);
            $criteria->addSelectColumn(UpSellPeer::HEADLINE);
            $criteria->addSelectColumn(UpSellPeer::DESCRIPTION);
            $criteria->addSelectColumn(UpSellPeer::PRICE_FROM);
            $criteria->addSelectColumn(UpSellPeer::PRICE_TO);
            $criteria->addSelectColumn(UpSellPeer::ORDER);
            $criteria->addSelectColumn(UpSellPeer::USE_PRICE_RANGE);
            $criteria->addSelectColumn(UpSellPeer::CREATED_AT);
            $criteria->addSelectColumn(UpSellPeer::STATUS);
            $criteria->addSelectColumn(UpSellPeer::DISCOUNT_TYPE);
            $criteria->addSelectColumn(UpSellPeer::DISCOUNT_AMOUNT);
            $criteria->addSelectColumn(UpSellPeer::PLACEMENT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.shop_domain');
            $criteria->addSelectColumn($alias . '.shop_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.headline');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.price_from');
            $criteria->addSelectColumn($alias . '.price_to');
            $criteria->addSelectColumn($alias . '.order');
            $criteria->addSelectColumn($alias . '.use_price_range');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.discount_type');
            $criteria->addSelectColumn($alias . '.discount_amount');
            $criteria->addSelectColumn($alias . '.placement');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(UpSellPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            UpSellPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(UpSellPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return UpSell
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = UpSellPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return UpSellPeer::populateObjects(UpSellPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            UpSellPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(UpSellPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param UpSell $obj A UpSell object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            UpSellPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A UpSell object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof UpSell) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or UpSell object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(UpSellPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return UpSell Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(UpSellPeer::$instances[$key])) {
                return UpSellPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (UpSellPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        UpSellPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to up_sell
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in WidgetStatsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        WidgetStatsPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = UpSellPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = UpSellPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = UpSellPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UpSellPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (UpSell object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = UpSellPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = UpSellPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + UpSellPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UpSellPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            UpSellPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(UpSellPeer::DATABASE_NAME)->getTable(UpSellPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseUpSellPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseUpSellPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \src\Model\map\UpSellTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return UpSellPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a UpSell or Criteria object.
     *
     * @param      mixed $values Criteria or UpSell object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from UpSell object
        }

        if ($criteria->containsKey(UpSellPeer::ID) && $criteria->keyContainsValue(UpSellPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UpSellPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(UpSellPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a UpSell or Criteria object.
     *
     * @param      mixed $values Criteria or UpSell object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(UpSellPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(UpSellPeer::ID);
            $value = $criteria->remove(UpSellPeer::ID);
            if ($value) {
                $selectCriteria->add(UpSellPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(UpSellPeer::TABLE_NAME);
            }

        } else { // $values is UpSell object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(UpSellPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the up_sell table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += UpSellPeer::doOnDeleteCascade(new Criteria(UpSellPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(UpSellPeer::TABLE_NAME, $con, UpSellPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UpSellPeer::clearInstancePool();
            UpSellPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a UpSell or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or UpSell object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof UpSell) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UpSellPeer::DATABASE_NAME);
            $criteria->add(UpSellPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(UpSellPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += UpSellPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                UpSellPeer::clearInstancePool();
            } elseif ($values instanceof UpSell) { // it's a model object
                UpSellPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    UpSellPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            UpSellPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $criteria
        $objects = UpSellPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related WidgetStats objects
            $criteria = new Criteria(WidgetStatsPeer::DATABASE_NAME);

            $criteria->add(WidgetStatsPeer::UP_SELL_ID, $obj->getId());
            $affectedRows += WidgetStatsPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given UpSell object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param UpSell $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(UpSellPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(UpSellPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(UpSellPeer::DATABASE_NAME, UpSellPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return UpSell
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = UpSellPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(UpSellPeer::DATABASE_NAME);
        $criteria->add(UpSellPeer::ID, $pk);

        $v = UpSellPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return UpSell[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(UpSellPeer::DATABASE_NAME);
            $criteria->add(UpSellPeer::ID, $pks, Criteria::IN);
            $objs = UpSellPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseUpSellPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseUpSellPeer::buildTableMap();

