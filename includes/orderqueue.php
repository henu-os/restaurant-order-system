<?php
class OrderQueue
{
  private $orderList;
  private $orderCount;
 
  public function __construct()
  {
      global $conn;
      $lt = 0;
	  $count = mysqli_query($conn, "SELECT * FROM `orders` WHERE `done` = 0");
	  mysqli_data_seek($count, 0);
	  while ($row = mysqli_fetch_assoc($count)) {
		  $this->orderList = $this->orderList.$row['orderref']."*".$row['tableid']."*".$row['orderlist']."*";
		  $lt++;
	  }
	  $this->orderCount = $lt;
  }
  
  public function orderLimit()
  {
	  return $this->orderCount;
  }
  
  public function OrderQueueList()
  {
	  return $this->orderList;
  }
  
}
?>