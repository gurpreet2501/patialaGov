<?php
use App\Models as M;
use Phinx\Migration\AbstractMigration;

class PlantsWhichCanTakeOrdersPlantConfigurationSetting extends AbstractMigration
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
        $plants = ['khanna','nawanshahr','jalandhar'];

        foreach ($plants as $key => $value) {
            
            $plant = M\Users::select('id')->where('username' , $value)->first();
            if(!$plant)
                continue;

            $data = [
              'plant_id'  => $plant->id,
              'key'       => 'can_take_orders_from_plants',
              'value'     =>  1      
            ];

            M\PlantsConfiguration::create($data);

        }
    }
}
