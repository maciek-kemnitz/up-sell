<?php

namespace src\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use src\Model\Product;
use src\Model\ProductPeer;
use src\Model\ProductQuery;
use src\Model\WidgetStats;
use src\Model\WidgetStatsQuery;

/**
 * Base class that represents a row from the 'product' table.
 *
 *
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseProduct extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'src\\Model\\ProductPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProductPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the shoplo_product_id field.
     * @var        int
     */
    protected $shoplo_product_id;

    /**
     * The value for the shop_domain field.
     * @var        string
     */
    protected $shop_domain;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the img_url field.
     * @var        string
     */
    protected $img_url;

    /**
     * The value for the original_price field.
     * @var        double
     */
    protected $original_price;

    /**
     * The value for the current_price field.
     * @var        double
     */
    protected $current_price;

    /**
     * The value for the availability field.
     * @var        int
     */
    protected $availability;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the thumbnail field.
     * @var        string
     */
    protected $thumbnail;

    /**
     * The value for the sku field.
     * @var        string
     */
    protected $sku;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the variants field.
     * @var        string
     */
    protected $variants;

    /**
     * @var        PropelObjectCollection|WidgetStats[] Collection to store aggregation of WidgetStats objects.
     */
    protected $collWidgetStatss;
    protected $collWidgetStatssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $widgetStatssScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [shoplo_product_id] column value.
     *
     * @return int
     */
    public function getShoploProductId()
    {

        return $this->shoplo_product_id;
    }

    /**
     * Get the [shop_domain] column value.
     *
     * @return string
     */
    public function getShopDomain()
    {

        return $this->shop_domain;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [img_url] column value.
     *
     * @return string
     */
    public function getImgUrl()
    {

        return $this->img_url;
    }

    /**
     * Get the [original_price] column value.
     *
     * @return double
     */
    public function getOriginalPrice()
    {

        return $this->original_price;
    }

    /**
     * Get the [current_price] column value.
     *
     * @return double
     */
    public function getCurrentPrice()
    {

        return $this->current_price;
    }

    /**
     * Get the [availability] column value.
     *
     * @return int
     */
    public function getAvailability()
    {

        return $this->availability;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {

        return $this->url;
    }

    /**
     * Get the [thumbnail] column value.
     *
     * @return string
     */
    public function getThumbnail()
    {

        return $this->thumbnail;
    }

    /**
     * Get the [sku] column value.
     *
     * @return string
     */
    public function getSku()
    {

        return $this->sku;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;
    }

    /**
     * Get the [variants] column value.
     *
     * @return string
     */
    public function getVariants()
    {

        return $this->variants;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ProductPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [shoplo_product_id] column.
     *
     * @param  int $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setShoploProductId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->shoplo_product_id !== $v) {
            $this->shoplo_product_id = $v;
            $this->modifiedColumns[] = ProductPeer::SHOPLO_PRODUCT_ID;
        }


        return $this;
    } // setShoploProductId()

    /**
     * Set the value of [shop_domain] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setShopDomain($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shop_domain !== $v) {
            $this->shop_domain = $v;
            $this->modifiedColumns[] = ProductPeer::SHOP_DOMAIN;
        }


        return $this;
    } // setShopDomain()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProductPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [img_url] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setImgUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->img_url !== $v) {
            $this->img_url = $v;
            $this->modifiedColumns[] = ProductPeer::IMG_URL;
        }


        return $this;
    } // setImgUrl()

    /**
     * Set the value of [original_price] column.
     *
     * @param  double $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setOriginalPrice($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->original_price !== $v) {
            $this->original_price = $v;
            $this->modifiedColumns[] = ProductPeer::ORIGINAL_PRICE;
        }


        return $this;
    } // setOriginalPrice()

    /**
     * Set the value of [current_price] column.
     *
     * @param  double $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setCurrentPrice($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->current_price !== $v) {
            $this->current_price = $v;
            $this->modifiedColumns[] = ProductPeer::CURRENT_PRICE;
        }


        return $this;
    } // setCurrentPrice()

    /**
     * Set the value of [availability] column.
     *
     * @param  int $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setAvailability($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->availability !== $v) {
            $this->availability = $v;
            $this->modifiedColumns[] = ProductPeer::AVAILABILITY;
        }


        return $this;
    } // setAvailability()

    /**
     * Set the value of [url] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[] = ProductPeer::URL;
        }


        return $this;
    } // setUrl()

    /**
     * Set the value of [thumbnail] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setThumbnail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->thumbnail !== $v) {
            $this->thumbnail = $v;
            $this->modifiedColumns[] = ProductPeer::THUMBNAIL;
        }


        return $this;
    } // setThumbnail()

    /**
     * Set the value of [sku] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setSku($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sku !== $v) {
            $this->sku = $v;
            $this->modifiedColumns[] = ProductPeer::SKU;
        }


        return $this;
    } // setSku()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ProductPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [variants] column.
     *
     * @param  string $v new value
     * @return Product The current object (for fluent API support)
     */
    public function setVariants($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->variants !== $v) {
            $this->variants = $v;
            $this->modifiedColumns[] = ProductPeer::VARIANTS;
        }


        return $this;
    } // setVariants()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->shoplo_product_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->shop_domain = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->img_url = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->original_price = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
            $this->current_price = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
            $this->availability = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->url = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->thumbnail = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->sku = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->description = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->variants = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 13; // 13 = ProductPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Product object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProductPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collWidgetStatss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProductQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ProductPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProductPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->widgetStatssScheduledForDeletion !== null) {
                if (!$this->widgetStatssScheduledForDeletion->isEmpty()) {
                    WidgetStatsQuery::create()
                        ->filterByPrimaryKeys($this->widgetStatssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->widgetStatssScheduledForDeletion = null;
                }
            }

            if ($this->collWidgetStatss !== null) {
                foreach ($this->collWidgetStatss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ProductPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProductPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ProductPeer::SHOPLO_PRODUCT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`shoplo_product_id`';
        }
        if ($this->isColumnModified(ProductPeer::SHOP_DOMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`shop_domain`';
        }
        if ($this->isColumnModified(ProductPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ProductPeer::IMG_URL)) {
            $modifiedColumns[':p' . $index++]  = '`img_url`';
        }
        if ($this->isColumnModified(ProductPeer::ORIGINAL_PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`original_price`';
        }
        if ($this->isColumnModified(ProductPeer::CURRENT_PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`current_price`';
        }
        if ($this->isColumnModified(ProductPeer::AVAILABILITY)) {
            $modifiedColumns[':p' . $index++]  = '`availability`';
        }
        if ($this->isColumnModified(ProductPeer::URL)) {
            $modifiedColumns[':p' . $index++]  = '`url`';
        }
        if ($this->isColumnModified(ProductPeer::THUMBNAIL)) {
            $modifiedColumns[':p' . $index++]  = '`thumbnail`';
        }
        if ($this->isColumnModified(ProductPeer::SKU)) {
            $modifiedColumns[':p' . $index++]  = '`sku`';
        }
        if ($this->isColumnModified(ProductPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(ProductPeer::VARIANTS)) {
            $modifiedColumns[':p' . $index++]  = '`variants`';
        }

        $sql = sprintf(
            'INSERT INTO `product` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`shoplo_product_id`':
                        $stmt->bindValue($identifier, $this->shoplo_product_id, PDO::PARAM_INT);
                        break;
                    case '`shop_domain`':
                        $stmt->bindValue($identifier, $this->shop_domain, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`img_url`':
                        $stmt->bindValue($identifier, $this->img_url, PDO::PARAM_STR);
                        break;
                    case '`original_price`':
                        $stmt->bindValue($identifier, $this->original_price, PDO::PARAM_STR);
                        break;
                    case '`current_price`':
                        $stmt->bindValue($identifier, $this->current_price, PDO::PARAM_STR);
                        break;
                    case '`availability`':
                        $stmt->bindValue($identifier, $this->availability, PDO::PARAM_INT);
                        break;
                    case '`url`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case '`thumbnail`':
                        $stmt->bindValue($identifier, $this->thumbnail, PDO::PARAM_STR);
                        break;
                    case '`sku`':
                        $stmt->bindValue($identifier, $this->sku, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`variants`':
                        $stmt->bindValue($identifier, $this->variants, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = ProductPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collWidgetStatss !== null) {
                    foreach ($this->collWidgetStatss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getShoploProductId();
                break;
            case 2:
                return $this->getShopDomain();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getImgUrl();
                break;
            case 5:
                return $this->getOriginalPrice();
                break;
            case 6:
                return $this->getCurrentPrice();
                break;
            case 7:
                return $this->getAvailability();
                break;
            case 8:
                return $this->getUrl();
                break;
            case 9:
                return $this->getThumbnail();
                break;
            case 10:
                return $this->getSku();
                break;
            case 11:
                return $this->getDescription();
                break;
            case 12:
                return $this->getVariants();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Product'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Product'][$this->getPrimaryKey()] = true;
        $keys = ProductPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getShoploProductId(),
            $keys[2] => $this->getShopDomain(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getImgUrl(),
            $keys[5] => $this->getOriginalPrice(),
            $keys[6] => $this->getCurrentPrice(),
            $keys[7] => $this->getAvailability(),
            $keys[8] => $this->getUrl(),
            $keys[9] => $this->getThumbnail(),
            $keys[10] => $this->getSku(),
            $keys[11] => $this->getDescription(),
            $keys[12] => $this->getVariants(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collWidgetStatss) {
                $result['WidgetStatss'] = $this->collWidgetStatss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ProductPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setShoploProductId($value);
                break;
            case 2:
                $this->setShopDomain($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setImgUrl($value);
                break;
            case 5:
                $this->setOriginalPrice($value);
                break;
            case 6:
                $this->setCurrentPrice($value);
                break;
            case 7:
                $this->setAvailability($value);
                break;
            case 8:
                $this->setUrl($value);
                break;
            case 9:
                $this->setThumbnail($value);
                break;
            case 10:
                $this->setSku($value);
                break;
            case 11:
                $this->setDescription($value);
                break;
            case 12:
                $this->setVariants($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ProductPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setShoploProductId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setShopDomain($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setImgUrl($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setOriginalPrice($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCurrentPrice($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setAvailability($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setUrl($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setThumbnail($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setSku($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDescription($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setVariants($arr[$keys[12]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProductPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProductPeer::ID)) $criteria->add(ProductPeer::ID, $this->id);
        if ($this->isColumnModified(ProductPeer::SHOPLO_PRODUCT_ID)) $criteria->add(ProductPeer::SHOPLO_PRODUCT_ID, $this->shoplo_product_id);
        if ($this->isColumnModified(ProductPeer::SHOP_DOMAIN)) $criteria->add(ProductPeer::SHOP_DOMAIN, $this->shop_domain);
        if ($this->isColumnModified(ProductPeer::NAME)) $criteria->add(ProductPeer::NAME, $this->name);
        if ($this->isColumnModified(ProductPeer::IMG_URL)) $criteria->add(ProductPeer::IMG_URL, $this->img_url);
        if ($this->isColumnModified(ProductPeer::ORIGINAL_PRICE)) $criteria->add(ProductPeer::ORIGINAL_PRICE, $this->original_price);
        if ($this->isColumnModified(ProductPeer::CURRENT_PRICE)) $criteria->add(ProductPeer::CURRENT_PRICE, $this->current_price);
        if ($this->isColumnModified(ProductPeer::AVAILABILITY)) $criteria->add(ProductPeer::AVAILABILITY, $this->availability);
        if ($this->isColumnModified(ProductPeer::URL)) $criteria->add(ProductPeer::URL, $this->url);
        if ($this->isColumnModified(ProductPeer::THUMBNAIL)) $criteria->add(ProductPeer::THUMBNAIL, $this->thumbnail);
        if ($this->isColumnModified(ProductPeer::SKU)) $criteria->add(ProductPeer::SKU, $this->sku);
        if ($this->isColumnModified(ProductPeer::DESCRIPTION)) $criteria->add(ProductPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(ProductPeer::VARIANTS)) $criteria->add(ProductPeer::VARIANTS, $this->variants);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ProductPeer::DATABASE_NAME);
        $criteria->add(ProductPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Product (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setShoploProductId($this->getShoploProductId());
        $copyObj->setShopDomain($this->getShopDomain());
        $copyObj->setName($this->getName());
        $copyObj->setImgUrl($this->getImgUrl());
        $copyObj->setOriginalPrice($this->getOriginalPrice());
        $copyObj->setCurrentPrice($this->getCurrentPrice());
        $copyObj->setAvailability($this->getAvailability());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setThumbnail($this->getThumbnail());
        $copyObj->setSku($this->getSku());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setVariants($this->getVariants());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getWidgetStatss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWidgetStats($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Product Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return ProductPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProductPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('WidgetStats' == $relationName) {
            $this->initWidgetStatss();
        }
    }

    /**
     * Clears out the collWidgetStatss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Product The current object (for fluent API support)
     * @see        addWidgetStatss()
     */
    public function clearWidgetStatss()
    {
        $this->collWidgetStatss = null; // important to set this to null since that means it is uninitialized
        $this->collWidgetStatssPartial = null;

        return $this;
    }

    /**
     * reset is the collWidgetStatss collection loaded partially
     *
     * @return void
     */
    public function resetPartialWidgetStatss($v = true)
    {
        $this->collWidgetStatssPartial = $v;
    }

    /**
     * Initializes the collWidgetStatss collection.
     *
     * By default this just sets the collWidgetStatss collection to an empty array (like clearcollWidgetStatss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWidgetStatss($overrideExisting = true)
    {
        if (null !== $this->collWidgetStatss && !$overrideExisting) {
            return;
        }
        $this->collWidgetStatss = new PropelObjectCollection();
        $this->collWidgetStatss->setModel('WidgetStats');
    }

    /**
     * Gets an array of WidgetStats objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Product is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|WidgetStats[] List of WidgetStats objects
     * @throws PropelException
     */
    public function getWidgetStatss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collWidgetStatssPartial && !$this->isNew();
        if (null === $this->collWidgetStatss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWidgetStatss) {
                // return empty collection
                $this->initWidgetStatss();
            } else {
                $collWidgetStatss = WidgetStatsQuery::create(null, $criteria)
                    ->filterByProduct($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collWidgetStatssPartial && count($collWidgetStatss)) {
                      $this->initWidgetStatss(false);

                      foreach ($collWidgetStatss as $obj) {
                        if (false == $this->collWidgetStatss->contains($obj)) {
                          $this->collWidgetStatss->append($obj);
                        }
                      }

                      $this->collWidgetStatssPartial = true;
                    }

                    $collWidgetStatss->getInternalIterator()->rewind();

                    return $collWidgetStatss;
                }

                if ($partial && $this->collWidgetStatss) {
                    foreach ($this->collWidgetStatss as $obj) {
                        if ($obj->isNew()) {
                            $collWidgetStatss[] = $obj;
                        }
                    }
                }

                $this->collWidgetStatss = $collWidgetStatss;
                $this->collWidgetStatssPartial = false;
            }
        }

        return $this->collWidgetStatss;
    }

    /**
     * Sets a collection of WidgetStats objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $widgetStatss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Product The current object (for fluent API support)
     */
    public function setWidgetStatss(PropelCollection $widgetStatss, PropelPDO $con = null)
    {
        $widgetStatssToDelete = $this->getWidgetStatss(new Criteria(), $con)->diff($widgetStatss);


        $this->widgetStatssScheduledForDeletion = $widgetStatssToDelete;

        foreach ($widgetStatssToDelete as $widgetStatsRemoved) {
            $widgetStatsRemoved->setProduct(null);
        }

        $this->collWidgetStatss = null;
        foreach ($widgetStatss as $widgetStats) {
            $this->addWidgetStats($widgetStats);
        }

        $this->collWidgetStatss = $widgetStatss;
        $this->collWidgetStatssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WidgetStats objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related WidgetStats objects.
     * @throws PropelException
     */
    public function countWidgetStatss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collWidgetStatssPartial && !$this->isNew();
        if (null === $this->collWidgetStatss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWidgetStatss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWidgetStatss());
            }
            $query = WidgetStatsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProduct($this)
                ->count($con);
        }

        return count($this->collWidgetStatss);
    }

    /**
     * Method called to associate a WidgetStats object to this object
     * through the WidgetStats foreign key attribute.
     *
     * @param    WidgetStats $l WidgetStats
     * @return Product The current object (for fluent API support)
     */
    public function addWidgetStats(WidgetStats $l)
    {
        if ($this->collWidgetStatss === null) {
            $this->initWidgetStatss();
            $this->collWidgetStatssPartial = true;
        }

        if (!in_array($l, $this->collWidgetStatss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddWidgetStats($l);

            if ($this->widgetStatssScheduledForDeletion and $this->widgetStatssScheduledForDeletion->contains($l)) {
                $this->widgetStatssScheduledForDeletion->remove($this->widgetStatssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	WidgetStats $widgetStats The widgetStats object to add.
     */
    protected function doAddWidgetStats($widgetStats)
    {
        $this->collWidgetStatss[]= $widgetStats;
        $widgetStats->setProduct($this);
    }

    /**
     * @param	WidgetStats $widgetStats The widgetStats object to remove.
     * @return Product The current object (for fluent API support)
     */
    public function removeWidgetStats($widgetStats)
    {
        if ($this->getWidgetStatss()->contains($widgetStats)) {
            $this->collWidgetStatss->remove($this->collWidgetStatss->search($widgetStats));
            if (null === $this->widgetStatssScheduledForDeletion) {
                $this->widgetStatssScheduledForDeletion = clone $this->collWidgetStatss;
                $this->widgetStatssScheduledForDeletion->clear();
            }
            $this->widgetStatssScheduledForDeletion[]= $widgetStats;
            $widgetStats->setProduct(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Product is new, it will return
     * an empty collection; or if this Product has previously
     * been saved, it will retrieve related WidgetStatss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Product.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|WidgetStats[] List of WidgetStats objects
     */
    public function getWidgetStatssJoinUpSell($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = WidgetStatsQuery::create(null, $criteria);
        $query->joinWith('UpSell', $join_behavior);

        return $this->getWidgetStatss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->shoplo_product_id = null;
        $this->shop_domain = null;
        $this->name = null;
        $this->img_url = null;
        $this->original_price = null;
        $this->current_price = null;
        $this->availability = null;
        $this->url = null;
        $this->thumbnail = null;
        $this->sku = null;
        $this->description = null;
        $this->variants = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collWidgetStatss) {
                foreach ($this->collWidgetStatss as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collWidgetStatss instanceof PropelCollection) {
            $this->collWidgetStatss->clearIterator();
        }
        $this->collWidgetStatss = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
