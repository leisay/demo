<?php
include_once("set.php");

//set
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];

//set
switch($op){
	default:
	$content = bootstrap(map_list());
}

//enter
echo $content;

//function

function map_list(){
	global $link,$tablemap;
	$map_list="";
	$main="";
	$sql="Select * from `{$tablemap}`";
	$result=mysql_query($sql,$link) or die_content("select {$tablemap} fail");
	while($data=mysql_fetch_assoc($result)){
		foreach ($data as $k => $v) {
			$$k=$v;
		}
		$map_list.="<tr>
		<td>{$map_title}</td>
		<td>{$map_content}</td>
		<td class='span4'>
		<a href='{$_SERVER['PHP_SELF']}?op=gmap&map_id={$map_id}' class='btn btn-primary'>map</a>
<a href='{$_SERVER['PHP_SELF']}?op=book&map_id={$map_id}' class='btn btn-success'>相簿</a> 
        <a href='admin_map.php?op=modify_form&map_id={$map_id}' class='btn btn-warning'>修改</a> 
        <a href='{$_SERVER['PHP_SELF']}?op=upload&map_id={$map_id}' class='btn btn-danger'>管理圖片</td></tr>
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
?>