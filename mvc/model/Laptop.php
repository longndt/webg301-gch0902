<?php 
class Laptop {
   //attributes
   public $name;
   public $brand;
   public $price;
   public $color;
   public $year;
   public $image;

   //constructor
   public function __construct ($name, $brand, $price, $color, $year, $image) {
      $this->name = $name;
      $this->brand = $brand;
      $this->price = $price;
      $this->color = $color;
      $this->year = $year;
      $this->image = $image;
   }
}
?>