<?php
include_once("setup.php");
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

$myfiles=_WEB_ROOT_PATH.'basefiles/';
//修改您網站的檔案上傳資料夾目的地
$myfiles_url=_WEB_ROOT_URL.'basefiles/';
//修改您網站的檔案上傳資料夾的網址
switch($op){
    //當接受到$op為upload的時候開始上傳檔案
    case "upload":
    upload_files();
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
//檔案上傳的程式
function upload_files(){
    global $myfiles;
    if($_FILES['my_field']['error']=='UPLOAD_ERR_OK'){
        //上傳到伺服器成功開始搬移檔案
        if(move_uploaded_file($_FILES['my_field']['tmp_name'],$myfiles.$_FILES['my_field']['name'])){
            //移動成功
            //不過在實務上的作法，我們不會將檔案的原始名稱紀錄到伺服器中
            //因為LINUX作業系統中，可能就沒又辦法正確編碼WINDOWS傳上來的中文檔案
            //所以我們會將原始檔案（可能有中文的）紀錄在資料庫中，
            //而將實體檔案檔名重新編碼也紀錄在資料庫中，
            //這時候當使用者需要檔案時，便可以從資料庫中讀取原始檔名，呈現在網頁上，
            //而編碼過得檔名就放在網頁伺服器中，以提供實體連結。
        }else{
            //移動檔案失敗
        die("檔案移動失敗，請檢查目的資料夾是否開啟以及權限設定是否正確");
        }
    }else{
        die($_FILES['my_field']['error']);
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