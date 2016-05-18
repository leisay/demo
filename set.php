<?PHP
//set
define("_WEB_ROOT_URL","http://{$_SERVER['SERVER_NAME']}/googlemap");
define("_WEB_ROOT_PATH","{$_SERVER['DOCUMENT_ROOT']}/googlemap/");
define("_UPLOAD_PATH","{$_SERVER['DOCUMENT_ROOT']}/googlemap/myfiles");
define("_UPLOAD_URL","{$_SERVER['SERVER_NAME']}/googlemap/myfiles");

//system variable
$title="internation map";
$page_menu=array("Home" => "html.php" , "creative map" => "creative.php");
$tablemap ="map";
$tableimage = "map_img";

//db connect
include("mapsql.php");

//
$top_list = top_list($page_menu);


//auto err_message
function die_content($content = ""){
	$main="<!DOCTYPE html>
		   <html lang='zh_TW'>
		   <head>
		   <meta charset='utf-8'>
		   <title>err_message</title>
		   <meta name='viewport' content='width=device-width', initial-scale=1.0'>
		   <meta name='description' content='err_message'>
       	   <meta name='author' content='aandd'>
        
           <link href='css/bootstrap.css' rel='stylesheet'>
           <link href='css/jquery-ui-1.8.23.custom.css' rel='stylesheet'>
        
        <!--js-->
        <script src='js/jquery1.8.js'></script>
        <script src='js/jquery-ui-1.8.23.custom.min.js'></script>
        <script src='js/bootstrap.js'></script>
        <!--end-->
        </head>
        
        <body>
        <!--body-->
        
        <div class='container' id='main_content'>
          <!-- container -->
            <div class='hero-unit'>
            <div class='alert alert-error'>
            <a class='close' data-dismiss='alert'>×</a>
            <strong>{$content}</strong>
            </div>
            </div>
        
          
          <!--body end -->
          <!-- footer -->
          <footer>
          </footer>
          <!-- footer end -->
        </div> 
        <!-- contain end -->
        </body>
        </html>
    ";
		 die($main);
}

//set nav
function top_list($page_menu = array()){
	$main="
		<!--star-->
		<div class='navbar navbar-fixed-top'>
		<div class='navbar-inner'>
		<div class='container'>
		<ul class='nav'>
	";
	$file_name=basename($_SERVER['PHP_SELF']);
	foreach ($page_menu as $k => $v) {
		$class=($file_name==$v)?"class='active'":"";
		$main.="<li{$class}><a href='{$v}'>{$k}</a></li>";

	}
	$main.="
		</ul>
		</div>
		</div>
		</div>
	";
	return $main;
}

function bootstrap($content="",$js_link="",$css_link="",$js_fun=""){
    global $top_list,$title;
    $main="
        <!DOCTYPE html>
        <html lang='zh_TW'>
        <head>
        <meta charset='utf-8'>
        <title>{$title}</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name='description' content='{$title}'>
        <meta name='author' content='aandd'>
        <link href='css/bootstrap.css' rel='stylesheet'>
        <link href='css/jquery-ui-1.8.23.custom.css' rel='stylesheet'>
        <style type='text/css'>
          body {
            padding-top: 60px;
            padding-bottom: 20px;
          }
        </style>
        <!-- 引入js檔案開始 -->
        <script src='js/jquery1.8.js'></script>
        <script src='js/jquery-ui-1.8.23.custom.min.js'></script>
        <script src='js/bootstrap.js'></script>
        <!-- 引入js檔案結束 -->
        <!--引入額外的css檔案以及js檔案開始-->
        {$js_link}
        {$css_link}
        <!--引入額外的css檔案以及js檔案結束-->
        <!--jquery語法開始-->
        {$js_fun}
        <!--jquery語法結束-->
        </head>
        
        <body>
        <!--放入網頁主體-->
        
        <div class='container' id='main_content'>
          <!-- 主要內容欄位開始 -->
          {$top_list}
          {$content}
          <!-- 主要內容欄位結束 -->
          <!-- 頁腳開始 -->
          <footer>
          </footer>
          <!-- 頁腳結束 -->
        </div> 
        <!-- 主要內容欄位結束 -->
        </body>
        </html>
    ";
    return $main;
    
}
?>