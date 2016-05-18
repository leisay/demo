<?php
include_once("set.php");
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$map_id=(empty($_REQUEST['map_id']))?"":$_REQUEST['map_id'];
$js_link="
<script type='text/javascript'
    src='https://maps.google.com/maps/api/js?sensor=false&libraries=places'>
</script>
<script type='text/javascript'>
//初始化地圖的函數
function initialize() {
    //設定初始地圖參數
    var mapOptions = {
        center: new google.maps.LatLng(23.5, 120.93),
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    //產生地圖物件
    var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
    //設定自動完成地址表單。
    var input = document.getElementById('searchTextField');
    var autocomplete = new google.maps.places.Autocomplete(input);


    //產生標記標記可移動，取得經緯度
    var marker = new google.maps.Marker({
        draggable:true,
        map: map
    });
    
    //取得自動完成的地點，並設定各項地圖的初始值。
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        //利用getPlace取得位置
        var place = autocomplete.getPlace();
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }
    //增加一個監聽事件，當地圖的指標移動時傳回經度緯度以及縮放值到表單。
    google.maps.event.addListener(marker,'dragend',function(){
        $('#insertmarkerlat').val(marker.getPosition().lat());
        $('#insertmarkerlong').val(marker.getPosition().lng());
        $('#insertmarkerzoom').val(map.getZoom());
    });

    //找到地點之後設定圖標位置
    //MarkerImage(url:string, size?:Size, origin?:Point, anchor?:Point, scaledSize?:Size)
    var image = new google.maps.MarkerImage(
        place.icon,
        new google.maps.Size(71, 71),
        new google.maps.Point(0, 0),
        new google.maps.Point(17, 34),
        new google.maps.Size(35, 35)
    );
    marker.setIcon(image);
    marker.setPosition(place.geometry.location);
    });
}
    //網頁完成之後，產生地圖。
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
";
$css_link="
<style type='text/css'>
  #map_canvas { height: 100% }
</style>
";
$js_fun="
<script>
    $(function(){
        initialize();
    });
</script>
 
";

//-------------------設定區-----------------------//
//引入外部檔案


//---------------流程控制區----------------------//
switch($op){
	//更新地圖資料
    case "update_map":
    update_map();
    header("location:picture.php");
    break;
    
    //呈現修改地圖表單
    case "modify_form":
    $content=bootstrap(add_map_form($map_id),map_js_link($map_id),$css_link,$js_fun);
    break;
    
    //儲存地圖資料
    case "save_map":
    save_map();
    header("location:picture.php");
    break;
    
    default:
    $content=bootstrap(add_map_form(),$js_link,$css_link,$js_fun);
}
//die(phpinfo());

//------------------輸出區----------------------//
echo $content;
//----------------------函數區-------------------------//

function add_map_form($map_id=""){
    global $link,$tablemap;
    if(empty($map_id)){
        //若$map_id是空則是新增
        $auto_adress="<legend>請輸入或點選景點或地址:<input id='searchTextField' type='text' size='30'></legend>";
        $hidden="
        <input type='hidden' name='op' value='save_map'>
        ";
        $map_title="";
        $map_lat="";
        $map_lng="";
        $map_zoom="";
        $map_content="";
        
    }else{
        //若$map_id有值則是修改
        //取得要修改地圖的資料
        $sql="select * from `{$tablemap}` where map_id='{$map_id}'";
        $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
        while($data=mysql_fetch_assoc($result)){
            foreach($data as $i=>$v){
                $$i=$v;
            }
        }
    
        $auto_adress="";
        $hidden="
        <input type='hidden' name='op' value='update_map'>
        <input type='hidden' name='map_id' value='{$map_id}'>  
        ";
    }
    $main="
        <form class='well' enctype='multipart/form-data' method='post' action='{$_SERVER['PHP_SELF']}'>
        <ul class='thumbnails'>
        <li class='span6'>
            <div id='map_canvas' style='width:440px; height:500px';></div>
        </li>
        <li class='span5'>
            <fieldset>
            {$auto_adress}
            <label>請輸入地圖標題：</label><input type='text' name='map_title' value='{$map_title}'>
            <label>請輸入經度：</label><input type='text' name='map_lat' value='{$map_lat}' id='insertmarkerlat'>
            <label>請輸入緯度：</label><input type='text' name='map_lng' value='{$map_lng}' id='insertmarkerlong'>
            <label>請輸入縮放等級：</label><input type='text' name='map_zoom' value='{$map_zoom}' id='insertmarkerzoom'>
            <label>請輸入地圖內容：<br><textarea name='map_content' class='ckeditor'>{$map_content}</textarea><br>
            {$hidden}
            <input type='submit' value='儲存地圖'>
            </fieldset>
        </li>
        </ul>
        </form>
    ";
    return $main;
}

function save_map(){
    global $link;
    $sql="insert into `google_map_book` (`map_title`, `map_content`, `map_lat`, `map_lng`, `map_zoom`) values ('{$_POST['map_title']}','{$_POST['map_content']}','{$_POST['map_lat']}','{$_POST['map_lng']}','{$_POST['map_zoom']}')";
    //執行資料庫查詢
    $result = mysql_query($sql,$link) or die_content("新增類別失敗");
    $insertid=mysql_insert_id();
    return $insertid;
}

//修改地圖的google map js檔案
function map_js_link($map_id=""){
    global $link,$tablemap;
    $sql="select * from `{$tablemap}` where map_id='{$map_id}'";
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
        center: new google.maps.LatLng({$map_lat}, {$map_lng}),
        zoom: {$map_zoom},
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
    //產生地圖物件
    var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
    var LatLng = new google.maps.LatLng({$map_lat},{$map_lng});
    var marker = new google.maps.Marker({
        position : LatLng,
        map : map,
        draggable:true,
        icon: '"._WEB_ROOT_URL."img/marker.png',
        title : '{$map_title}',
        shadow : 'shadow'
    });
    //增加一個監聽事件，當地圖的指標移動時傳回經度緯度以及縮放值到表單。
    google.maps.event.addListener(marker,'dragend',function(){
        $('#insertmarkerlat').val(marker.getPosition().lat());
        $('#insertmarkerlong').val(marker.getPosition().lng());
        $('#insertmarkerzoom').val(map.getZoom());
    });
}
</script>
    ";
    return $main;
}

function update_map(){
    global $link,$tablemap;
    $sql="replace into `google_map_book` (`map_id`, `map_title`, `map_content`, `map_lat`, `map_lng`, `map_zoom`) values ('{$_POST['map_id']}','{$_POST['map_title']}','{$_POST['map_content']}','{$_POST['map_lat']}','{$_POST['map_lng']}','{$_POST['map_zoom']}')";
    //執行資料庫查詢
    $result = mysql_query($sql,$link) or die_content("新增類別失敗".mysql_error());
    $insertid=mysql_insert_id();
    return $insertid;
}
?>