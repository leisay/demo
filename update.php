<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('content-type:text/html;charset = utf-8') ;

$upload_dir = 'c://test/' ;

if($_FILES['upfile']['error'] === UPLOAD_ERR_OK)
{
    if(move_uploaded_file($_FILES['upfile']['tmp_name'],$upload_dir.$_FILES['upfile']['name']))
    {
        echo '</BR>File:' .$_FILES['upfile']['name'];
        echo '</BR>File Type:' .$_FILES['upfile']['type'];
        echo '</BR>File Size:' . $_FILES['upfile']['size'];
        echo '</BR> File Name:' .$_FILES['upfile']['tmp_name']; 
        
        
    }
    
    
}
else
{
    echo 'Fail';
    
}