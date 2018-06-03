<?php 
include '../config/config.php';
function registerUser($conn,$username){ 
	$sql="INSERT INTO user(username) VALUES('$username')";    
	if(mysqli_query($conn,$sql)) {     
		return true;    
	}     
	mysqli_close($conn); 
	return false; 
	
}
function getUser($conn, $username){
	$sql= "SELECT * FROM user WHERE username='$username'";
	$result= mysqli_query($conn,$sql);
	$user=array();
	while ($row= mysqli_fetch_array($result)) {
		$user_temp=array();
		//$user_temp['id_user']=$row['id_user'];
		$user_temp['username']=$row['username'];
		array_push($user,$user_temp);
	}
	mysqli_close($conn);  
	return $user;
}

function updateUser($conn,$id_user,$username){    
	$sql="UPDATE user SET id_user='$id_user', username='$username' WHERE id_user=$id_user";
	$result= mysqli_query($conn,$sql);  
	echo $result;
	return;
	if(mysqli_query($conn,$sql)) {     
		return true;   
	}    
	mysqli_close($conn);     
	return false; 
} 

function deleteUser($conn,$id_user){  
	$sql="DELETE FROM user WHERE id_user=$id_user";   
	if(mysqli_query($conn,$sql)) {      
		return true;  
	}    
	mysqli_close($conn);   
	return false; 
}

function loginUser($conn,$username){
	if(isset($_POST['username'])) {
		$user = mysql_real_escape_string($_POST['username']);
		$sql = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");

		$data = mysqli_fetch_array($sql);
		$username = $data['username'];
		if ($user==$username) {
			return true;
		}
		return false;
	}
}
function getHistory($conn,$keyword){
	$event = explode(" ", $keyword)[0];
	
	$history=array();
	switch ($event) {
		case 'daftar_matkul':
		$sql= "SELECT * FROM matkul ";
		$result= mysqli_query($conn,$sql);
		while ($row= mysqli_fetch_array($result)) {
			$history_temp=array();
			$history_temp['id_matkul']=$row['id_matkul'];
			$history_temp['matkul']=$row['matkul'];
			
			array_push($history,$history_temp);
		}
		mysqli_close($conn);  
		return $history;
		break;

		case 'jadwal_kuliah':
		$hari= explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM jadwal_kuliah WHERE hari='$hari'";
		$result= mysqli_query($conn,$sql);
		while ($row= mysqli_fetch_array($result)) {
			$history_temp=array();
			$history_temp['hari']=$row['hari'];
			$history_temp['tanggal']=$row['tanggal_jadkul'];
			$history_temp['matkul']=$row['id_matkul'];
			$history_temp['kelas']=$row['kelas'];
			
			array_push($history,$history_temp);
		}
		mysqli_close($conn);  
		return $history;
		break;

		case 'jadwal_ujian':
		$hari= explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM jadwal_ujian WHERE tanggal_jajan='$tanggal'";
		$result= mysqli_query($conn,$sql);
		while ($row= mysqli_fetch_array($result)) {
			$history_temp=array();
			// $history_temp['hari']=$row['hari'];
			$history_temp['tanggal']=$row['tanggal_jajan'];
			$history_temp['id_jadkul']=$row['id_jadkul'];
			$history_temp['kelas']=$row['kelas'];
			
			array_push($history,$history_temp);
		}
		mysqli_close($conn);  
		return $history;
		break;

		case 'tugas':
		$hari= explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM tugas WHERE tanggal_tugas='$tanggal'";
		$result= mysqli_query($conn,$sql);
		while ($row= mysqli_fetch_array($result)) {
			$history_temp=array();
			// $history_temp['hari']=$row['hari'];
			$history_temp['id_matkul']=$row['id_matkul'];
			$history_temp['tanggal_tugas']=$row['tanggal_tugas'];
			$history_temp['tugas']=$row['tugas'];
			
			array_push($history,$history_temp);
		}
		mysqli_close($conn);  
		return $history;
		break;

		case 'pj':
		$sql= "SELECT * FROM pj ";
		$result= mysqli_query($conn,$sql);
		while ($row= mysqli_fetch_array($result)) {
			$history_temp=array();
			$history_temp['nama_pj']=$row['nama_pj'];
			$history_temp['id_matkul']=$row['id_matkul'];
			array_push($history,$history_temp);
		}
		mysqli_close($conn);  
		return $history;
		break;
		

		default:
			# code...
		break;
	}
	
}

function historyUser($conn, $keyword){
	$event = explode(" ", $keyword)[0];
	
	switch ($event) {
		case 'daftar_matkul':
		$sql= "SELECT * FROM matkul";
		if(mysqli_query($conn,$sql)) { 
			return true;   
		}    
		mysqli_close($conn);     
		return false;
		break;

		case 'jadwal_kuliah':
		$hari = explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM jadwal_kuliah WHERE hari='$hari'";
		if(mysqli_query($conn,$sql)) { 
			return true;   
		}    
		mysqli_close($conn);     
		return false;
		break;

		case 'jadwal_ujian':
		$hari= explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM jadwal_ujian WHERE tanggal_jajan='$tanggal'";
		if(mysqli_query($conn,$sql)) { 
			return true;   
		}    
		mysqli_close($conn);     
		return false;
		break;

		case 'tugas':
		$hari= explode(" ", $keyword)[2];
		$tanggal = explode(" ", $keyword)[2];
		$sql= "SELECT * FROM tugas WHERE tanggal_tugas='$tanggal'";
		if(mysqli_query($conn,$sql)) { 
			return true;   
		}    
		mysqli_close($conn);     
		return false;
		break;

		case 'pj':
		$sql= "SELECT * FROM pj";
		if(mysqli_query($conn,$sql)) { 
			return true;   
		}    
		mysqli_close($conn);     
		return false;
		break;
		default:
			# code...
		break;
	}

	// $history = $keyword;
	//$keyword = 'jadwal hari rabu';
	// $event = explode(" ", $keyword)[0];
	// $hari= explode(" ", $keyword)[2];
	
	// 	//$splitted = each(array)explode(' ', $user);
	// switch ($event){
	// 	case 'jadwal_kuliah':
	// 	// switch ($hari) {
	// 	// 	case 'senin':
	// 	$keyword = mysql_real_escape_string($_POST['keyword']);
	// 	$sql= "SELECT * from jadwal_kuliah where hari = '$hari'";
	// 	$result= mysqli_query($conn, $sql);

	// 	if($keyword == $hari) {  
	// 		$jadkul=array();
	// 		while ($row= mysqli_fetch_array($sql) ){
	// 			$jadkul_temp=array();
	// 			$jadkul_temp['hari']=$row['hari'];
	// 			array_push($jadkul,$jadkul_temp);
	// 		}
	// 		mysqli_close($conn);  
	// 		return $jadkul;    
	// 		return true;   
	// 	}    
	// 	mysqli_close($conn);     
	// 	return false; 
			//echo $sql;
			//return;
		// $jadkul=array();
		// while ($row= mysqli_fetch_assoc($result)) {
		// 	$jadkul_temp=array();
		// 	$jadkul_temp['keyword']=$row['keyword'];
		// 	array_push($jadkul,$jadkul_temp);
		// }
		// mysqli_close($conn);  
		// return $jadkul; 

		// $jadkul=array();
		// while ($row= mysqli_fetch_array($result)) {
		// 	$jadkul_temp=array();
		// 	$jadkul_temp['keyword']=$row['keyword'];
		// 	array_push($jadkul,$jadkul_temp);
		// }
		// mysqli_close($conn);  
		// return $jadkul;
		// break;
}


