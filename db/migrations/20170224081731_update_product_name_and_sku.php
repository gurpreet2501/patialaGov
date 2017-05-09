<?php
use App\Models;
use Phinx\Migration\AbstractMigration;

class UpdateProductNameAndSku extends AbstractMigration
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
    public function getPlantId($name){
      $plant = Models\Users::select('id')->where('full_name',$name)->first();
      return  $plant->id;
    }

    public function get_prod_detail($id){
      $product = Models\Products::where('id',$id)->first();
      return  $product;
    }

    public function change()
    {
        $file = fopen(__DIR__.'/../../Products.csv',"r");
        $data = [];
        while(! feof($file))
          {
              $data[] = fgetcsv($file);
          }
          
          array_shift($data);
          array_shift($data);

          $data = array_filter($data);
          
          $depots = Models\Users::select('id')->where('capability','depot')->get()->toArray();

          foreach ($data as $key => $value) {

              $prod = [
                'sku' => $value[1],
                'product_name' => $value[3],
              ];

              Models\Products::where('id',$value[0])->update($prod);
              
              $product = $this->get_prod_detail($value[0]);
             
              //Finding this product in all depots
              foreach ($depots as $key => $dep) {
              
                $depotProd = Models\Products::select('id')->where('plant_id', $dep['id'])->where('unique_hash', $product->unique_hash)->first();
                
                if($depotProd){
                  
                  Models\Products::where('id',$depotProd->id)->update($prod);  
                  continue;
                 }else{

                    Models\Products::create([
                        'sku' => $product->sku,
                        'price' => $product->price,
                        'product_name' => $product->product_name,
                        'plant_id' => $dep['id'],
                        'unique_hash' => $product->unique_hash,
                        'export_price' =>  $product->export_price,
                        'stock' =>  0,
                        'weight' =>  $product->weight,
                        'weight_unit' =>  $product->weight_unit,
                        'image' =>  $product->image,
                        'status' =>  'Published',
                        'product_type' =>  $product->product_type,
                      ]);

                }
                
              }
                  
          } //for loop ends

    }
}
