<?php
class Category
{
  private $catList;
  private $catCount;
 
  public function __construct()
  {
      global $conn;
      $lt = 0;
	  $count = mysqli_query($conn, "SELECT * FROM `category` WHERE 1");
	  mysqli_data_seek($count, 0);
	  while ($row = mysqli_fetch_assoc($count)) {
		  $this->catList = $this->catList.$row['catId']."-".$row['catDesc'].";";
		  $lt++;
	  }
	  $this->catCount = $lt;
  }
  
  public function catLimit()
  {
	  return $this->catCount;
  }
  
  public function categoryList()
  {
	  return $this->catList;
  }
  
}
?>