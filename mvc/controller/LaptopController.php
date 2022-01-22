<?php
require_once "model\LaptopModel.php";

class LaptopController {
   public $model;

   public function __construct()
   {
      $this->model = new LaptopModel();
   }

   public function invoke() {
      //TH1: view toàn bộ laptop
      if (!isset($_GET['id'])) {
         //lấy laptop list từ LaptopModel
         $laptop = $this->model->getLaptopList();
         //render view
         require_once "view\LaptopList.php";
      }
      //TH2: view 1 laptop theo id
      else {
         $laptop = $this->model->getLaptopDetail($_GET['id']);
         require_once "view\LaptopDetail.php";
      }
   }
}
?>