<?php
include_once("../../setup.php");
include_once "../../class/class.upload/class.upload.php";
$myfiles=_WEB_ROOT_PATH.'basefiles/';
//修改您網站的檔案上傳資料夾目的地
$myfiles_url=_WEB_ROOT_URL.'basefiles/';
//修改您網站的檔案上傳資料夾的網址
$mythumbfiles=_WEB_ROOT_PATH.'thumbfiles/';
//修改您網站的檔案上傳資料夾目的地
$mythumbfiles_url=_WEB_ROOT_URL.'thumbfiles/';
//修改您網站的檔案上傳資料夾的網址



$map_sn = $_POST['map_sn'];


if (!empty($_FILES)) {
	if(file_upload("img",$map_sn)){
        echo "true";
    }else{
        echo "false";
    }
}

function file_upload($class="",$map_sn="",$fileFormName='Filedata'){
	global $link,$tblImg,$mythumbfiles,$myfiles;
    //取得副檔名、uploadify預設傳過來的file名稱為$_FILES['Filedata']
    $fileParts = pathinfo($_FILES[$fileFormName]['name']);
    $ext=strtolower($fileParts['extension']);                                          
    //讀取經緯度
    $exif = exif_read_data($_FILES[$fileFormName]['tmp_name'], 0, true);         
    //緯度
    $latitude=getGps($exif['GPS']['GPSLatitude'],$exif['GPS']['GPSLatitudeRef']);
    //經度
    $longitude=getGps($exif['GPS']['GPSLongitude'],$exif['GPS']['GPSLongitudeRef']);

    //自動排序
    if(empty($sort)){
        $sort=auto_sort($class,$col_name,$col_sn);
    }

    //實體化上傳物件
    $file_handle = new upload($_FILES['Filedata'],"zh_TW");
    //取消上傳時間限制
    set_time_limit(0);
    //設置上傳大小
    ini_set('memory_limit', '80M');

    if(!empty($allowed)){
        $file_handle->allowed=array("image/*");
    }
    if ($file_handle->uploaded){
        $file_handle->file_safe_name = false;
        $file_handle->file_overwrite = true;
        if($file_handle->image_src_x > 1200){
            $file_handle->image_resize         = true;
            $file_handle->image_x              = 1200;
            $file_handle->image_ratio_y         = true;
        }
        $file_handle->file_new_name_body   = "{$class}_{$map_sn}{$sort}";
        $file_handle->process($myfiles);
        $file_handle->auto_create_dir = true;
        //上傳完原始檔之後再上傳小縮圖檔
        $file_handle->file_safe_name = false;
        $file_handle->file_overwrite = true;
        $file_handle->image_resize         = true;
        $file_handle->image_x              = 100;
        $file_handle->image_ratio_y         = true;
        $file_handle->file_new_name_body   = "thumb_{$class}_{$map_sn}_{$sort}";
        $file_handle->process($mythumbfiles);
        $file_handle->auto_create_dir = true;

        
        $file_name="{$class}_{$map_sn}_{$sort}.{$ext}";
    }
    if ($file_handle->processed) {
        $sql = "insert into `{$tblImg}` (`class`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `lat`, `long`) values('{$class}','{$map_sn}','{$sort}','{$kind}','{$file_name}','{$_FILES[$fileFormName]['type']}','{$_FILES[$fileFormName]['size']}','{$_FILES[$fileFormName]['name']}','{$latitude}','{$longitude}')";
        mysql_query($sql) or redirect_header($_SERVER['PHP_SELF'],3, "新增類別失敗");
	   return true;        
    }else{
	   return false;
    }    
}
//自動編號
function auto_sort($class="",$col_name="",$col_sn=""){
	global $xoopsDB,$xoopsUser,$MDIR;

	$sql = "select max(sort) from ".$xoopsDB->prefix("{$MDIR}_files_center")." where `class`='{$class}' and `col_name`='{$col_name}' and `col_sn`='{$col_sn}'";

 	$result=$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
 	list($max)=$xoopsDB->fetchRow($result);
	return ++$max;
}

function getGps($exifCoord, $hemi) {
    $degrees = count($exifCoord) > 0 ? gps2Num($exifCoord[0]) : 0;
    $minutes = count($exifCoord) > 1 ? gps2Num($exifCoord[1]) : 0;
    $seconds = count($exifCoord) > 2 ? gps2Num($exifCoord[2]) : 0;
    $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
    return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
}
 
function gps2Num($coordPart) {
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
        return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
}


?>