<?php

use Phinx\Migration\AbstractMigration;

class CustomersTble extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {   
        $table = $this->table('customers', array('id' => true));
        $table->addColumn('name', 'string', array('limit' => 200))
              ->addColumn('phone', 'string',['limit' => 50])
              ->addColumn('address', 'string', array('limit' => 500))
              ->addColumn('city', 'string',['limit' => 50])
              ->addColumn('state', 'string',['limit' => 50])
              ->addColumn('Country', 'string',['limit' => 50])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->save();
    }
}
