<?php



	
	function getAttempts($userid) {
        global $conn;
		$getPass = mysqli_query($conn, "SELECT attempts FROM `users` WHERE `uName` = '".$userid."'");
		$result = mysqli_fetch_row($getPass) or trigger_error(mysqli_error($conn).$getPass);
		return $result[0];
	}
	
	function getEmail($userid) {
        global $conn;
		$getPass = mysqli_query($conn, "SELECT email FROM `users` WHERE `uName` = '".$userid."'");
		$result = mysqli_fetch_row($getPass) or trigger_error(mysqli_error($conn).$getPass);
		return $result[0];
	}
	
	function updateAttempt($userid, $attempt) {
        global $conn;
		mysqli_query($conn, "UPDATE `users` SET `attempts`='$attempt' WHERE `uName` = '".$userid."'");
	}
	
	function changePass($userid, $pwd) {
        global $conn;
		mysqli_query($conn, "UPDATE `users` SET `pass`='$pwd' WHERE `uName` = '".$userid."'");
	}
	
	function createUser($user, $pwd, $mail) {
        global $conn;
		mysqli_query($conn, "INSERT INTO `users` ( `uName`, `pass`, `email`) VALUES ( '$user', '$pwd', '$mail')");
	}
	
	function getDailyUsage($date, $device) {
        global $conn;
		$graph = '';
		$getVal = mysqli_query($conn, "SELECT Start_Time, Value FROM `sprinkler_usage` WHERE `Date` = '".$date."' AND `Zone`  = ".$device);
		mysqli_data_seek($getVal, 0);
		while ($row = mysqli_fetch_assoc($getVal)) {
		  $graph = $graph.$row['Start_Time']."-".$row['Value'].";";
		}
		return $graph;
	}
	
	function getMonthlyUsage($month, $year, $device) {
        global $conn;
		$graph = '';
		$getVal = mysqli_query($conn, "SELECT DAY(date) AS day, Value FROM `sprinkler_usage` WHERE MONTH(date) = ".$month." AND YEAR(date) = ".$year." AND `Zone`  = ".$device);
		mysqli_data_seek($getVal, 0);
		while ($row = mysqli_fetch_assoc($getVal)) {
		  $graph = $graph.$row['day']."-".$row['Value'].";";
		}
		return $graph;
	}
	
	function getStatusSprinkler() {
        global $conn;
		$result = array();
		$getStat = mysqli_query($conn, "SELECT Status FROM `sprinkler_controls`");
		mysqli_data_seek($getStat, 0);
		while ($row = mysqli_fetch_assoc($getStat)) {
		  array_push($result, $row['Status']);
		}
		return $result;
	}
	
	function getPresetSprinklerVal() {
        global $conn;
		$result = array();
		$count = 0;
		$getStat = mysqli_query($conn, "SELECT id, type, day, month, fromtime, totime, device FROM `sprinkler_preset`");
		mysqli_data_seek($getStat, 0);
		while ($row = mysqli_fetch_assoc($getStat)) {
		  array_push($result, $row['id']);
		  array_push($result, $row['type']);
		  array_push($result, $row['day']);
		  array_push($result, $row['month']);
		  array_push($result, $row['fromtime']);
		  array_push($result, $row['totime']);
		  array_push($result, $row['device']);
		  $count++;
		}
		array_push($result, $count);
		return $result;
	}
	
	function getPresetSprinkler() {
        global $conn;
		$result = array();
		$getStat = mysqli_query($conn, "SELECT PreFrom, PreTo FROM `sprinkler_controls`");
		mysqli_data_seek($getStat, 0);
		while ($row = mysqli_fetch_assoc($getStat)) {
		  array_push($result, $row['PreFrom']);
		  array_push($result, $row['PreTo']);
		}
		return $result;
	}
	
	function getStatusSecurity() {
        global $conn;
		$getStat = mysqli_query($conn, "SELECT Status FROM `alarm_controls`");
		$result = mysqli_fetch_row($getStat) or trigger_error(mysqli_error($conn).$getStat);
		return $result;
	}
	
	function getStatusThermostat() {
        global $conn;
		$result = array();
		$fix = array();
		$getStat = mysqli_query($conn, "SELECT Status, Temp, Fixed FROM `thermostat_controls`");
		mysqli_data_seek($getStat, 0);
		while ($row = mysqli_fetch_assoc($getStat)) {
		  array_push($result, $row['Status']);
		  array_push($result, $row['Temp']);
		  array_push($fix, $row['Fixed']);
		}
		$result = array_merge($result, $fix);
		return $result;
	}
	
	function getPresetThermostat() {
        global $conn;
		$result = array();
		$fix = array();
		$getStat = mysqli_query($conn, "SELECT PreFrom, PreTo, PreTemp, PreFixed FROM `thermostat_controls`");
		mysqli_data_seek($getStat, 0);
		while ($row = mysqli_fetch_assoc($getStat)) {
		  array_push($result, $row['PreFrom']);
		  array_push($result, $row['PreTo']);
		  array_push($result, $row['PreTemp']);
		  array_push($fix, $row['PreFixed']);
		}
		$result = array_merge($result, $fix);
		return $result;
	}
	
	function updateTemp($temperature, $status, $fix, $floor) {
        global $conn;
		mysqli_query($conn, "UPDATE `thermostat_controls` SET `Temp` = $temperature, `Status` = $status, `Fixed` = $fix WHERE `Floor` = $floor");
	}
	
	function updatePresetTemp($from, $to, $temperature, $fix, $floor) {
        global $conn;
		mysqli_query($conn, "UPDATE `thermostat_controls` SET `PreFrom` = '$from', `PreTo` = '$to', `PreTemp` = $temperature, `PreFixed` = $fix WHERE `Floor` = $floor");
	}
	
	function updateSecurity($status) {
        global $conn;
		mysqli_query($conn, "UPDATE `alarm_controls` SET `Status` = $status WHERE 1");
	}
	
	function updateSprinklers($status, $zone) {
        global $conn;
		mysqli_query($conn, "UPDATE `sprinkler_controls` SET `Status` = $status WHERE `Zone` = $zone");
	}
	
	/*function updatePresetSprinklers($from, $to, $zone) {
        global $conn;
		mysqli_query($conn, "UPDATE `sprinkler_controls` SET `PreFrom` = '$from', `PreTo` = '$to' WHERE `Zone` = $zone");
	}*/
	
	function setPresetSpringlerTime($type, $from, $to, $zone) {
        global $conn;
		mysqli_query($conn, "INSERT INTO `sprinkler_preset` ( `type`, `fromtime`, `totime`, `device`) VALUES ( '$type', '$from', '$to', '$zone')");
	}
	
	function setPresetSpringlerWeek($type, $week, $from, $to, $zone) {
        global $conn;
		mysqli_query($conn, "INSERT INTO `sprinkler_preset` ( `type`, `day`, `fromtime`, `totime`, `device`) VALUES ( '$type', '$week', '$from', '$to', '$zone')");
	}
	
	function setPresetSpringlerMonth($type, $mon, $from, $to, $zone) {
        global $conn;
		mysqli_query($conn, "INSERT INTO `sprinkler_preset` ( `type`, `month`, `fromtime`, `totime`, `device`) VALUES ( '$type', '$mon', '$from', '$to', '$zone')");
	}
	
	function updatePresetSpringler($id, $type, $week, $mon, $from, $to, $zone) {
        global $conn;
		mysqli_query($conn, "UPDATE `sprinkler_preset` SET `type`='$type',`day`='$week',`month`='$mon',`fromtime`='$from',`totime`='$to',`device`='$zone' WHERE `id`=$id");
	}
	
	function deletePresetSpringler($id) {
        global $conn;
		mysqli_query($conn, "DELETE FROM `sprinkler_preset` WHERE `id` = $id");
	}
?>