<?php
//輸入陣列產生下拉式選單
/*$arr要出入的陣列   $default_val預設的值   $option要不要出現請選擇這個選項   $use_v以索引為值還是以值為值   $validate是否要驗證  */
function array_to_select($arr=array(),$option=true,$default_val="",$use_v=false,$validate=false){
	if(empty($arr))return;
	$opt=($option)?"<option value=''>請選擇</option>\n":"";
	foreach($arr as $i=>$v){
		//false則以陣列索引值為選單的值，true則以陣列的值為選單的值
		$val=($use_v)?$v:$i;
		$selected=($val==$default_val)?"selected":"";        //設定預設值
		$validate_check=($validate)?"class='required'":"";
		$opt.="<option value='$val' $selected $validate_check>$v</option>\n";
	}
	return  $opt;
}

//輸入陣列產生核選表單
function array_to_checkbox($arr=array(),$name="default",$use_v=false,$into_arr=array(),$key_or_val=false){
	if(empty($arr))return;
	$opt="";
	foreach($arr as $i=>$v){
		$val=($use_v)?$v:$i;
		if($key_or_val){
			$checked=(@in_array($val,$into_arr))?"checked":"";
		}else{
			$checked=(@array_key_exists($val,$into_arr))?"checked":"";
		}

		$opt.="<div style='float:left;line-height:20px;padding-right:20px;'><input type='checkbox' id='{$val}' name='{$name}' value='{$val}' $checked style='vertical-align:middle'>$v </div>";
	}
	return $opt;
}

//輸入陣列產生單選表單
function array_to_radio($arr=array(),$use_v=false,$name="default",$default_val="",$validate=false){
	if(empty($arr))return;
	$opt="";
	foreach($arr as $i=>$v){
		$val=($use_v)?$v:$i;
		$checked=($val==$default_val)?"checked='checked'":"";
		$validate_check=($validate)?"class='required'":"";
		$opt.="<input type='radio' name='{$name}' id='{$val}' value='{$val}' $validate_check $checked><label for='{$val}' style='margin-right:15px;'> $v</label>";
	}
	return $opt;
}

//輸入陣列產生單選表單考題用的radio，選項有排版過，可能不是用大部分的狀況
function array_to_radio_css($arr=array(),$use_v=false,$name="default",$default_val="",$validate=false){
	if(empty($arr))return;
	$opt="";
	foreach($arr as $i=>$v){
		$val=($use_v)?$v:$i;
		$checked=($val==$default_val)?"checked='checked'":"";
		$validate_check=($validate)?"class='required'":"";
		$opt.="<input type='radio' name='{$name}' id='{$val}' value='{$val}' $validate_check $checked><label for='{$val}' style='margin-right:15px;font-size:0.85em;'> $v</label><br>";
	}
	return $opt;
}

//取得資料庫單一資料單一欄位值
//$table_name       資料表名稱
//$get_col_name     取得欄位值名稱
//$sn_name          篩選的欄位名稱
//$sn               篩選的欄位值
function get_one_data_from_sn($table_name="",$get_col_name="",$sn_name="",$sn=""){
	global $die_div_css;
	$sql="select {$get_col_name} from `{$table_name}` where {$sn_name}='{$sn}'";
	$result=mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
	list($data)=mysql_fetch_row($result);
	return $data;
}

function get_one_data_from_sn_plus($table_name="",$get_col_name="",$andor=""){
	global $die_div_css;
	$sql="select {$get_col_name} from `{$table_name}` ";
	$sql.=$andor;
	$result=mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
	list($data)=mysql_fetch_row($result);
	return $data;
}

//取得資料庫一筆資料的資料陣列
function get_one_data_arr_from_sn($table_name="",$sn_name="",$sn=""){
	global $die_div_css;
	$sql="select * from `{$table_name}` where {$sn_name}='{$sn}'";
	$result=mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
	$data=mysql_fetch_assoc($result);
	return $data;
}

//取得某個欄位的所有值，傳出陣列
function get_col_arr_from_base($table_name="",$col_name="",$andor=""){
	global $die_div_css;
	$sql="select {$col_name} from `{$table_name}` ";
	$sql.=$andor;
	//die($sql);
	$result=mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
	$arr=array();
	while(list($data)=mysql_fetch_row($result)){
		$arr[$data]=$data;
	}
	return  $arr;
}

//取得某個欄位的所有值，傳出陣列 索引與值不同的陣列
function get_col_diff_arr_from_base($table_name="",$col_name="",$col_name2="",$andor=""){
	global $die_div_css;
	$sql="select {$col_name},{$col_name2} from `{$table_name}` ";
	$sql.=$andor;
	$result=mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
	$arr=array();
	while(list($data,$data2)=mysql_fetch_row($result)){
		$arr[$data]=$data2;
	}
	return  $arr;
}

//刪除一筆資料
function del_one_data_from_base($table_name="",$primary_col_name="",$sn=""){
	$sql="delete from `{$table_name}` where $primary_col_name='{$sn}'";
	//die($sql);
	mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
}

//刪除符合敘述的資料
function del_data_where_from_base($table_name="",$andor=""){
	$sql="delete from `{$table_name}` ";
	$sql.=$andor;
	//die($sql);
	mysql_query($sql) or die("<div {$die_div_css}><h1>取得'{$table_name}'資料失敗".mysql_error()."</h1></div>");
}


function html_content($content="",$mysql_error=""){
	$main="
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
	<html>
	<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8'>
	<meta name='generator' content='PSPad editor, www.pspad.com'>
	<title></title>
	</head>
	<body>
	<div style='margin:20% auto;border:3px dotted gray;width:60%;padding:5px;'>
	{$content}
	{$mysql_error}
	</div>
	</body>
	</html>
	";
	return  $main;
}

//判斷學年度
function judge_semester(){
	$year=date("Y");
	$month=date("m");
	if($month>=8){
		$year=$year-1911;
	}else{
		$year=$year-1912;
	}
	return $year;
}

function push_social_web($web_url="",$sort="row"){
	//橫式排列   預設是直式排列
	if($sort=="col"){
		$css_style="float:left;";
	}
	$main="
	<div style='text-align: left;  color: rgb(224, 224, 224);'>
	<div class='twitter' style='height:16px;margin: 2px;{$css_style}'>
	<a title='將文章推到Twitter' href='http://twitter.com/home/?status={$web_url}' target='_blank' style='color: rgb(151, 218, 245);'><img src='images/twitter.png' alt='將文章推到Twitter' title='將文章推到Twitter' align='absmiddle' hspace='3' style='width:16px;'>推到Twitter</a>
	</div>
	<div class='plurk' style='margin: 2px;{$css_style}'>
	<a title='將文章推到Plurk' href='http://www.plurk.com/?qualifier=shares&amp;status={$web_url}' target='_blank' style='color: rgb(232, 118, 82);'><img src='images/plurk.png' alt='推到Plurk' title='推到Plurk' align='absmiddle' hspace='3' style='width:16px;'>推到Plurk</a>
	</div>
	<div class='facebook' style='margin: 2px;{$css_style}'>
	<a title='將文章推到FaceBook' href='http://www.facebook.com/share.php?u={$web_url}' target='_blank' style='color: rgb(90, 116, 169);'><img src='images/facebook.png' alt='推到FaceBook' title='推到FaceBook' align='absmiddle' hspace='3' style='width:16px;'>推到FaceBook</a>
	</div>
	<div class='googlebuzz' style='margin: 2px;{$css_style}'>
	<a title='將文章推到Google Buzz' href='http://www.google.com/reader/link?url={$web_url}&amp;srcURL={$web_url}' target='_blank' style='color: rgb(255, 220, 103);'><img src='images/googlebuzz.png' alt='推到Google Buzz' title='推到Google Buzz' align='absmiddle' hspace='3' style='width:16px;'>推到Google Buzz</a>
	</div>
	</div>
	";
	return $main;
}

//推文按鈕
function push_button($url="",$fb_button=true,$width=60){
	$main="
	<!--推文開始-->
	<a style='color: rgb(151, 218, 245);' target='_blank'
	href='http://twitter.com/home/?status={$url}'
	title='將文章推到Twitter'><img width='{$width}' height='{$width}' align='absmiddle' hspace='3' title='將文章推到Twitter'
	alt='將文章推到Twitter' src='images/twitter.png'/></a>

	<a style='color: rgb(232, 118, 82);' target='_blank'
	href='http://www.plurk.com/?qualifier=shares&amp;status={$url}'
	title='將文章推到Plurk'><img width='{$width}' height='{$width}' align='absmiddle' hspace='3' title='推到Plurk'
	alt='推到Plurk' src='images/plurk.png'/></a>

	<a style='color: rgb(90, 116, 169);' target='_blank'
	href='http://www.facebook.com/share.php?u={$url}' title='將文章推到FaceBook'>
	<img width='{$width}' height='{$width}' align='absmiddle' hspace='3' title='推到FaceBook'
	alt='推到FaceBook' src='images/fb.png'/></a>

	<!-- 將此標記放在您想要顯示 +1 按鈕的位置 -->
	<g:plusone size='tall' annotation='inline' href='{$url}'></g:plusone>
	<!-- 將此顯示呼叫 (render call) 放在適當位置 -->
	<script type='text/javascript'>
	window.___gcfg = {lang: 'zh-TW'};
	(function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
<!--推文結束-->
";
	if($fb_button){
		$main.="
		<div id='fb-root'></div>
		<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = '//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=211973985502246';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div class='fb-like' data-href='{$url}' data-send='true' data-width='110' data-show-faces='true'></div>
	<!--推文結束-->

	";
	}

	return $main;
}


?>