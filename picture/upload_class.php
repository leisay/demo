<?php
include_once("setup.php");
include('class/class.upload/class.upload.php');
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

$myfiles=_WEB_ROOT_PATH.'basefiles/';
//修改您網站的檔案上傳資料夾目的地
$myfiles_url=_WEB_ROOT_URL.'basefiles/';
//修改您網站的檔案上傳資料夾的網址
switch($op){
    //當接受到$op為upload的時候開始上傳檔案
    case "upload":
    upload_files_by_class();
    header("location:{$_SERVER['PHP_SELF']}");
    break;
    //預設出現檔案上傳的表單
    default:
    $content=bootstrap(upload_form());
}
//------------------輸出區----------------------//
echo $content;
//----------------------函數區-------------------------//
function upload_form(){
    global $myfiles;
    $main="
    <fieldset>
        <legend>檔案上傳的表單</legend>
        <p>請選擇檔案之後，按下上傳按鈕</p>
        <form name='form1' enctype='multipart/form-data' method='post' action='{$_SERVER['PHP_SELF']}'=''>
            <p><input size='32' name='my_field' value='' type='file'></p>
            <p class='button'><input name='op' value='upload' type='hidden'>
            <input name='Submit' value='上傳' type='submit'></p>
        ".dirToUrl($myfiles)."
        </form>
    </fieldset>
    ";
    return $main;
}

function upload_files_by_class(){
    global $myfiles;
    $handle = new Upload($_FILES['my_field'],"zh_TW");
    //取消上傳時間限制
    set_time_limit(0);
    //設置上傳大小
    ini_set('memory_limit', '80M');

    $handle->allowed=array(
    'image/*',
    'application/mspowerpoint',
    'application/msword',
    'application/pdf',
    'application/powerpoint',
    'application/vnd.ms-excel',
    'application/vnd.ms-office',
    'application/vnd.ms-word',
    'application/zip'
    );
    if ($handle->uploaded){
        $handle->file_safe_name = false;
        if($handle->file_is_image){
            $handle->file_overwrite = true;
            $handle->image_resize         = true;
            $handle->image_ratio_y         = true;
            $handle->image_x              = 300;
            $handle->image_text = 'aandd_upload';
            $handle->image_text_position = 'BR';
            $handle->image_text_padding = 5;
            $handle->image_border = '3px';
            $handle->image_border_color = '#ffffff';
        }
        $handle->process($myfiles);
        if (!$handle->processed) {
            die_content($handle->error);
        }
        $handle-> Clean();
    }else{
        die_content($handle->error);
    }
}

//將資料夾內的檔案轉成連結
function dirToUrl($dir=""){
    global $myfiles_url;
    $main="";
    $result=scandir($dir);
    foreach($result as $v){
        if($v == '.' or $v == '..') continue;
        $main.="<div><a href='{$myfiles_url}{$v}'>{$v}</a></div>";
    }
    return $main;
}