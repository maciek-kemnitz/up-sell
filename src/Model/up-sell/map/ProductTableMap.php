<?php

namespace src\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'product' table.
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
class ProductTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'up-sell.map.ProductTableMap';

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
        $this->setName('product');
        $this->setPhpName('Product');
        $this->setClassname('src\\Model\\Product');
        $this->setPackage('up-sell');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('shoplo_product_id', 'ShoploProductId', 'INTEGER', true, null, null);
        $this->addColumn('shop_domain', 'ShopDomain', 'VARCHAR', true, 255, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('img_url', 'ImgUrl', 'LONGVARCHAR', true, null, null);
        $this->addColumn('original_price', 'OriginalPrice', 'DOUBLE', true, null, null);
        $this->addColumn('url', 'Url', 'LONGVARCHAR', true, null, null);
        $this->addColumn('thumbnail', 'Thumbnail', 'LONGVARCHAR', true, null, null);
        $this->addColumn('sku', 'Sku', 'FLOAT', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('variants', 'Variants', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('WidgetStats', 'src\\Model\\WidgetStats', RelationMap::ONE_TO_MANY, array('shoplo_product_id' => 'variant_id', ), 'CASCADE', 'CASCADE', 'WidgetStatss');
    } // buildRelations()

} // ProductTableMap
