<?php
class Table
{
  private $waiterId;
  private $tabList;
 
  public function __construct()
  {
      global $conn;
      $id = mysqli_query($conn, "SELECT id FROM `employee` WHERE `username` = '".$_SESSION['uName']."'");
	  $result = mysqli_fetch_row($id) or trigger_error(mysqli_error($conn).$id);
	  $this->waiterId = $result[0];
  }
  
  public function tabCount()
  {
      global $conn;
      $lt = 0;
	  $count = mysqli_query($conn, "SELECT * FROM `floorplan` WHERE `waiterid` = '".$this->waiterId."'");
	  mysqli_data_seek($count, 0);
	  while ($row = mysqli_fetch_assoc($count)) {
		  $this->tabList = $this->tabList.$row['tableid']."-".$row['status'].";";
		  $lt++;
	  }
	  return $lt;
  }
 
  public function tabStatus()
  {
	  return $this->tabList;
  }
  
    public function totCount()
  {
      global $conn;
      $lt = 0;
	  $count = mysqli_query($conn, "SELECT * FROM `floorplan` WHERE 1");
	  mysqli_data_seek($count, 0);
	  while ($row = mysqli_fetch_assoc($count)) {
		  $this->tabList = $this->tabList.$row['tableid']."-".$row['status'].";";
		  $lt++;
	  }
	  return $lt;
  }
 
  public function totStatus()
  {
	  return $this->tabList;
  }
  
  public function updateStatus($id, $stat)
  {
      global $conn;
	  mysqli_query($conn, "UPDATE `floorplan` SET `status`='$stat' WHERE `tableid` = '$id'");
  }
  
}
?>