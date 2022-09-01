<?php

$data = array();
 
if( isset( $_GET['uploadfiles'] ) ){
    $error = false;
    $files = array();
 
    $uploaddir = './tmp/';
 
    if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
    foreach( $_FILES as $file ){
        $ras = explode(".", basename($file['name']));
        $ras = ".".$ras[1];
        $namefile = uniqid().$ras;
        if( move_uploaded_file( $file['tmp_name'], $uploaddir . $namefile ) ){
            $files[] = realpath( $uploaddir . $namefile );
        }
        else{
            $error = true;
        }
    }
 
    $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
 
    echo json_encode( $data );
}