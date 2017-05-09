<?php

use Phinx\Migration\AbstractMigration;
use App\Models as M;

class CreateKeyForPlantsProductTypes extends AbstractMigration
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
        $plant_product_types = [
            'khanna'  => 'edible_products',
            'jalandhar'  => 'edible_products',
            'nawanshahr' => 'edible_products',
            'mohali'     => 'agro_chemical_products',
            'kapurthala' => 'cattle_feed_products',
            'gidderbahamarkfed' => 'cattle_feed_products',
        ];

            foreach($plant_product_types as $key => $value) {
                $plant  = M\Users::select('id')->where('username',$key)->first();
                if(!isset($plant->id))
                    continue;
                
                $entry = M\PlantsConfiguration::select('id')->where(
                    [
                        'plant_id' => $plant->id,
                        'key' => $value,
                    ]
                    )->first();
                
                if(isset($entry->id))
                    continue;
                M\PlantsConfiguration::create([
                    'plant_id' =>   $plant->id,
                    'key'  => $value,
                    'value' => 1
                ]);
                
            }
    }
}
