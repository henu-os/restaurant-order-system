<?php
class Item
{
  private $itemInList;
  private $itemCount;
 
  public function itemList($cat)
  {
      global $conn;
      $lt = 0;
	  $count = mysqli_query($conn, "SELECT `desc`, `price` FROM `item` WHERE `catid` = $cat");
	  mysqli_data_seek($count, 0);
	  while ($row = mysqli_fetch_assoc($count)) {
		  $this->itemInList = $this->itemInList.$row['desc']."-".$row['price'].";";
		  $lt++;
	  }
	  $this->itemCount = $lt;
  }
  
   public function itemLimit()
  {
	  return $this->itemCount;
  }
  
  public function getItemList()
  {
	  return $this->itemInList;
  }
  
}
?>