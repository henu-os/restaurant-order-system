<?php
class Employee
{
  private $uName;
  private $pass;
 
  public function setCredentials($user, $pwd)
  {
      $this->uName = $user;
	  $this->pass = $pwd;
  }
 
  public function getPwd()
  {
      global $conn;
      $getPass = mysqli_query($conn, "SELECT pwd FROM `employee` WHERE `username` = '".$this->uName."'");
	  $result = mysqli_fetch_row($getPass) or trigger_error(mysqli_error($conn).$getPass);
	  return $result[0];
  }
  
  public function getRole($name)
  {
      global $conn;
      $getPass = mysqli_query($conn, "SELECT role FROM `employee` WHERE `username` = '".$name."'");
	  $result = mysqli_fetch_row($getPass) or trigger_error(mysqli_error($conn).$getPass);
	  return $result[0];
  }
}
?>