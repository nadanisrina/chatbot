<?php
//getting the dboperation class
include '../model/model.php';
include '../config/config.php';
//function validating all the paramters are available
//we will pass the required parameters to this function 
function isTheseParametersAvailable($params){
	//assuming all parameters are available
	$available = true; 
	$missingparams = ""; 
	foreach($params as $param){
		if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
			$available = false; 
			$missingparams = $missingparams . ", " . $param;  
		}
	}
	 //if parameters are missing 
	if(!$available){
		$response = array(); 
		$response['error'] = true; 
		$response['message'] = 'Parameters ' . substr($missingparams, 1,
			strlen($missingparams)) . ' missing';
		//displaying error
		echo json_encode($response);
		//stopping further execution
		die();
	}
}
//an array to display response
$response = array();
//$_GET['key']
if(isset($_GET['apicall'])){
	switch($_GET['apicall']){
		case 'register_user':
		isTheseParametersAvailable(array('username'));
		$result=registerUser($conn,$_POST['username']);
		if($result){
			$response['error']=false;
			$response['message'] = 'user berhasil ditambahkan';
			$response['username'] = getUser($conn,$_POST['username']);
		}else{
			$response['error'] = true; 
			$response['message'] = 'Silahkan masukkan username lain';
		}
		break;
		case 'get_user':
		$response['error'] = false;
		$response['message'] = 'Request successfully completed';
		$response['username'] = getUser($conn,$username);
		break;
		case 'update_user':
		isTheseParametersAvailable(array('id_user','username'));
		$result=updateUser($conn,$_POST['id_user'],$_POST['username']);
		if($result){
			$response['error']=false;
			$response['message'] = 'Username berhasil di perbaharui';
			$response['username'] = getUser($conn,$_POST['username']);
		}else{
			$response['error'] = true; 
			$response['message'] = 'Some error';
		}
		break;
		case 'delete_user':
		if(isset($_GET['id_user'])){
			if(deleteUser($conn,$_GET['id_user'])){
				$response['error']=false;
				$response['message'] = 'Delete user berhasil';
				$response['user'] = getUser($conn,$_POST['username']);
			}else{
				$response['error'] = true; 
				$response['message'] = 'Some error';
			}
		}else{
			$response['error'] = true; 
			$response['message'] = 'Nothing to delete'; 
		}
		break;

		case 'login_user':
		isTheseParametersAvailable(array('username'));
		$result=loginUser($conn,$_POST['username']);
		if($result){
			$response['error']=false;
			$response['message'] ='Anda berhasil login';
			$response['username'] = getUser($conn,$_POST['username']);
		}else{
			$response['error'] = true; 
			$response['message'] = 'Some error';
		}
		break;
		case 'get_history':
		isTheseParametersAvailable(array('keyword'));
		$result=historyUser($conn,$_POST['keyword']);
		if($result){
			$response['error']=false;
			$response['message'] ='Anda berhasil login';
			$response['history'] = getHistory($conn,$_POST['keyword']);
		}else{
			$response['error'] = true; 
			$response['message'] = 'Some error';
		}
		break;
		
	}
}
else{
	$response['error'] = true; 
	$response['message'] = 'Invalid API Call';
}
echo json_encode($response);
