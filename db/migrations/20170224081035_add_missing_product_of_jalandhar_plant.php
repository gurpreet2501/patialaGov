<?php

use Phinx\Migration\AbstractMigration;
use App\Models;

class AddMissingProductOfJalandharPlant extends AbstractMigration
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

        $file = __DIR__.'/../../missing.csv';
        $file = fopen($file,"r");
        $data = [];
        while(! feof($file))
          {
              $data[] = fgetcsv($file);
          }
          
          array_shift($data);
          $data = array_filter($data);
          $stub =[
            'sku' => $data[0][0],
            'plant_id' => 18,
            'product_name' => $data[0][2],
            'weight' => $data[0][3],
            'weight_unit' => $data[0][4],
          ];
          
         Models\Products::create($stub);


    }
}
