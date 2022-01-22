<?php 
require_once "Laptop.php";

class LaptopModel {

   public $laptopList;

   public function __construct()
   {
       // khởi tạo array chứa danh sách laptop
       $this->laptopList = array(
         //tạo array element (Laptop object)
         new Laptop("Dell XPS 13", "Dell", 1234.5, "Silver", 2021, 
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRlmw2d0iPXXbJrk9_7wtBave_Oi9wsAv1v2A&usqp=CAU"),
         new Laptop("Macbook Air M1", "Apple", 1345.6, "White", 2020,
            "https://kenh14cdn.com/thumb_w/660/203336854389633024/2020/11/22/photo-1-16060578422571358255916.jpg"),
         new Laptop("LG Gram 15", "LG", 1111.3, "Black", 2022,
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUSDyHGl9LdTsHmjzybRJC_HH8-Z-xbygudw&usqp=CAU"),
         );
         return $this->laptopList;
   }
   
   public function getLaptopList() {
      return $this->laptopList;
   }

   public function getLaptopDetail($id) {
      return $this->laptopList[$id];
   }  
}
?>