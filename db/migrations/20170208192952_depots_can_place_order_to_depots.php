<?php

use Phinx\Migration\AbstractMigration;
use App\Models;
class DepotsCanPlaceOrderToDepots extends AbstractMigration
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
         $users = Models\Users::where('capability','depot')->get(); 
         foreach ($users as $key => $value) {
          Models\PlantsConfiguration::where('plant_id',$value->id)->where('key','can_take_orders_from_plants')->delete();
          Models\PlantsConfiguration::create([
            'plant_id' => $value->id,
            'key' => 'can_take_orders_from_plants',
            'value' => 1
            ]);
         }
    }
}
