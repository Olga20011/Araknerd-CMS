<?php
namespace model\Cart;

use model\App;
use model\CartItem\CartItem;
use sys\store\AppData;

class Cart extends App
{

    private $TableName = "tbl_cart";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_cart($cart_id,$customer_id, $prd_id,$unit_price, $quantity,$date)
    {
        if($customer_id<0 && $unit_price<0):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "customer_id"=>$customer_id,
            "date"=>$date,
            
        ];

       
        if ($order_id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Cart created successfully!!";

            
            $NewCart = new CartItem;
            if($NewCart->__create_cartItem($cart_id, $customer_id,$prd_id, $quantity,$unit_price)
            
            ){
                $this->Success .= $NewCart->Success;
            }
            $this->Error = $NewCart->Error;
            return $order_id;
        endif;
        $this->Error = "An error occurred while creating cart";
        return false;

    }

    public function __get_cart_list()
    {
        if(!$objOrder  = AppData::__get_rows($this->TableName)):
            $this->Error="Cart not found";
            return false;
        endif;

     $list =[];

        while($row =$objOrder->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_cart_info($id)
    {
        if(!$objOrder = AppData::__get_row($this->TableName, $id)):
            $this->Error="Cart not found";
            return false;
        endif;
        return $this->__std_data_format($objOrder);
    }


    public function __cart_details($order_id){
        $query = " SELECT c.* FROM tbl_cart  c
        JOIN tbl_order o ON c.order_id = o.id WHERE o.id = '$order_id' ";

        $result = AppData::__execute($query);

        if($result){
            $row = $result->fetch_assoc();

            return $row;
        }else{
            $this->Error= "Catch doesn't exist";
        }
    }

    public function __update_cart($id,$date,$customer_id){

            if(!$id<=0):
                $this->Error = "Please fill in all order details";
                return false;
            endif;
            $data=[
                "id"=>$id,
                "date"=>$date,
                "customer_id"=>$customer_id
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "cart updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating order";
            return false;
        }

    public function __total_carts(){
        $query= "SELECT COUNT(*) AS total_orders FROM tbl_order";

        $result= AppData::__execute($query);

        if($result){
            $row=$result->fetch_assoc()['total_orders'];
            
            return $row;

        }else{
            $this->Error="Error occured with orders";
        }
    }    

    public function __delete_cart($id){

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
            "date"=>$data->date,
           
        ];
    }

    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`customer_id` INT(11) NOT NULL,";
            $query .= "`date` timestamp NOT NULL DEFAULT current_timestamp(),";
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