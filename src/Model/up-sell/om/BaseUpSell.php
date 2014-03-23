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
use src\Model\ProductInCart;
use src\Model\ProductInCartQuery;
use src\Model\RelatedProduct;
use src\Model\RelatedProductQuery;
use src\Model\UpSell;
use src\Model\UpSellPeer;
use src\Model\UpSellQuery;

/**
 * Base class that represents a row from the 'up_sell' table.
 *
 *
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseUpSell extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'src\\Model\\UpSellPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        UpSellPeer
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
     * The value for the shop_id field.
     * @var        int
     */
    protected $shop_id;

    /**
     * The value for the order field.
     * @var        int
     */
    protected $order;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the headline field.
     * @var        string
     */
    protected $headline;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the price_from field.
     * @var        double
     */
    protected $price_from;

    /**
     * The value for the price_to field.
     * @var        double
     */
    protected $price_to;

    /**
     * @var        PropelObjectCollection|ProductInCart[] Collection to store aggregation of ProductInCart objects.
     */
    protected $collProductInCarts;
    protected $collProductInCartsPartial;

    /**
     * @var        PropelObjectCollection|RelatedProduct[] Collection to store aggregation of RelatedProduct objects.
     */
    protected $collRelatedProducts;
    protected $collRelatedProductsPartial;

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
    protected $productInCartsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $relatedProductsScheduledForDeletion = null;

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
     * Get the [shop_id] column value.
     *
     * @return int
     */
    public function getShopId()
    {

        return $this->shop_id;
    }

    /**
     * Get the [order] column value.
     *
     * @return int
     */
    public function getOrder()
    {

        return $this->order;
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
     * Get the [headline] column value.
     *
     * @return string
     */
    public function getHeadline()
    {

        return $this->headline;
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
     * Get the [price_from] column value.
     *
     * @return double
     */
    public function getPriceFrom()
    {

        return $this->price_from;
    }

    /**
     * Get the [price_to] column value.
     *
     * @return double
     */
    public function getPriceTo()
    {

        return $this->price_to;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = UpSellPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [shop_id] column.
     *
     * @param  int $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setShopId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->shop_id !== $v) {
            $this->shop_id = $v;
            $this->modifiedColumns[] = UpSellPeer::SHOP_ID;
        }


        return $this;
    } // setShopId()

    /**
     * Set the value of [order] column.
     *
     * @param  int $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setOrder($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->order !== $v) {
            $this->order = $v;
            $this->modifiedColumns[] = UpSellPeer::ORDER;
        }


        return $this;
    } // setOrder()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = UpSellPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [headline] column.
     *
     * @param  string $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setHeadline($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->headline !== $v) {
            $this->headline = $v;
            $this->modifiedColumns[] = UpSellPeer::HEADLINE;
        }


        return $this;
    } // setHeadline()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = UpSellPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [price_from] column.
     *
     * @param  double $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setPriceFrom($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->price_from !== $v) {
            $this->price_from = $v;
            $this->modifiedColumns[] = UpSellPeer::PRICE_FROM;
        }


        return $this;
    } // setPriceFrom()

    /**
     * Set the value of [price_to] column.
     *
     * @param  double $v new value
     * @return UpSell The current object (for fluent API support)
     */
    public function setPriceTo($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->price_to !== $v) {
            $this->price_to = $v;
            $this->modifiedColumns[] = UpSellPeer::PRICE_TO;
        }


        return $this;
    } // setPriceTo()

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
            $this->shop_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->order = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->headline = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->price_from = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
            $this->price_to = ($row[$startcol + 7] !== null) ? (double) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = UpSellPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating UpSell object", $e);
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
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = UpSellPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collProductInCarts = null;

            $this->collRelatedProducts = null;

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
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = UpSellQuery::create()
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
            $con = Propel::getConnection(UpSellPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                UpSellPeer::addInstanceToPool($this);
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

            if ($this->productInCartsScheduledForDeletion !== null) {
                if (!$this->productInCartsScheduledForDeletion->isEmpty()) {
                    ProductInCartQuery::create()
                        ->filterByPrimaryKeys($this->productInCartsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->productInCartsScheduledForDeletion = null;
                }
            }

            if ($this->collProductInCarts !== null) {
                foreach ($this->collProductInCarts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->relatedProductsScheduledForDeletion !== null) {
                if (!$this->relatedProductsScheduledForDeletion->isEmpty()) {
                    RelatedProductQuery::create()
                        ->filterByPrimaryKeys($this->relatedProductsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->relatedProductsScheduledForDeletion = null;
                }
            }

            if ($this->collRelatedProducts !== null) {
                foreach ($this->collRelatedProducts as $referrerFK) {
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

        $this->modifiedColumns[] = UpSellPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UpSellPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UpSellPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(UpSellPeer::SHOP_ID)) {
            $modifiedColumns[':p' . $index++]  = '`shop_id`';
        }
        if ($this->isColumnModified(UpSellPeer::ORDER)) {
            $modifiedColumns[':p' . $index++]  = '`order`';
        }
        if ($this->isColumnModified(UpSellPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(UpSellPeer::HEADLINE)) {
            $modifiedColumns[':p' . $index++]  = '`headline`';
        }
        if ($this->isColumnModified(UpSellPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(UpSellPeer::PRICE_FROM)) {
            $modifiedColumns[':p' . $index++]  = '`price_from`';
        }
        if ($this->isColumnModified(UpSellPeer::PRICE_TO)) {
            $modifiedColumns[':p' . $index++]  = '`price_to`';
        }

        $sql = sprintf(
            'INSERT INTO `up_sell` (%s) VALUES (%s)',
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
                    case '`shop_id`':
                        $stmt->bindValue($identifier, $this->shop_id, PDO::PARAM_INT);
                        break;
                    case '`order`':
                        $stmt->bindValue($identifier, $this->order, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`headline`':
                        $stmt->bindValue($identifier, $this->headline, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`price_from`':
                        $stmt->bindValue($identifier, $this->price_from, PDO::PARAM_STR);
                        break;
                    case '`price_to`':
                        $stmt->bindValue($identifier, $this->price_to, PDO::PARAM_STR);
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


            if (($retval = UpSellPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collProductInCarts !== null) {
                    foreach ($this->collProductInCarts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collRelatedProducts !== null) {
                    foreach ($this->collRelatedProducts as $referrerFK) {
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
        $pos = UpSellPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getShopId();
                break;
            case 2:
                return $this->getOrder();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getHeadline();
                break;
            case 5:
                return $this->getDescription();
                break;
            case 6:
                return $this->getPriceFrom();
                break;
            case 7:
                return $this->getPriceTo();
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
        if (isset($alreadyDumpedObjects['UpSell'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UpSell'][$this->getPrimaryKey()] = true;
        $keys = UpSellPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getShopId(),
            $keys[2] => $this->getOrder(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getHeadline(),
            $keys[5] => $this->getDescription(),
            $keys[6] => $this->getPriceFrom(),
            $keys[7] => $this->getPriceTo(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collProductInCarts) {
                $result['ProductInCarts'] = $this->collProductInCarts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRelatedProducts) {
                $result['RelatedProducts'] = $this->collRelatedProducts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = UpSellPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setShopId($value);
                break;
            case 2:
                $this->setOrder($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setHeadline($value);
                break;
            case 5:
                $this->setDescription($value);
                break;
            case 6:
                $this->setPriceFrom($value);
                break;
            case 7:
                $this->setPriceTo($value);
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
        $keys = UpSellPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setShopId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrder($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setHeadline($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPriceFrom($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPriceTo($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UpSellPeer::DATABASE_NAME);

        if ($this->isColumnModified(UpSellPeer::ID)) $criteria->add(UpSellPeer::ID, $this->id);
        if ($this->isColumnModified(UpSellPeer::SHOP_ID)) $criteria->add(UpSellPeer::SHOP_ID, $this->shop_id);
        if ($this->isColumnModified(UpSellPeer::ORDER)) $criteria->add(UpSellPeer::ORDER, $this->order);
        if ($this->isColumnModified(UpSellPeer::NAME)) $criteria->add(UpSellPeer::NAME, $this->name);
        if ($this->isColumnModified(UpSellPeer::HEADLINE)) $criteria->add(UpSellPeer::HEADLINE, $this->headline);
        if ($this->isColumnModified(UpSellPeer::DESCRIPTION)) $criteria->add(UpSellPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(UpSellPeer::PRICE_FROM)) $criteria->add(UpSellPeer::PRICE_FROM, $this->price_from);
        if ($this->isColumnModified(UpSellPeer::PRICE_TO)) $criteria->add(UpSellPeer::PRICE_TO, $this->price_to);

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
        $criteria = new Criteria(UpSellPeer::DATABASE_NAME);
        $criteria->add(UpSellPeer::ID, $this->id);

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
     * @param object $copyObj An object of UpSell (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setShopId($this->getShopId());
        $copyObj->setOrder($this->getOrder());
        $copyObj->setName($this->getName());
        $copyObj->setHeadline($this->getHeadline());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPriceFrom($this->getPriceFrom());
        $copyObj->setPriceTo($this->getPriceTo());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getProductInCarts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProductInCart($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRelatedProducts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRelatedProduct($relObj->copy($deepCopy));
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
     * @return UpSell Clone of current object.
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
     * @return UpSellPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new UpSellPeer();
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
        if ('ProductInCart' == $relationName) {
            $this->initProductInCarts();
        }
        if ('RelatedProduct' == $relationName) {
            $this->initRelatedProducts();
        }
    }

    /**
     * Clears out the collProductInCarts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return UpSell The current object (for fluent API support)
     * @see        addProductInCarts()
     */
    public function clearProductInCarts()
    {
        $this->collProductInCarts = null; // important to set this to null since that means it is uninitialized
        $this->collProductInCartsPartial = null;

        return $this;
    }

    /**
     * reset is the collProductInCarts collection loaded partially
     *
     * @return void
     */
    public function resetPartialProductInCarts($v = true)
    {
        $this->collProductInCartsPartial = $v;
    }

    /**
     * Initializes the collProductInCarts collection.
     *
     * By default this just sets the collProductInCarts collection to an empty array (like clearcollProductInCarts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProductInCarts($overrideExisting = true)
    {
        if (null !== $this->collProductInCarts && !$overrideExisting) {
            return;
        }
        $this->collProductInCarts = new PropelObjectCollection();
        $this->collProductInCarts->setModel('ProductInCart');
    }

    /**
     * Gets an array of ProductInCart objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this UpSell is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProductInCart[] List of ProductInCart objects
     * @throws PropelException
     */
    public function getProductInCarts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProductInCartsPartial && !$this->isNew();
        if (null === $this->collProductInCarts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProductInCarts) {
                // return empty collection
                $this->initProductInCarts();
            } else {
                $collProductInCarts = ProductInCartQuery::create(null, $criteria)
                    ->filterByUpSell($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProductInCartsPartial && count($collProductInCarts)) {
                      $this->initProductInCarts(false);

                      foreach ($collProductInCarts as $obj) {
                        if (false == $this->collProductInCarts->contains($obj)) {
                          $this->collProductInCarts->append($obj);
                        }
                      }

                      $this->collProductInCartsPartial = true;
                    }

                    $collProductInCarts->getInternalIterator()->rewind();

                    return $collProductInCarts;
                }

                if ($partial && $this->collProductInCarts) {
                    foreach ($this->collProductInCarts as $obj) {
                        if ($obj->isNew()) {
                            $collProductInCarts[] = $obj;
                        }
                    }
                }

                $this->collProductInCarts = $collProductInCarts;
                $this->collProductInCartsPartial = false;
            }
        }

        return $this->collProductInCarts;
    }

    /**
     * Sets a collection of ProductInCart objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $productInCarts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return UpSell The current object (for fluent API support)
     */
    public function setProductInCarts(PropelCollection $productInCarts, PropelPDO $con = null)
    {
        $productInCartsToDelete = $this->getProductInCarts(new Criteria(), $con)->diff($productInCarts);


        $this->productInCartsScheduledForDeletion = $productInCartsToDelete;

        foreach ($productInCartsToDelete as $productInCartRemoved) {
            $productInCartRemoved->setUpSell(null);
        }

        $this->collProductInCarts = null;
        foreach ($productInCarts as $productInCart) {
            $this->addProductInCart($productInCart);
        }

        $this->collProductInCarts = $productInCarts;
        $this->collProductInCartsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProductInCart objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProductInCart objects.
     * @throws PropelException
     */
    public function countProductInCarts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProductInCartsPartial && !$this->isNew();
        if (null === $this->collProductInCarts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProductInCarts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getProductInCarts());
            }
            $query = ProductInCartQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUpSell($this)
                ->count($con);
        }

        return count($this->collProductInCarts);
    }

    /**
     * Method called to associate a ProductInCart object to this object
     * through the ProductInCart foreign key attribute.
     *
     * @param    ProductInCart $l ProductInCart
     * @return UpSell The current object (for fluent API support)
     */
    public function addProductInCart(ProductInCart $l)
    {
        if ($this->collProductInCarts === null) {
            $this->initProductInCarts();
            $this->collProductInCartsPartial = true;
        }

        if (!in_array($l, $this->collProductInCarts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProductInCart($l);

            if ($this->productInCartsScheduledForDeletion and $this->productInCartsScheduledForDeletion->contains($l)) {
                $this->productInCartsScheduledForDeletion->remove($this->productInCartsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ProductInCart $productInCart The productInCart object to add.
     */
    protected function doAddProductInCart($productInCart)
    {
        $this->collProductInCarts[]= $productInCart;
        $productInCart->setUpSell($this);
    }

    /**
     * @param	ProductInCart $productInCart The productInCart object to remove.
     * @return UpSell The current object (for fluent API support)
     */
    public function removeProductInCart($productInCart)
    {
        if ($this->getProductInCarts()->contains($productInCart)) {
            $this->collProductInCarts->remove($this->collProductInCarts->search($productInCart));
            if (null === $this->productInCartsScheduledForDeletion) {
                $this->productInCartsScheduledForDeletion = clone $this->collProductInCarts;
                $this->productInCartsScheduledForDeletion->clear();
            }
            $this->productInCartsScheduledForDeletion[]= clone $productInCart;
            $productInCart->setUpSell(null);
        }

        return $this;
    }

    /**
     * Clears out the collRelatedProducts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return UpSell The current object (for fluent API support)
     * @see        addRelatedProducts()
     */
    public function clearRelatedProducts()
    {
        $this->collRelatedProducts = null; // important to set this to null since that means it is uninitialized
        $this->collRelatedProductsPartial = null;

        return $this;
    }

    /**
     * reset is the collRelatedProducts collection loaded partially
     *
     * @return void
     */
    public function resetPartialRelatedProducts($v = true)
    {
        $this->collRelatedProductsPartial = $v;
    }

    /**
     * Initializes the collRelatedProducts collection.
     *
     * By default this just sets the collRelatedProducts collection to an empty array (like clearcollRelatedProducts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRelatedProducts($overrideExisting = true)
    {
        if (null !== $this->collRelatedProducts && !$overrideExisting) {
            return;
        }
        $this->collRelatedProducts = new PropelObjectCollection();
        $this->collRelatedProducts->setModel('RelatedProduct');
    }

    /**
     * Gets an array of RelatedProduct objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this UpSell is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|RelatedProduct[] List of RelatedProduct objects
     * @throws PropelException
     */
    public function getRelatedProducts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collRelatedProductsPartial && !$this->isNew();
        if (null === $this->collRelatedProducts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRelatedProducts) {
                // return empty collection
                $this->initRelatedProducts();
            } else {
                $collRelatedProducts = RelatedProductQuery::create(null, $criteria)
                    ->filterByUpSell($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collRelatedProductsPartial && count($collRelatedProducts)) {
                      $this->initRelatedProducts(false);

                      foreach ($collRelatedProducts as $obj) {
                        if (false == $this->collRelatedProducts->contains($obj)) {
                          $this->collRelatedProducts->append($obj);
                        }
                      }

                      $this->collRelatedProductsPartial = true;
                    }

                    $collRelatedProducts->getInternalIterator()->rewind();

                    return $collRelatedProducts;
                }

                if ($partial && $this->collRelatedProducts) {
                    foreach ($this->collRelatedProducts as $obj) {
                        if ($obj->isNew()) {
                            $collRelatedProducts[] = $obj;
                        }
                    }
                }

                $this->collRelatedProducts = $collRelatedProducts;
                $this->collRelatedProductsPartial = false;
            }
        }

        return $this->collRelatedProducts;
    }

    /**
     * Sets a collection of RelatedProduct objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $relatedProducts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return UpSell The current object (for fluent API support)
     */
    public function setRelatedProducts(PropelCollection $relatedProducts, PropelPDO $con = null)
    {
        $relatedProductsToDelete = $this->getRelatedProducts(new Criteria(), $con)->diff($relatedProducts);


        $this->relatedProductsScheduledForDeletion = $relatedProductsToDelete;

        foreach ($relatedProductsToDelete as $relatedProductRemoved) {
            $relatedProductRemoved->setUpSell(null);
        }

        $this->collRelatedProducts = null;
        foreach ($relatedProducts as $relatedProduct) {
            $this->addRelatedProduct($relatedProduct);
        }

        $this->collRelatedProducts = $relatedProducts;
        $this->collRelatedProductsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RelatedProduct objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related RelatedProduct objects.
     * @throws PropelException
     */
    public function countRelatedProducts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collRelatedProductsPartial && !$this->isNew();
        if (null === $this->collRelatedProducts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRelatedProducts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRelatedProducts());
            }
            $query = RelatedProductQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUpSell($this)
                ->count($con);
        }

        return count($this->collRelatedProducts);
    }

    /**
     * Method called to associate a RelatedProduct object to this object
     * through the RelatedProduct foreign key attribute.
     *
     * @param    RelatedProduct $l RelatedProduct
     * @return UpSell The current object (for fluent API support)
     */
    public function addRelatedProduct(RelatedProduct $l)
    {
        if ($this->collRelatedProducts === null) {
            $this->initRelatedProducts();
            $this->collRelatedProductsPartial = true;
        }

        if (!in_array($l, $this->collRelatedProducts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRelatedProduct($l);

            if ($this->relatedProductsScheduledForDeletion and $this->relatedProductsScheduledForDeletion->contains($l)) {
                $this->relatedProductsScheduledForDeletion->remove($this->relatedProductsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	RelatedProduct $relatedProduct The relatedProduct object to add.
     */
    protected function doAddRelatedProduct($relatedProduct)
    {
        $this->collRelatedProducts[]= $relatedProduct;
        $relatedProduct->setUpSell($this);
    }

    /**
     * @param	RelatedProduct $relatedProduct The relatedProduct object to remove.
     * @return UpSell The current object (for fluent API support)
     */
    public function removeRelatedProduct($relatedProduct)
    {
        if ($this->getRelatedProducts()->contains($relatedProduct)) {
            $this->collRelatedProducts->remove($this->collRelatedProducts->search($relatedProduct));
            if (null === $this->relatedProductsScheduledForDeletion) {
                $this->relatedProductsScheduledForDeletion = clone $this->collRelatedProducts;
                $this->relatedProductsScheduledForDeletion->clear();
            }
            $this->relatedProductsScheduledForDeletion[]= clone $relatedProduct;
            $relatedProduct->setUpSell(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->shop_id = null;
        $this->order = null;
        $this->name = null;
        $this->headline = null;
        $this->description = null;
        $this->price_from = null;
        $this->price_to = null;
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
            if ($this->collProductInCarts) {
                foreach ($this->collProductInCarts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRelatedProducts) {
                foreach ($this->collRelatedProducts as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collProductInCarts instanceof PropelCollection) {
            $this->collProductInCarts->clearIterator();
        }
        $this->collProductInCarts = null;
        if ($this->collRelatedProducts instanceof PropelCollection) {
            $this->collRelatedProducts->clearIterator();
        }
        $this->collRelatedProducts = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UpSellPeer::DEFAULT_STRING_FORMAT);
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
