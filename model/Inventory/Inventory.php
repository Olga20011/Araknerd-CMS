<?php
namespace model\Inventory;

use model\App;
use sys\store\AppData;
use model\Products\Product;
class Inventory extends App
{

    private $TableName = "tbl_inventory";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_inventory($prd_id, $qty_in, $qty_out, $reorder_point)
    {
        if($prd_id<0 && $qty_in<0):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "prd_id"=>$prd_id,
            "qty_in"=>$qty_in,
            "qty_out"=>$qty_out,
            "reorder_point"=>$reorder_point
        ];
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Inventory created successfully!!";
            
            return $id;
        endif;
        $this->Error = "An error occurred while creating inventory";
        return false;

    }

    public function __get_inv_list()
    {
        if(!$objInventory  = AppData::__get_rows($this->TableName)):
            $this->Error="Inventory not found";
            return false;
        endif;

     $list =[];

        while($row =$objInventory->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_inv_info($id)
    {
        if(!$objInventory = AppData::__get_row($this->TableName, $id)):
            $this->Error="Item not found";
            return false;
        endif;
        return $this->__std_data_format($objInventory);
    }

    public function __re_order_stock($reorder_point, $qty_in){
      
        $query = "SELECT 
                    prd_id, 
                    qty_in,
                    reorder_point, 
                    CASE 
                        WHEN qty_in <= reorder_point THEN 'Reorder needed!!!'
                        ELSE 'No reorder needed'
                    END AS reorder_status
                  FROM tbl_inventory";
        
        $result = AppData::__execute($query);
        
        $list = [];
        
        while ($row = $result->fetch_assoc()) {
            $list[] = $row; // No need for __std_data_format here, assuming it's a formatting function.
        }
        
        // Process the results or use them as needed.
        foreach ($list as $row) {
            $productId = $row['prd_id'];
            $reorderPoint = $row['reorder_point'];
        
            // Assuming you want to set some variable based on the reorder status.
            if ($reorderPoint === 'Reorder needed!!!') {
                $this->Success = "Product with ID $productId needs to be reordered!";
            } else {
                // No reorder needed for this product.
                // You can handle this case as needed.
            }
        }
        
        // Return the list of products with reorder status.
        return $list;

    }

    public function __total_qty() {

        $query= "SELECT COUNT(*) AS total_qty FROM tbl_inventory";

        $result = AppData::__execute($query);

        $row = $result->fetch_assoc();

        if ($row){
            $totalQty = $row['total_qty'];

            return $totalQty;
        }else{
            $this->Error="Error fetching total quantity";
        }
    }


    public function __update_inventory($id, $prd_id, $reorder_point, $qty_in, $qty_out){

            if($id<=0 || $qty_in<0 || $qty_out<0):
                $this->Error = "Please fill in all contact details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "prd_id"=>$prd_id,
                "qty_in"=>$qty_in,
                "qty_out"=>$qty_out,
                "reorder_point"=>$reorder_point,
                
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "inventory updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating inventory";
            return false;
        }

        public function __delete_inventory($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="inventory deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }
    

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "prd_id"=>$data->prd_id,
            "qty_in"=>$data->qty_in,
            "qty_out"=>$data->qty_out,
            "reorder_point"=>$data->reorder_point, 
        ];
    }

    private function __initialize()
    
   
    { 
        new Product;

        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`prd_id` VARCHAR(255) NOT NULL,";
            $query .= " `qty_in` INT(11) NOT NULL,";
            $query .= " `qty_out` INT(11) NOT NULL,";
            $query .= " `reorder_point` INT(11) NOT NULL,";
            $query .= " `created_at` timestamp NOT NULL DEFAULT current_timestamp(),";
            $query .= " `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()";
            $query .= ") ENGINE=InnoDB";
            AppData::__execute($query);


            // create default user
            // $this->__create_products("omo");
        }
    }



}

?>