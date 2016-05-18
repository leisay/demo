<?php
include_once("setup.php");
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$map_sn=(empty($_REQUEST['map_sn']))?"":$_REQUEST['map_sn'];
$files_sn=(empty($_REQUEST['files_sn']))?"":$_REQUEST['files_sn'];
$js_link="
<script type='text/javascript' src='js/uploadify31/jquery.uploadify-3.1.min.js'></script>
<script type='text/javascript' src='js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
<script type='text/javascript' src='js/fancyBox/source/jquery.fancybox.pack.js'></script>
<script type='text/javascript' src='js/fancyBox/source/helpers/jquery.fancybox-buttons.js'></script>
<script type='text/javascript' src='js/fancyBox/source/helpers/jquery.fancybox-media.js'></script>
<script type='text/javascript' src='js/fancyBox/source/helpers/jquery.fancybox-thumbs.js'></script>

";
$css_link="
<link rel='stylesheet' type='text/css' href='js/uploadify31/uploadify.css' />
<link rel='stylesheet' type='text/css' href='js/fancyBox/source/jquery.fancybox.css' />
<link rel='stylesheet' type='text/css' href='js/fancyBox/source/helpers/jquery.fancybox-buttons.css' />
<link rel='stylesheet' type='text/css' href='js/fancyBox/source/helpers/jquery.fancybox-thumbs.css' />
";
$js_fun="
<script>
$(function() {
    var up_file_name='';
    //一鍵多檔上傳
    $('#file_upload').uploadify({
        'swf'      : 'js/uploadify31/uploadify.swf',
        'uploader' : 'js/uploadify31/uploadify.php',
        'method'   : 'post',
        'formData' : { 'map_sn':'{$map_sn}' },
        'onUploadSuccess' : function(file, data, response) {
            up_file_name += file.name + '、';
        },
        'onDialogOpen' : function() {
            if($('#message_box').length<=0){
                $('form').append('<a id=\"message_box\" class=\"btn btn-danger\">您可以一次選擇多個檔案</a>');
           }
        },
        'onQueueComplete' : function(queueData) {
            alert(queueData.uploadsSuccessful + ' 個檔案上傳成功了！' + up_file_name);
            location.reload();
        } 
    });
    //漸入漸岀的設定
    $('.img-polaroid').css(\"opacity\",\"0.5\");
    $('.img-polaroid').hover(function(){
            $(this).stop().animate({opacity:1});
        },function(){
            $(this).stop().animate({opacity:0.5});
    });
    //即時刪除圖片
    $('.close').click(function(){
        var dest = $(this).attr('id');
        dest_arr=dest.split('_');
        dest_id=dest_arr[1];
        $('#feedback').html('');
        $.post(
            'img_upload.php',
            {'op':'del_file','files_sn':dest_id},
            function(data){
                $('#feedback').html(data);
            }
        );

    });
    //fancybox效果
    $('.fancybox').fancybox();
    
});
</script>
";
switch($op){
    //修改圖片資料
    case "update_img":
    update_img($files_sn);
    header("location:{$_SERVER['PHP_SELF']}?map_sn={$map_sn}");
    break;
    
    //呈現修改圖片資料表單
    case "img_modifyform":
    $content=bootstrap(img_modifyform($files_sn),img_modifyform_js_link($files_sn));
    break;
    
    //ajax刪除檔案
    case "del_file":
    $content=del_file($files_sn);
    break;
    
    //預設出現檔案上傳的表單
    default:
    $content=bootstrap(img_upload_form($map_sn),$js_link,$css_link,$js_fun);
}
//------------------輸出區----------------------//
echo $content;
//----------------------函數區-------------------------//
function img_upload_form($map_sn=""){
    global $myfiles,$tblBook,$link;
    $main="";
    //取得地圖資料
    $sql="select * from `{$tblBook}` where map_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    $main.="
    <table class='table table-striped table-bordered table-condensed'>
    <tr><td>地圖標題</td><td>{$map_title}</td><tr>
    <tr><td colspan=2>地圖內容</td><tr>
    <tr><td colspan=2>{$map_content}</td><tr>
    </table>
    ";
    $main.="
    <fieldset>
        <legend>檔案上傳的表單</legend>
        <p>請選擇檔案之後，按下上傳按鈕<span id='feedback' style='float:right;'></span></p>
        <form name='form1' enctype='multipart/form-data' method='post' action='{$_SERVER['PHP_SELF']}'>
            <p><input size='32' name='file_upload' type='file' id='file_upload'></p>
            <p class='button'><input name='op' value='upload' type='hidden'>
        </form>
    </fieldset>
    ";
    
    $main.=img_list($map_sn);
    return $main;
}

function img_list($map_sn=""){
    global $link,$tblImg,$mythumbfiles_url,$myfiles_url;
    $earth="";
    $main="";
    $sql="select * from `{$tblImg}` where col_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
        if(!empty($lat) && !empty($long) ){
            $earth="<img src='img/earth.png' style='width:20px;'>";
        }
        $main.="
        <div class='alert alert-info span2'>
        <button type='button' class='close' data-dismiss='alert' id='delimg_{$files_sn}'>×</button>
        {$description}
        <a class='fancybox' href='{$myfiles_url}{$file_name}' title='{$file_name}'>
        <img src='{$mythumbfiles_url}thumb_{$file_name}' class='img-polaroid'></a>
        {$earth}
        <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?op=img_modifyform&files_sn={$files_sn}&map_sn={$map_sn}'>修改</a>
        </div>
        ";
    }
    return $main;
}

function del_file($files_sn=""){
    global $link,$tblImg,$myfiles,$mythumbfiles;
    $sql="select * from `{$tblImg}` where files_sn={$files_sn}";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    //刪除資料庫記錄
    $sql="delete from `{$tblImg}` where files_sn={$files_sn}";
    $result=mysql_query($sql,$link) or die_content("刪除資料失敗".mysql_error());
    //刪除檔案
    unlink("{$myfiles}{$file_name}");
    unlink("{$mythumbfiles}thumb_{$file_name}");
    
    return ("<a class='btn btn-danger'>已經刪除檔案{$description}</a>");
}

function img_modifyform($files_sn=""){
    global $link,$tblImg;
    $sql="select * from `{$tblImg}` where files_sn='{$files_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    $main="
    <form class='well' method='post' action='{$_SERVER['PHP_SELF']}'>
    <ul class='thumbnails'>
    <li class='span3'>
        <label>請輸入圖片檔名：</label><input type='text' name='description' value='{$description}'>
        <label>請輸入經度：</label><input type='text' name='lat' value='{$lat}' id='insertmarkerlat'>
            <label>請輸入緯度：</label><input type='text' name='long' value='{$long}' id='insertmarkerlong'>
        <input type='hidden' name='op' value='update_img'>
        <input type='hidden' name='map_sn' value='{$_GET['map_sn']}'>
        <input type='hidden' name='files_sn' value='{$files_sn}'>  
        <input type='submit' value='儲存圖片資料'>
    </li>
    <li class='span8'>
        <div id='map_canvas' style='height:500px';></div>
    </li>
    </ul>
    </form>
    ";
    return  $main;
}

function img_modifyform_js_link($files_sn=""){
    global $link,$tblImg,$mythumbfiles_url;
    $sql="select * from `{$tblImg}` where files_sn='{$files_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    $main="
<script type='text/javascript'
    src='https://maps.google.com/maps/api/js?sensor=false&libraries=places'>
</script>
<script type='text/javascript'>
//初始化地圖的函數
function initialize() {
    //設定初始地圖參數
    var mapOptions = {
        center: new google.maps.LatLng({$lat}, {$long}),
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    //產生地圖物件
    var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
    var LatLng = new google.maps.LatLng({$lat},{$long});
    var marker = new google.maps.Marker({
        position : LatLng,
        map : map,
        draggable:true,
        icon: '{$mythumbfiles_url}thumb_{$file_name}',
        title : '{$description}',
        shadow : 'shadow'
    });
    //增加一個監聽事件，當地圖的指標移動時傳回經度緯度以及縮放值到表單。
    google.maps.event.addListener(marker,'dragend',function(){
        $('#insertmarkerlat').val(marker.getPosition().lat());
        $('#insertmarkerlong').val(marker.getPosition().lng());
    });
}
    $(function(){
        initialize();
    });
</script>
    ";
    return $main;
}

function update_img($files_sn=""){
    global $link,$tblImg;
    $sql="update `{$tblImg}` set `description`='{$_POST['description']}',`lat`='{$_POST['lat']}',`long`='{$_POST['long']}' where files_sn='{$files_sn}'";

    //執行資料庫查詢
    $result = mysql_query($sql,$link) or die_content("新增類別失敗".mysql_error());
    $insertid=mysql_insert_id();
    return $insertid;
}
?>