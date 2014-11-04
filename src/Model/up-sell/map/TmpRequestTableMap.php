<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'tmp_request' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.up-sell.map
 */
class TmpRequestTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.TmpRequestTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('tmp_request');
        $this->setPhpName('TmpRequest');
        $this->setClassname('src\\Model\\TmpRequest');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('data', 'Data', 'LONGVARCHAR', false, null, null);
        $this->addColumn('shop_id', 'ShopId', 'INTEGER', true, null, null);
        $this->addColumn('status', 'Status', 'CHAR', true, null, 'new');
        $this->getColumn('status', false)->setValueSet(array (
  0 => 'new',
  1 => 'calculated',
));
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // TmpRequestTableMap
