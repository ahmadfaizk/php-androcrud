<?php

include '../model/mahasiswa.php';
include '../config/config.php';

function isTheseParametersAvailable($params){
    $available = true;
    $missingparams = "";
    $errors = array();
    foreach($params as $param){
        if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
            $available = false;
            $missingparams = $missingparams . ", " . $param;
            $errors[$param] = 'The ' . $param . ' field is required.';
        }
    }
    if(!isset($_FILES['foto'])) {
        $available = false;
        $errors['foto'] = 'The foto field is required.';
    } else {
        $image_ext = array('jpeg', 'jpg', 'png');
        $file_ext = strtolower(end(explode('.',$_FILES['foto']['name'])));
        if (in_array($file_ext, $image_ext) == false) {
            $available = false;
            $errors['foto'] = 'The foto must be a file of type: jpeg, jpg, or png';
        }
    }
    if(!$available){
        $response = array();
        $response['error'] = true;
        $response['message'] = 'Error';
        $response['errors'] = $errors;
        echo json_encode($response);
        die();
    }
}

function savePhoto() {
    $file_name = $_FILES['foto']['name'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    move_uploaded_file($file_tmp, '../images/'.$file_name);
}

$response = array();

if(isset($_GET['apicall'])){
    switch($_GET['apicall']){
        case 'create_mahasiswa':
            isTheseParametersAvailable(array('nama','alamat'));
            savePhoto();
            $result=createMahasiswa($conn, $_POST['nama'], $_POST['alamat'], $_FILES['foto']['name']);
            if($result){
                $response['error']=false;
                $response['message'] = 'Mahasiswa berhasil ditambahkan';
                $response['mahasiswa'] = getMahasiswa($conn);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error';
            }
            break;
        case 'update_mahasiswa':
            isTheseParametersAvailable(array('id','nama','alamat'));
            savePhoto();
            $result=updateMahasiswa($conn,$_POST['id'], $_POST['nama'], $_POST['alamat'], $_FILES['foto']['name']);
            if($result){
                $response['error']=false;
                $response['message'] = 'Mahasiswa berhasil ditambahkan';
                $response['mahasiswa'] = getMahasiswa($conn);
            }else{
                $response['error'] = true;
                $response['message'] = 'Some error';
            }
            break;
        case 'get_mahasiswa':
            $response['error'] = false;
            $response['message'] = 'Request successfully completed';
            $response['mahasiswa'] = getMahasiswa($conn);
            break;
        case 'delete_mahasiswa':
            if(isset($_GET['id'])){
                if(deleteMahasiswa($conn,$_GET['id'])){
                    $response['error']=false;
                    $response['message'] = 'Delete mahasiswa berhasil';
                    $response['mahasiswa'] = getMahasiswa($conn);
                }else{
                    $response['error'] = true;
                    $response['message'] = 'Some error';
                }
            }else{
                $response['error'] = true;
                $response['message'] = 'Nothing to delete';
            }
            break;
    }
}
else{
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}
echo json_encode($response);
