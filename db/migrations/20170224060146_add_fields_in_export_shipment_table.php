<?php

use Phinx\Migration\AbstractMigration;

class AddFieldsInExportShipmentTable extends AbstractMigration
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
        $table = $this->table('shipment_export');
        $table->addColumn('invoice_no', 'string')
            ->addColumn('invoice_date','datetime')
            ->addColumn('container_arrival_date','datetime')
            ->addColumn('container_no','string')
            ->addColumn('container_gate_out','boolean')
            ->addColumn('truck_no','string')
            ->addColumn('gross_weight','string')
            ->addColumn('net_weight','string')
            ->addColumn('shipping_bill_no','integer')
            ->addColumn('shipping_bill_date','datetime')
            ->addColumn('bill_no','string')
            ->addColumn('bill_date','datetime')
            ->update();

    }
}
