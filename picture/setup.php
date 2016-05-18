<?php
//系統基本資料
define("_WEB_ROOT_URL","http://{$_SERVER['SERVER_NAME']}/googlemap/");
define("_WEB_ROOT_PATH","{$_SERVER['DOCUMENT_ROOT']}/googlemap/");
define("_UPLOAD_PATH","{$_SERVER['DOCUMENT_ROOT']}/googlemap/myfiles/");
define("_UPLOAD_URL","{$_SERVER['SERVER_NAME']}/googlemap/myfiles/");

//系統變數
$title="網路地圖相簿";
$page_menu=array(
    "首頁"=>"index.php",
    "新增地圖"=>"admin_map.php",
    "基礎檔案上傳"=>"upload_base.php",
    "物件檔案上傳"=>"upload_class.php"
    
    );
$tblBook="google_map_book";
$tblImg="google_map_img";


//設定要引入fancybox的相關檔案
$fancyBox_js="
<script type='text/javascript' src='"._WEB_ROOT_URL."js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js'></script>
<script type='text/javascript' src='"._WEB_ROOT_URL."js/fancyBox/source/jquery.fancybox.pack.js'></script>
<script type='text/javascript' src='"._WEB_ROOT_URL."js/fancyBox/source/helpers/jquery.fancybox-buttons.js'></script>
<script type='text/javascript' src='"._WEB_ROOT_URL."js/fancyBox/source/helpers/jquery.fancybox-media.js'></script>
<script type='text/javascript' src='"._WEB_ROOT_URL."js/fancyBox/source/helpers/jquery.fancybox-thumbs.js'></script>
";

$fancyBox_css="
<link rel='stylesheet' type='text/css' href='"._WEB_ROOT_URL."js/fancyBox/source/jquery.fancybox.css' />
<link rel='stylesheet' type='text/css' href='"._WEB_ROOT_URL."js/fancyBox/source/helpers/jquery.fancybox-buttons.css' />
<link rel='stylesheet' type='text/css' href='"._WEB_ROOT_URL."js/fancyBox/source/helpers/jquery.fancybox-thumbs.css' />
";

$myfiles=_WEB_ROOT_PATH.'basefiles/';
//修改您網站的檔案上傳資料夾目的地
$myfiles_url=_WEB_ROOT_URL.'basefiles/';
//修改您網站的檔案上傳資料夾的網址
$mythumbfiles=_WEB_ROOT_PATH.'thumbfiles/';
//修改您網站的檔案上傳資料夾目的地
$mythumbfiles_url=_WEB_ROOT_URL.'thumbfiles/';
//修改您網站的檔案上傳資料夾的網址


//資料庫連線
$db_id="root";//資料庫使用者//
$db_passwd="123";//資料庫使用者密碼//
$db_name="member";//資料庫名稱//

//動態產生導覽列
$top_nav=dy_nav($page_menu);

//連入資料庫
$link=@mysql_connect("localhost",$db_id,$db_passwd) or die_content("資料庫無法連線");
if(!mysql_select_db($db_name)) die_content("無法選擇資料庫");

//設定資料庫編碼
mysql_query("SET NAMES 'utf8'");

//自定輸出錯誤訊息
function die_content($content=""){
    $main="
        <!DOCTYPE html>
        <html lang='zh_TW'>
        <head>
        <meta charset='utf-8'>
        <title>輸出錯誤訊息</title>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta name='description' content='輸出錯誤訊息'>
        <meta name='author' content='aandd'>
        
        <link href='css/bootstrap.css' rel='stylesheet'>
        <link href='css/jquery-ui-1.8.23.custom.css' rel='stylesheet'>
        
        <!-- 引入js檔案開始 -->
        <script src='js/jquery1.8.js'></script>
        <script src='js/jquery-ui-1.8.23.custom.min.js'></script>
        <script src='js/bootstrap.js'></script>
        <!-- 引入js檔案結束 -->
        </head>
        
        <body>
        <!--放入網頁主體-->
        
        <div class='container' id='main_content'>
          <!-- 主要內容欄位開始 -->
            <div class='hero-unit'>
            <div class='alert alert-error'>
            <a class='close' data-dismiss='alert'>×</a>
            <strong>{$content}</strong>
            </div>
            </div>
        
          
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
    die($main);
}

//產生動態導覽列
function dy_nav($page_menu=array()){
    $main="
      <!--導覽列開始  navbar-fixed-bottom 固定在下方  navbar-fixed-top在上方-->
      <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
      <div class='container'>
      <ul class='nav'>
    ";
    $file_name=basename($_SERVER['PHP_SELF']);
    foreach($page_menu as $i=>$v){
        $class=($file_name==$v)?"class='active'":"";
        $main.="<li {$class}><a href='{$v}'>{$i}</a></li>";
    }
    $main.="
      </ul>
      </div>
      </div>
      </div>
      <!--導覽列結束-->
    ";
    return $main;
}

function bootstrap($content="",$js_link="",$css_link="",$js_fun=""){
    global $top_nav,$title;
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
          {$top_nav}
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