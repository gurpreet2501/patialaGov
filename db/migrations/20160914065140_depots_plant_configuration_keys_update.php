<?php
use App\Models as M;
use Phinx\Migration\AbstractMigration;

class DepotsPlantConfigurationKeysUpdate extends AbstractMigration
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
        $depots = M\Users::where('capability','depot')->get();
        
        foreach ($depots as $key => $value) {
            M\PlantsConfiguration::where('key','can_accept_domestic_order')->where('plant_id', $value->id)->firstOrCreate(
                    [
                        'plant_id' => $value->id,
                        'key'  => 'can_accept_domestic_order',
                        'value' => 1
                    ]
                );

             M\PlantsConfiguration::where('key','can_place_orders')->where('plant_id', $value->id)->firstOrCreate(
                    [
                        'plant_id' => $value->id,
                        'key'  => 'can_place_orders',
                        'value' => 1
                    ]
                );

             M\PlantsConfiguration::where('key','can_do_export')->where('plant_id', $value->id)->firstOrCreate(
                    [
                        'plant_id' => $value->id,
                        'key'  => 'can_do_export',
                        'value' => 0
                    ]
                );

        }
    }
}
