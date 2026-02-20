<?php
class PlaceOrders
{
  private $order;
  private $orderRef;
 
  
  public function addOrder($id)
  {
       global $conn;
	   $this->order = unserialize($_SESSION[$id."orderline"]);
	   $this->orderRef = $id."order".date("YmdGis");
	   echo "INSERT INTO `orders` ( `orderref`, `tableid`, `orderlist`) VALUES ( '$this->orderRef', '$id', '$this->order')";
	   mysqli_query($conn, "INSERT INTO `orders` ( `orderref`, `tableid`, `orderlist`) VALUES ( '$this->orderRef', '$id', '$this->order')");
	   unset( $_SESSION[$id."orderline"] );
  }
  
}
?>