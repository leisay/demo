<?php
include_once("../../setup.php");
include_once "../../class/class.upload/class.upload.php";

$map_sn = $_POST['map_sn'];
file_upload("img",$map_sn);

function file_upload($class="",$map_sn="",$fileFormName='Filedata'){
    global $link,$tblImg,$mythumbfiles,$myfiles,$tblImg;
    //取得附檔名
    $ext=pathinfo($_FILES[$fileFormName]['name'],PATHINFO_EXTENSION);
    //讀取經緯度
    $exif = exif_read_data($_FILES[$fileFormName]['tmp_name'], 0, true);         
    //緯度
    $latitude=getGps($exif['GPS']['GPSLatitude'],$exif['GPS']['GPSLatitudeRef']);
    //經度
    $longitude=getGps($exif['GPS']['GPSLongitude'],$exif['GPS']['GPSLongitudeRef']);
    //自動排序
    if(empty($sort)){
        $sort=auto_sort($class,$map_sn);
    }
    
    //實體化上傳物件
    $file_handle = new upload($_FILES['Filedata'],"zh_TW");
    //取消上傳時間限制
    set_time_limit(0);
    //設置上傳大小
    ini_set('memory_limit', '80M');
    $file_handle->allowed=array("image/*");
    $file_handle->auto_create_dir = true;
    if ($file_handle->uploaded){
        $file_handle->file_safe_name = false;
        $file_handle->file_overwrite = true;
        if($file_handle->image_src_x > 1200){
            $file_handle->image_resize         = true;
            $file_handle->image_x              = 1200;
            $file_handle->image_ratio_y         = true;
            $file_handle->file_new_name_body   = "{$class}_{$map_sn}_{$sort}";
        }
        $file_handle->process($myfiles);
        //上傳完原始檔之後再上傳小縮圖檔
        if($file_handle->image_src_x > 100){
            $file_handle->image_resize         = true;
            $file_handle->image_x              = 100;
            $file_handle->image_ratio_y         = true;
            $file_handle->file_new_name_body   = "thumb_{$class}_{$map_sn}_{$sort}";
        }
        $file_handle->process($mythumbfiles);
        $file_name="{$class}_{$map_sn}_{$sort}.{$ext}";
    }
    
    if ($file_handle->processed) {
        $sql = "insert into `{$tblImg}` (`class`, `col_sn`, `sort`, `kind`, `file_name`, `file_type`, `file_size`, `description`, `lat`, `long`) values('{$class}','{$map_sn}','{$sort}','{$kind}','{$file_name}','{$_FILES[$fileFormName]['type']}','{$_FILES[$fileFormName]['size']}','{$_FILES[$fileFormName]['name']}','{$latitude}','{$longitude}')";
        mysql_query($sql) or die_content("新增圖片資料".mysql_error());
	   return true;        
    }else{
	   return false;
    } 
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
//自動編號
function auto_sort($class="",$col_sn=""){
	global $link,$tblImg;

	$sql = "select max(sort) from `{$tblImg}` where `class`='{$class}' and `col_sn`='{$col_sn}'";

 	$result=mysql_query($sql) or die_content("自動排序失敗".mysql_error());
 	list($max)=mysql_fetch_row($result);
	return ++$max;
}

?>