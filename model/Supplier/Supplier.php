<?php
namespace model\Supplier;

use model\App;
use sys\store\AppData;

class Supplier extends App
{

    private $TableName = "tbl_supplier";

    public function __construct()
    {
        parent::__construct();
        $this->__initialize();
    }

    public function __create_supplier($supplier_name, $phone_number, $email, $location){
        if(len($supplier_name)&& len($email) && len($location) && len($phone_number)):
            $this->Error = "Please fill in all product details";
            return false;
        endif;

        $phone = format_phone_number($phone_number);
        if(!$phone):
            $this->Error ="Phone number should be 10 digits";
            return false;
        endif;
        
        $data=[
            "supplier_name"=>$supplier_name,
            "phone_number"=>$phone_number,
            "email"=>$email,
            "location"=>$location,
        ];
        
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Supplier created successfully!!";
            
            return $id;
        endif;
        $this->Error = "An error occurred while creating supplier";
        return false;

      }

    public function __get_supplier_list()
    {
        if(!$objSupplier = AppData::__get_rows($this->TableName)):
            $this->Error="supplier not found";
            return false;
        endif;

     $list =[];

        while($row =$objSupplier->fetch_assoc() ){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }

    public function __get_supplier_info($id)
    {
        if(!$objSupplier = AppData::__get_row($this->TableName, $id)):
            $this->Error="Supplier not found";
            return false;
        endif;
        return $this->__std_data_format($objSupplier);
    }

    public function __total_suppliers(){
        $query= "SELECT COUNT(*) AS total_suppliers FROM tbl_supplier";

        $result= AppData::__execute($query);

        if($result){
            $row= $result->fetch_assoc()['total_suppliers'];
            
            return $row;

        }else{
            $this->Error="Error occured";

        }
    }

    public function __update_supplier($id,$supplier_name,$phone_number,$email,$location){

            if($id<=0 || len($supplier_name)):
                $this->Error = "Please fill in all supplier details";
                return false;
            endif;

            $data=[
                "supplier_name"=>$supplier_name,
                "phone_number"=>$phone_number,
                "email"=>$email,
                "location"=>$location,
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "supplier updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating supplier";
            return false;
        }

    public function __delete_supplier($id){

        if($id = AppData::__delete($this->TableName, $id)):
            $this->Success="supplierdeleted";
            return true;
        endif;
            $this->Error ="Error";

            return false;
        
            }
    
    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "supplier_name"=>$data->supplier_name,
            "phone_number"=>$data->phone_number,
            "email"=>$data->email,
            "location"=>$data->location,
              
        ];
    }
    private function __initialize()
    { 
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= "`supplier_name` VARCHAR(255) NOT NULL,";
            $query .= "`phone_number` VARCHAR(255) NOT NULL,";
            $query .= "`email` VARCHAR(255) NOT NULL,";
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