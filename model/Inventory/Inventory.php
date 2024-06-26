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

    public function __create_inventory($prd_id, $prd_name, $qty_in, $qty_out, $minimum_stock_value)
    {
        if($prd_id<0 && $qty_in<0):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "prd_id"=>$prd_id,
            "qty_in"=>$qty_in,
            "qty_out"=>$qty_out,
            "minimum_stock_value"=>$minimum_stock_value
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

        $this->__total_inventory();
        if($this->__get_total_records()===0){
            $this->Error = "No records found";
        }else{
            $this->__paginate();
        }

        $query = "SELECT * FROM `$this->TableName`";
        $query .= " ORDER BY created_at DESC";
        $query .= " LIMIT $this->PageStart, $this->ItemsPerPage";

        $result = AppData::__execute($query);

        $num= $result->num_rows;

        $list_data= $this->__get_pagination_data($num);

        $list =[];

        while($row =$result->fetch_assoc()):
            $list [] =$this->__std_data_format($row);
        
        endwhile;

        $list_data['list'] = $list;

        return $list_data;
    }

    public function __get_inv_info($id)
    {
        if(!$objInventory = AppData::__get_row($this->TableName, $id)):
            $this->Error="Item not found";
            return false;
        endif;
        return $this->__std_data_format($objInventory);
    }

    public function __total_inventory(){
        $query= "SELECT COUNT(*) AS total_inventory FROM `$this->TableName`";

        $result = AppData::__execute($query);

        if($result){
            $row = $result->fetch_assoc()['total_inventory'];

            $this->__set_total_records($row);

            return $row;

        }else{
            $this->Error= "No Inventory found";
        }
    }

    public function __re_order_stock($minimum_stock_value,$qty_in){
      
        $query = "SELECT 
                    prd_id, 
                    qty_in,
                    minimum_stock_value, 
                    CASE 
                        WHEN qty_in <= minimum_stock_value THEN 'Reorder needed!!!'
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
            $minimum_stock_value = $row['minimum_stock_value'];
        
            // Assuming you want to set some variable based on the reorder status.
            if ($minimum_stock_value === 'Reorder needed!!!') {
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


    public function __update_inventory($id, $prd_id, $minimum_stock_value, $qty_in, $qty_out){

            if($id<=0 || $qty_in<0 || $qty_out<0):
                $this->Error = "Please fill in all contact details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "prd_id"=>$prd_id,
                "qty_in"=>$qty_in,
                "qty_out"=>$qty_out,
                "minimum_stock_value"=>$minimum_stock_value,
                
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
            "minimum_stock_value"=>$data->minimum_stock_value, 
        ];
    }

    private function __initialize()
    
   
    { 
        new Product;

        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`prd_id` VARCHAR(255) NOT NULL,";
            $query .= "`prd_name`VARCHAR(255) NOT NULL,";
            $query .= " `qty_in` INT(11) NOT NULL,";
            $query .= " `qty_out` INT(11) NOT NULL,";
            $query .= " `minimum_stock_value` INT(11) NOT NULL,";
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