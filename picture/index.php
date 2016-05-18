<?php
include_once("setup.php");
//-------------------設定區-----------------------//
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$map_sn=(empty($_REQUEST['map_sn']))?"":$_REQUEST['map_sn'];
//---------------流程控制區----------------------//
switch($op){
	//刪除相簿
    case "del_map":
    del_map($map_sn);
    header("location:{$_SERVER['PHP_SELF']}");
    break;
    
    //呈現相簿
    case "book":
    $content=bootstrap(book($map_sn),$fancyBox_js,$fancyBox_css,book_js_fun());
    break;
    
    //呈現網路地圖相簿
    case "gmap":
    $content=bootstrap(gmap($map_sn),gmap_js_link(),"",gmap_js_fun($map_sn));
    break;
    
    default:
    $content=bootstrap(map_list(),"","",confirm_check());
}

//------------------輸出區----------------------//
echo $content;
//----------------------函數區-------------------------//

function map_list(){
    global $link,$tblBook;
    $map_list="";
    $main="";
    $sql="select * from `{$tblBook}`";
    $result=mysql_query($sql,$link) or die_content("查詢{$tblBook}資料失敗");
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
        $map_list.="<tr>
        <td>{$map_title}</td>
        <td>{$map_content}</td>
        <td class='span4'>
        <a href='{$_SERVER['PHP_SELF']}?op=gmap&map_sn={$map_sn}' class='btn btn-primary'>地圖</a> 
        <a href='{$_SERVER['PHP_SELF']}?op=book&map_sn={$map_sn}' class='btn btn-success'>相簿</a> 
        <a href='admin_map.php?op=modify_form&map_sn={$map_sn}' class='btn btn-warning'>修改</a> 
        <a href='img_upload.php?map_sn={$map_sn}' class='btn btn-danger'>管理圖片</a>
        <a href='{$_SERVER['PHP_SELF']}?op=del_map&map_sn={$map_sn}' class='btn btn-inverse'>刪除</a>
        </td></tr>
        ";
    }
    $main="
    <table class='table table-striped table-bordered table-condensed'>
    <tr><th>地圖標題</th><th>簡介內容</th><th>其他功能</th></tr>
    {$map_list}
    </table>
    ";
    return  $main;
}
function confirm_check(){
    $main="
    <script type='text/javascript'>
    $(function(){
        $('.btn-inverse').click(function(){
            if (!confirm('確定進行點選的動作'))
            return false;
        });
    });
    </script>
    ";
    return $main;
}

function del_map($map_sn=""){
    global $link,$tblBook,$tblImg;
    //先找出屬於該地圖的所有圖片檔案序號並存成陣列。
    $data_arr=array();
    $sql="select files_sn from `{$tblImg}` where col_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while(list($files_sn)=mysql_fetch_row($result)){
        $data_arr[]=$files_sn;    
    }

    //開始刪除檔案
    foreach($data_arr as $v){
        del_file($v);
    }
    //刪除完檔案，刪除地圖資料
    $sql="delete from `{$tblBook}` where map_sn='{$map_sn}'";
    mysql_query($sql,$link) or die_content("刪除資料失敗".mysql_error());
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
}

function gmap($map_sn=""){
    global $link,$tblBook,$tblImg,$myfiles_url,$mythumbfiles_url;
    $sql="select * from `{$tblBook}` where map_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    $img_list="";
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    $sql="select * from `{$tblImg}` where col_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
        $img_list.="
        <div><img src='{$mythumbfiles_url}thumb_{$file_name}' class='img-rounded img-polaroid' id='thumb_{$files_sn}'>{$file_name}</div>
        ";
    }
    $main="
    <table class='table table-striped table-bordered table-condensed'>
    <tr><td>地圖標題</td><td>{$map_title}</td><tr>
    <tr><td colspan=2>地圖內容</td><tr>
    <tr><td colspan=2>{$map_content}</td><tr>
    </table>

    <ul class='thumbnails'>
    <li class='span3'>
        {$img_list}
    </li>
    <li class='span9'>
        <div id='map_canvas' style='height:500px'; class='span9'>
    </li>
    </ul>
    ";
    
    return $main;
}

function gmap_js_link(){
    $main="<script type='text/javascript'
    src='https://maps.google.com/maps/api/js?sensor=false'>
</script>    
    ";
    return $main;
}

function gmap_js_fun($map_sn=""){
    global $link,$tblBook,$tblImg,$mythumbfiles_url,$myfiles_url;
    //取得地圖資料
    $sql="select * from `{$tblBook}` where map_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    //取得所有圖片資料
    $img_marker="";
    $sql="select * from `{$tblImg}` where col_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
        $img_marker.="
        var image{$files_sn} = new google.maps.MarkerImage(
            '{$mythumbfiles_url}thumb_{$file_name}',
            new google.maps.Size(80,80),
            new google.maps.Point(0,0)
        );
        var content{$files_sn}='<img src=\"{$myfiles_url}{$file_name}\" class=\"span3 img-rounded\"><p>{$file_name}</p>';
        
        var infowindow{$files_sn} = new google.maps.InfoWindow({
            content: content{$files_sn}
        });
        
        var LatLng{$files_sn} = new google.maps.LatLng({$lat},{$long});
        var marker{$files_sn} = new google.maps.Marker({
            position : LatLng{$files_sn},
            map : map,
            title : '{$file_name}',
            icon : image{$files_sn},
            shadow : 'shadow'
        });
        
        google.maps.event.addListener(marker{$files_sn}, 'click', function() {
            infowindow{$files_sn}.open(map,marker{$files_sn});
        });
        $('#thumb_{$files_sn}').click(function(){
            infowindow{$files_sn}.open(map,marker{$files_sn});
        });
        ";
    }

    $main="
    <script>
        $(function(){
            initialize();
        });
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
        map.setMapTypeId(google.maps.MapTypeId.HYBRID );
        {$img_marker}
    
    }
        //網頁完成之後，產生地圖。
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
        ";
    return $main;
}

function book($map_sn=""){
    global $link,$tblBook,$tblImg,$mythumbfiles_url,$myfiles_url;
    //取得地圖資料
    $sql="select * from `{$tblBook}` where map_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
    }
    $main="
    <table class='table table-striped table-bordered table-condensed'>
    <tr><td>地圖標題</td><td>{$map_title}</td><tr>
    <tr><td colspan=2>地圖內容</td><tr>
    <tr><td colspan=2>{$map_content}</td><tr>
    </table>
    ";

    //取得所有圖片資料
    $img_show="";
    $sql="select * from `{$tblImg}` where col_sn='{$map_sn}'";
    $result=mysql_query($sql,$link) or die_content("查詢資料失敗".mysql_error());
    while($data=mysql_fetch_assoc($result)){
        foreach($data as $i=>$v){
            $$i=$v;
        }
        
        $img_show.="
        <a class='fancybox-thumb' rel='fancybox-thumb' href='{$myfiles_url}{$file_name}' 
         title='{$file_name}'>
         <img src='{$myfiles_url}{$file_name}' class='img-rounded img-polaroid span2'>
        </a>
        ";
    }
    $main.=$img_show;
    $main.="
<a class='fancybox-thumb fancybox.ajax' data-fancybox-type='ajax' href='index.php'>Ajax呈現內容</a>
<a class='fancybox-thumb' data-fancybox-type='iframe' href='http://aandd.idv.tw'>Iframe呈現內容</a>
<a class='fancybox-thumb' href='#inline'>Inline錨點</a>
<a class='fancybox-thumb' href='http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf'>SWF動畫</a>
		<a class='fancybox-thumb fancybox.iframe' href='http://www.youtube.com/embed/L9szn1QQfas?autoplay=1'>Youtube 影片</a>
		<a class='fancybox-thumb fancybox.iframe' href='http://maps.google.com/?output=embed&amp;f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=London+Eye,+County+Hall,+Westminster+Bridge+Road,+London,+United+Kingdom&amp;hl=lv&amp;ll=51.504155,-0.117749&amp;spn=0.00571,0.016512&amp;sll=56.879635,24.603189&amp;sspn=10.280244,33.815918&amp;vpsrc=6&amp;hq=London+Eye&amp;radius=15000&amp;t=h&amp;z=17'>Google maps 地圖</a>
<a class='fancybox-thumb' href='/data/non_existing_image.jpg'>不存在的網址</a>


    ";
    return $main;
}

function book_js_fun(){
    $main="
<script>
$(function() {
    $('.fancybox-thumb').fancybox({
		prevEffect	: 'fade',
		nextEffect	: 'elastic',
        padding:[10,10,10,10],
        margin:[10,10,10,10],
        width:'auto',
        arrows:false,
		helpers	: {
            overlay : {
        		closeClick : true,
        		speedOut   : 500,
        		showEarly  : true
        	},
            title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 100,
				height	: 70
			}
		}
    });
});
</script>
    ";
    return $main;
}

function book_js_fun_backup(){
    $main="
<script>
$(function() {
    $('.fancybox-thumb').fancybox({
		prevEffect	: 'fade',
		nextEffect	: 'elastic',
		helpers	: {
            overlay : {
        		closeClick : true,
        		speedOut   : 500,
        		showEarly  : true
        	},
            title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 100,
				height	: 70
			}
		}
    });
});
</script>
    ";
    return $main;
}
?>