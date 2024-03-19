<?php
namespace model\Order;

use model\App;
use model\Cart\Cart;;
use sys\store\AppData;

class Order extends App
{

    private $TableName = "tbl_order";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_order($customer_id, $prd_id,$unit_price, $quantity,$date, $status)
    {
        if(len($status<0)&& $unit_price<0):
            $this->Error = "Please fill in all product details";
            return false;
        endif;
        
        $data=[
            "customer_id"=>$customer_id,
            "date"=>$date,
            "status"=>$status
        ];

       
        if ($order_id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Order created successfully!!";

            
            $NewCart = new Cart;
            if($NewCart->__create_cart($order_id,$prd_id, $quantity,$unit_price)
            
            ){
                $this->Success .= $NewCart->Success;
            }
            $this->Error = $NewCart->Error;
            return $order_id;
        endif;
        $this->Error = "An error occurred while creating order";
        return false;

    }

    public function __get_order_list()
    {
        if(!$objOrder  = AppData::__get_rows($this->TableName)):
            $this->Error="product  not found";
            return false;
        endif;

     $list =[];

        while($row =$objOrder->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_order_info($id)
    {
        if(!$objOrder = AppData::__get_row($this->TableName, $id)):
            $this->Error="Order not found";
            return false;
        endif;
        return $this->__std_data_format($objOrder);
    }


    public function __update_order($id, $customer_id,$date,$status){

            if(!$id<=0):
                $this->Error = "Please fill in all order details";
                return false;
            endif;
            $data=[
                "id"=>$id,
                "customer_id"=>$customer_id,
                "date"=>$date,
                "status"=>$status
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "order updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating order";
            return false;
        }

    public function __total_orders(){
        $query= "SELECT COUNT(*) AS total_orders FROM tbl_order";

        $result= AppData::__execute($query);

        if($result){
            $row=$result->fetch_assoc()['total_orders'];
            
            return $row;

        }else{
            $this->Error="Error occured with orders";
        }

        
    }    



    public function __delete_order($id){

        if($id = AppData::__delete($this->TableName, $id)):
            $this->Success="order deleted";
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
            "status"=>$data->status
        ];
    }

    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`customer_id` INT(11) NOT NULL,";
            $query .= "`date` timestamp NOT NULL DEFAULT current_timestamp(),";
            $query .= "`status` VARCHAR(255) NOT NULL,";
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