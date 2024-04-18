<?php
namespace model\Products;

use model\App;
use model\Inventory\Inventory;
use sys\store\AppData;

class Product extends App
{

    private $TableName = "tbl_products";

    public function __construct()
    {
        $this->__initialize();
    }

    public function __create_products($prd_name, $prd_category, $prd_description,$supplier,$buying_price, $selling_price, $qty_in, $qty_out, $minimum_stock_value)
    {
        if(strlen($prd_name)&& strlen($prd_category) && $buying_price<0 && $qty_in<0):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "prd_name"=>$prd_name,
            "prd_category"=>$prd_category,
            "buying_price"=>$buying_price,
            "selling_price"=>$selling_price,
            "supplier"=>$supplier,
            "prd_description"=>$prd_description
          
        ];
        if ($prd_id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Product created successfully!!";

            $NewInventory = new Inventory;
            if($NewInventory->__create_inventory($prd_id, $prd_name, $qty_in, $qty_out, $minimum_stock_value,)
            
            ){
                $this->Success .= $NewInventory->Success;
            }
            $this->Error = $NewInventory->Error;
            return $prd_id;
            
            
        endif;
        $this->Error = "An error occurred while creating product";
        return false;

    }

    public function __get_prd_list()
    {

        $this->__total_prd();
        if($this->__get_total_records() === 0 ){
            $this->Error = "No products found";
        }else {
            $this->__paginate();
        }

        $query= "SELECT * FROM `$this->TableName`";
        $query .= " ORDER BY created_at DESC";
        $query .= " LIMIT $this->PageStart, $this->ItemsPerPage";
     
        $result = AppData::__execute($query);

        $num = $result-> num_rows;

        $list_data = $this->__get_pagination_data($num);

        $list =[];

        while($row =$result->fetch_assoc()):
            $list [] =$this->__std_data_format($row);
        endwhile;
        $list_data['list']= $list;

        return $list_data;
    
    }

    public function __newest_prd(){
        $query= "SELECT * FROM tbl_products
        ORDER BY created_at DESC
        LIMIT 3;
        ";
        $result = AppData::__execute($query);
        $list = [];
        while ($row = $result->fetch_assoc()){
            $list[] = $this->__std_data_format($row);
        }

        return $list;
    }


    public function __get_prd_info($id)
    {
        if(!$objProduct = AppData::__get_row($this->TableName, $id)):
            $this->Error="Product not found";
            return false;
        endif;
        return $this->__std_data_format($objProduct);
    }

    public function __total_prd(){
        $query= "SELECT COUNT(*) AS total_products FROM tbl_products ";

        $result= AppData::__execute($query);
        
        if ($result){
            $row= $result->fetch_assoc()['total_products'];

            $this->__set_total_records($row);

            return $row;

        }else{
            $this->Error= "Error occured while fetching products";
        }

    }

    public function __update_product($id,$prd_name,$prd_category,$buying_price, $selling_price, $supplier,$prd_description ){

            if($id<0 || len($prd_name)):
                $this->Error = "Please fill in all product details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "prd_name"=>$prd_name,
                "prd_category"=>$prd_category,
                "buying_price"=>$buying_price,
                "selling_price"=>$selling_price,
                "supplier"=>$supplier,
                "prd_description"=>$prd_description,
                
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "product updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating product";
            return false;
        }

    public function __table_limit(){

        $limit=10;

        $rows= array();

        $query= "SELECT * FROM tbl_products LIMIT $limit";

        $result= AppData::__execute($query);

        while ($row= $result->fetch_assoc()){

            $rows [] = $row;

            if(count($rows) >= $limit){
                break;
            }     
        }

        return $rows;

      
    }

        public function __delete_product($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="product deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "prd_name"=>$data->prd_name,
            "prd_category"=>$data->prd_category,
            "prd_description"=>$data->prd_description,
            "buying_price"=>$data->buying_price,
            "selling_price"=>$data->selling_price,
            "supplier"=>$data->supplier,

              
        ];
    }

    private function __initialize()
    {
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= " `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= " `prd_name` VARCHAR(255) NOT NULL,";
            $query .= " `prd_category` VARCHAR(255) NOT NULL,";
            $query .= " `buying_price` INT(11) NOT NULL,";
            $query .= " `selling_price` INT(11) NOT NULL,";
            $query .= " `prd_description` VARCHAR(255) NOT NULL,";
            $query .= " `supplier` VARCHAR(255) NOT NULL,";
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