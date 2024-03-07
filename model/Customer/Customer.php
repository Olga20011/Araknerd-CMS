<?php
namespace model\Customer;

use model\App;
use sys\store\AppData;

class Customer extends App
{

    private $TableName = "tbl_customer";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_customer($name, $phone_number, $email, $location){
        if(len($name)&& len($email) && len($location) && len($phone_number)):
            $this->Error = "Please fill in all customer details";
            return false;
        endif;

        $phone = format_phone_number($phone_number);
        if(!$phone):
            $this->Error ="Phone number should be 10 digits";
            return false;
        endif;
        
        $data=[
            "name"=>$name,
            "phone_number"=>$phone_number,
            "email"=>$email,
            "location"=>$location,
        ];
        
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Customer created successfully!!";
            
            return $id;
        endif;
        $this->Error = "An error occurred while creating customer";
        return false;

      }

    public function __get_customer_list()
    {
        if(!$objCustomer  = AppData::__get_rows($this->TableName)):
            $this->Error="Customer not found";
            return false;
        endif;

     $list =[];

        while($row =$objCustomer->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }


    public function __get_customer_info($id)
    {
        if(!$objCustomer = AppData::__get_row($this->TableName, $id)):
            $this->Error="Customer not found";
            return false;
        endif;
        return $this->__std_data_format($objCustomer);
    }


    public function __update_customer($id ,$name, $email, $phone_number, $location){

            if($id<=0 || len($name<0)):
                $this->Error = "Please fill in all customer details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "name"=>$name,
                "email"=>$email,
                "phone_number"=>$phone_number,
                "location"=>$location
                
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "customer updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating customer";
            return false;
        }

        public function __delete_customer($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="customer deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }
    

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            
            "id"=>$data->id,
            "name"=>$data->name,
            "email"=>$data->email,
            "phone_number"=>$data->phone_number,
            "location"=>$data->location 
        ];
    }

    private function __initialize()
    
   
    { 

        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`name` VARCHAR(255) NOT NULL,";
            $query .= "`email` VARCHAR(255) NOT NULL,";
            $query .= "`phone_number` VARCHAR(255) NOT NULL,";
            $query .= "`location` VARCHAR(255) NOT NULL,";
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