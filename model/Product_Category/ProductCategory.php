<?php
namespace model\Product_Category;

use model\App;
use sys\store\AppData;

class ProductCategory extends App
{
    private $TableName = "tbl_category";

    public function __construct()
    {
        $this->__initialize();
    }

    public function __create_category($category_name, $category_description)
    {
        if(len($category_name)&& len($category_description)):
            $this->Error = "Please fill in all category details";
            return false;
        endif;
        
        $data=[
            "category_name"=>$category_name,
            "category_description"=>$category_description,
            
          
        ];
        if ($id = AppData::__create($this->TableName, $data)) :
            $this->Success = "Category created successfully!!";

            return $id;
        endif;
        $this->Error = "An error occurred while creating category";
        return false;

    }

    public function __get_category_list()
    {
        // $query = "SELECT * FROM `$this->TableName`";
        // $result = AppData::__execute($query);
        // $list = [];
        // while ($row = $result->fetch_assoc()) {
        //     $list[] = $this->__std_data_format($row);
        // }
        // return $list;


        if(!$objCategory = AppData::__get_rows($this->TableName)):
            $this->Error="category not found";
            return false;
        endif;

     $list =[];

        while($row =$objCategory->fetch_assoc()){
            $list [] =$this->__std_data_format($row);
        }
        return $list;
    }

    // public function __newest_prd(){
    //     $query= "SELECT * FROM tbl_products
    //     ORDER BY created_at DESC
    //     LIMIT 3;
    //     ";
    //     $result = AppData::__execute($query);
    //     $list = [];
    //     while ($row = $result->fetch_assoc()){
    //         $list[] = $this->__std_data_format($row);
    //     }

    //     return $list;
    // }


    public function __get_category_info($id)
    {
        if(!$objCategory = AppData::__get_row($this->TableName, $id)):
            $this->Error="Category not found";
            return false;
        endif;
        return $this->__std_data_format($objCategory);
    }


    public function __update_category($id,$category_name,$category_description ){

            if($id<0 || len($category_name)):
                $this->Error = "Please fill in all category details";
                return false;
            endif;

            $data=[
                "id"=>$id,
                "category_name"=>$category_name,
                "category_description"=>$category_description,
                
                
            ];
            if ($id = AppData::__update($this->TableName, $data, $id)) :
                $this->Success = "category updated successfully!!";
                
                return $id;
            endif;
            $this->Error = "An error occurred while updating category";
            return false;
        }

        public function __delete_category($id){

            if($id = AppData::__delete($this->TableName, $id)):
                $this->Success="category deleted";
                return true;
            endif;
            $this->Error ="Error";

            return false;
    
        }

    private function __std_data_format($data){
        $data = (object) $data;
        return [
            "id"=>$data->id,
            "category_name"=>$data->category_name,
            "category_description"=>$data->category_description,
            
              
        ];
    }

    private function __initialize()
    {
        if (!AppData::__table_exists($this->TableName)) {
            $query = "CREATE TABLE `$this->TableName` (";
            $query .= " `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,";
            $query .= " `category_name` VARCHAR(255) NOT NULL,";
            $query .= " `category_description` VARCHAR(255) NOT NULL,";
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