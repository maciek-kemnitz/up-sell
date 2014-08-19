<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'related_product' table.
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
class RelatedProductTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.RelatedProductTableMap';

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
        $this->setName('related_product');
        $this->setPhpName('RelatedProduct');
        $this->setClassname('src\\Model\\RelatedProduct');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('up_sell_id', 'UpSellId', 'INTEGER', 'up_sell', 'id', true, null, null);
        $this->addColumn('product_id', 'ProductId', 'INTEGER', true, null, null);
        $this->addColumn('variant_selected', 'VariantSelected', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UpSell', 'src\\Model\\UpSell', RelationMap::MANY_TO_ONE, array('up_sell_id' => 'id', ), null, null);
    } // buildRelations()

} // RelatedProductTableMap
