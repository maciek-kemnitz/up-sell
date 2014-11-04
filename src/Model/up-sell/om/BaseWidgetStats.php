<?php

namespace src\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use src\Model\Product;
use src\Model\ProductQuery;
use src\Model\UpSell;
use src\Model\UpSellQuery;
use src\Model\WidgetStats;
use src\Model\WidgetStatsPeer;
use src\Model\WidgetStatsQuery;

/**
 * Base class that represents a row from the 'widget_stats' table.
 *
 *
 *
 * @package    propel.generator.up-sell.om
 */
abstract class BaseWidgetStats extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'src\\Model\\WidgetStatsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        WidgetStatsPeer
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
     * The value for the shop_domain field.
     * @var        string
     */
    protected $shop_domain;

    /**
     * The value for the up_sell_id field.
     * @var        int
     */
    protected $up_sell_id;

    /**
     * The value for the variant_id field.
     * @var        int
     */
    protected $variant_id;

    /**
     * The value for the placement field.
     * Note: this column has a database default value of: 'product'
     * @var        string
     */
    protected $placement;

    /**
     * The value for the user_key field.
     * @var        string
     */
    protected $user_key;

    /**
     * The value for the status field.
     * Note: this column has a database default value of: 'new'
     * @var        string
     */
    protected $status;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * @var        UpSell
     */
    protected $aUpSell;

    /**
     * @var        Product
     */
    protected $aProduct;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->placement = 'product';
        $this->status = 'new';
    }

    /**
     * Initializes internal state of BaseWidgetStats object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

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
     * Get the [shop_domain] column value.
     *
     * @return string
     */
    public function getShopDomain()
    {

        return $this->shop_domain;
    }

    /**
     * Get the [up_sell_id] column value.
     *
     * @return int
     */
    public function getUpSellId()
    {

        return $this->up_sell_id;
    }

    /**
     * Get the [variant_id] column value.
     *
     * @return int
     */
    public function getVariantId()
    {

        return $this->variant_id;
    }

    /**
     * Get the [placement] column value.
     *
     * @return string
     */
    public function getPlacement()
    {

        return $this->placement;
    }

    /**
     * Get the [user_key] column value.
     *
     * @return string
     */
    public function getUserKey()
    {

        return $this->user_key;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [shop_domain] column.
     *
     * @param  string $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setShopDomain($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->shop_domain !== $v) {
            $this->shop_domain = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::SHOP_DOMAIN;
        }


        return $this;
    } // setShopDomain()

    /**
     * Set the value of [up_sell_id] column.
     *
     * @param  int $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setUpSellId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->up_sell_id !== $v) {
            $this->up_sell_id = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::UP_SELL_ID;
        }

        if ($this->aUpSell !== null && $this->aUpSell->getId() !== $v) {
            $this->aUpSell = null;
        }


        return $this;
    } // setUpSellId()

    /**
     * Set the value of [variant_id] column.
     *
     * @param  int $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setVariantId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->variant_id !== $v) {
            $this->variant_id = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::VARIANT_ID;
        }

        if ($this->aProduct !== null && $this->aProduct->getShoploProductId() !== $v) {
            $this->aProduct = null;
        }


        return $this;
    } // setVariantId()

    /**
     * Set the value of [placement] column.
     *
     * @param  string $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setPlacement($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->placement !== $v) {
            $this->placement = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::PLACEMENT;
        }


        return $this;
    } // setPlacement()

    /**
     * Set the value of [user_key] column.
     *
     * @param  string $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setUserKey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->user_key !== $v) {
            $this->user_key = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::USER_KEY;
        }


        return $this;
    } // setUserKey()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[] = WidgetStatsPeer::STATUS;
        }


        return $this;
    } // setStatus()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return WidgetStats The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = WidgetStatsPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

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
            if ($this->placement !== 'product') {
                return false;
            }

            if ($this->status !== 'new') {
                return false;
            }

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
            $this->shop_domain = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->up_sell_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->variant_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->placement = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->user_key = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->status = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->created_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = WidgetStatsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating WidgetStats object", $e);
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

        if ($this->aUpSell !== null && $this->up_sell_id !== $this->aUpSell->getId()) {
            $this->aUpSell = null;
        }
        if ($this->aProduct !== null && $this->variant_id !== $this->aProduct->getShoploProductId()) {
            $this->aProduct = null;
        }
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
            $con = Propel::getConnection(WidgetStatsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = WidgetStatsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUpSell = null;
            $this->aProduct = null;
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
            $con = Propel::getConnection(WidgetStatsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = WidgetStatsQuery::create()
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
            $con = Propel::getConnection(WidgetStatsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                WidgetStatsPeer::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUpSell !== null) {
                if ($this->aUpSell->isModified() || $this->aUpSell->isNew()) {
                    $affectedRows += $this->aUpSell->save($con);
                }
                $this->setUpSell($this->aUpSell);
            }

            if ($this->aProduct !== null) {
                if ($this->aProduct->isModified() || $this->aProduct->isNew()) {
                    $affectedRows += $this->aProduct->save($con);
                }
                $this->setProduct($this->aProduct);
            }

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

        $this->modifiedColumns[] = WidgetStatsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WidgetStatsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WidgetStatsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::SHOP_DOMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`shop_domain`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::UP_SELL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`up_sell_id`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::VARIANT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`variant_id`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::PLACEMENT)) {
            $modifiedColumns[':p' . $index++]  = '`placement`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::USER_KEY)) {
            $modifiedColumns[':p' . $index++]  = '`user_key`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::STATUS)) {
            $modifiedColumns[':p' . $index++]  = '`status`';
        }
        if ($this->isColumnModified(WidgetStatsPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }

        $sql = sprintf(
            'INSERT INTO `widget_stats` (%s) VALUES (%s)',
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
                    case '`shop_domain`':
                        $stmt->bindValue($identifier, $this->shop_domain, PDO::PARAM_STR);
                        break;
                    case '`up_sell_id`':
                        $stmt->bindValue($identifier, $this->up_sell_id, PDO::PARAM_INT);
                        break;
                    case '`variant_id`':
                        $stmt->bindValue($identifier, $this->variant_id, PDO::PARAM_INT);
                        break;
                    case '`placement`':
                        $stmt->bindValue($identifier, $this->placement, PDO::PARAM_STR);
                        break;
                    case '`user_key`':
                        $stmt->bindValue($identifier, $this->user_key, PDO::PARAM_STR);
                        break;
                    case '`status`':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
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


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUpSell !== null) {
                if (!$this->aUpSell->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUpSell->getValidationFailures());
                }
            }

            if ($this->aProduct !== null) {
                if (!$this->aProduct->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProduct->getValidationFailures());
                }
            }


            if (($retval = WidgetStatsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = WidgetStatsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getShopDomain();
                break;
            case 2:
                return $this->getUpSellId();
                break;
            case 3:
                return $this->getVariantId();
                break;
            case 4:
                return $this->getPlacement();
                break;
            case 5:
                return $this->getUserKey();
                break;
            case 6:
                return $this->getStatus();
                break;
            case 7:
                return $this->getCreatedAt();
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
        if (isset($alreadyDumpedObjects['WidgetStats'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['WidgetStats'][$this->getPrimaryKey()] = true;
        $keys = WidgetStatsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getShopDomain(),
            $keys[2] => $this->getUpSellId(),
            $keys[3] => $this->getVariantId(),
            $keys[4] => $this->getPlacement(),
            $keys[5] => $this->getUserKey(),
            $keys[6] => $this->getStatus(),
            $keys[7] => $this->getCreatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUpSell) {
                $result['UpSell'] = $this->aUpSell->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProduct) {
                $result['Product'] = $this->aProduct->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = WidgetStatsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setShopDomain($value);
                break;
            case 2:
                $this->setUpSellId($value);
                break;
            case 3:
                $this->setVariantId($value);
                break;
            case 4:
                $this->setPlacement($value);
                break;
            case 5:
                $this->setUserKey($value);
                break;
            case 6:
                $this->setStatus($value);
                break;
            case 7:
                $this->setCreatedAt($value);
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
        $keys = WidgetStatsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setShopDomain($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUpSellId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVariantId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPlacement($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUserKey($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setStatus($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(WidgetStatsPeer::DATABASE_NAME);

        if ($this->isColumnModified(WidgetStatsPeer::ID)) $criteria->add(WidgetStatsPeer::ID, $this->id);
        if ($this->isColumnModified(WidgetStatsPeer::SHOP_DOMAIN)) $criteria->add(WidgetStatsPeer::SHOP_DOMAIN, $this->shop_domain);
        if ($this->isColumnModified(WidgetStatsPeer::UP_SELL_ID)) $criteria->add(WidgetStatsPeer::UP_SELL_ID, $this->up_sell_id);
        if ($this->isColumnModified(WidgetStatsPeer::VARIANT_ID)) $criteria->add(WidgetStatsPeer::VARIANT_ID, $this->variant_id);
        if ($this->isColumnModified(WidgetStatsPeer::PLACEMENT)) $criteria->add(WidgetStatsPeer::PLACEMENT, $this->placement);
        if ($this->isColumnModified(WidgetStatsPeer::USER_KEY)) $criteria->add(WidgetStatsPeer::USER_KEY, $this->user_key);
        if ($this->isColumnModified(WidgetStatsPeer::STATUS)) $criteria->add(WidgetStatsPeer::STATUS, $this->status);
        if ($this->isColumnModified(WidgetStatsPeer::CREATED_AT)) $criteria->add(WidgetStatsPeer::CREATED_AT, $this->created_at);

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
        $criteria = new Criteria(WidgetStatsPeer::DATABASE_NAME);
        $criteria->add(WidgetStatsPeer::ID, $this->id);

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
     * @param object $copyObj An object of WidgetStats (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setShopDomain($this->getShopDomain());
        $copyObj->setUpSellId($this->getUpSellId());
        $copyObj->setVariantId($this->getVariantId());
        $copyObj->setPlacement($this->getPlacement());
        $copyObj->setUserKey($this->getUserKey());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCreatedAt($this->getCreatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return WidgetStats Clone of current object.
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
     * @return WidgetStatsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new WidgetStatsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a UpSell object.
     *
     * @param                  UpSell $v
     * @return WidgetStats The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUpSell(UpSell $v = null)
    {
        if ($v === null) {
            $this->setUpSellId(NULL);
        } else {
            $this->setUpSellId($v->getId());
        }

        $this->aUpSell = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the UpSell object, it will not be re-added.
        if ($v !== null) {
            $v->addWidgetStats($this);
        }


        return $this;
    }


    /**
     * Get the associated UpSell object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return UpSell The associated UpSell object.
     * @throws PropelException
     */
    public function getUpSell(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUpSell === null && ($this->up_sell_id !== null) && $doQuery) {
            $this->aUpSell = UpSellQuery::create()->findPk($this->up_sell_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUpSell->addWidgetStatss($this);
             */
        }

        return $this->aUpSell;
    }

    /**
     * Declares an association between this object and a Product object.
     *
     * @param                  Product $v
     * @return WidgetStats The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProduct(Product $v = null)
    {
        if ($v === null) {
            $this->setVariantId(NULL);
        } else {
            $this->setVariantId($v->getShoploProductId());
        }

        $this->aProduct = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Product object, it will not be re-added.
        if ($v !== null) {
            $v->addWidgetStats($this);
        }


        return $this;
    }


    /**
     * Get the associated Product object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Product The associated Product object.
     * @throws PropelException
     */
    public function getProduct(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProduct === null && ($this->variant_id !== null) && $doQuery) {
            $this->aProduct = ProductQuery::create()
                ->filterByWidgetStats($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProduct->addWidgetStatss($this);
             */
        }

        return $this->aProduct;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->shop_domain = null;
        $this->up_sell_id = null;
        $this->variant_id = null;
        $this->placement = null;
        $this->user_key = null;
        $this->status = null;
        $this->created_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->aUpSell instanceof Persistent) {
              $this->aUpSell->clearAllReferences($deep);
            }
            if ($this->aProduct instanceof Persistent) {
              $this->aProduct->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aUpSell = null;
        $this->aProduct = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WidgetStatsPeer::DEFAULT_STRING_FORMAT);
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
