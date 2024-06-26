<?php
namespace model\CartItem;

use model\App;
use sys\store\AppData;

class CartItem extends App
{

    private $TableName = "tbl_cartItem";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_cartItem($cart_id, $customer_id,$prd_id,$unit_price, $quantity)
    {
        if(($unit_price<0)):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "cart_id"=>$cart_id,
            "customer_id"=>$customer_id,
            "prd_id"=>$prd_id,
            "unit_price"=>$unit_price,
            "quantity"=>$quantity
           
        ];
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Item created successfully!!";
            
            return ['id'=>$id];
        endif;
        $this->Error = "An error occurred while updating Item";
        return false;

    }

    public function __get_cartItem_list()
    {
        if(!$objCart = AppData::__get_rows($this->TableName)):
            $this->Error="item not found";
            return false;
        endif;

     $list =[];

        while($row =$objCart->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }

    
    public function __get_cartItem_info($id)
    {
        if(!$objCart = AppData::__get_row($this->TableName, $id)):
            $this->Error="item not found";
            return false;
        endif;
        return $this->__std_data_format($objCart);
    }

    public function __cartItem_details($id){
        $query= "SELECT * FROM tbl_cart WHERE order_id= $id";

        $result = AppData::__execute($query);

        if ($result){
            $row = $result->fetch_assoc();

            return $row;
        }else{
            $this->Error= "Error";
        }

    }

    

    public function __update_cartItem($id,$unit_price, $total_price,$quantity ){

            if($id<=0 || ($unit_price<0)):
                $this->Error = "Please fill in all item details";
                return false;
            endif;

            $data=[
                "unit_price"=>$unit_price,
                "total_price"=>$total_price,
                "quantity"=>$quantity
            ];
        
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "cart updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating orderItem";
            return false;
        }

        public function __delete_cartItem($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="cart deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }
    

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "customer_id"=>$data->customer_id,
            "unit_price"=>$data->unit_price,
            "quantity"=>$data->quantity
              
        ];
    }

    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`cart_id` INT(11) NOT NULL,";
            $query .= "`prd_id` INT(11) NOT NULL ,";
            $query .= "`customer_id` INT(11) NOT NULL ,";
            $query .= " `quantity` INT(11) NOT NULL,";
            $query .= " `unit_price` INT(11) NOT NULL,";
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