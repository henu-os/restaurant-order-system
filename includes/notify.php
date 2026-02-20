<?php
class Notify
{
  
  public function order($tabid)
  {
      global $conn;
	  mysqli_query($conn, "UPDATE `orders` SET `done`=1 WHERE `tableid` = '".$tabid."'");
  }
  
}
?>