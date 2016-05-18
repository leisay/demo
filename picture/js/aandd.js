/*
        <a class="brand" href="index.html">蟲新認識</a>
		<div class="nav-collapse">
		<ul class="nav nav-pills">
        <li class="dropdown" id="menutest1">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#menutest1">
            昆蟲現形記
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="insect_guest.html">我是昆蟲嗎？</a></li>
                <li><a href="insect_home.html">昆蟲的家在那裡？</a></li>
                <li><a href="insect_move.html">昆蟲大風吹</a></li>
                <li><a href="insect_structure.html">昆蟲構造總整理</a></li>
                <li><a href="insect_test1.html">我是昆蟲PK賽</a></li>
            </ul>
        </li>
        <li class="dropdown" id="menutest2">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#menutest2">
            昆蟲奧運會
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li><a href="magnifier.html">昆蟲放大鏡</a></li>
                <li><a href="insect_painter.html">昆蟲素描</a></li>
                <li><a href="#">昆蟲運動家</a></li>
            </ul>
        </li>
        </ul>
		</div>
*/
var menu='<a class="brand" href="index.html">蟲新認識</a><div class="nav-collapse"><ul class="nav nav-pills"><li class="dropdown" id="menutest1"><a class="dropdown-toggle" data-toggle="dropdown" href="#menutest1">昆蟲現形記<b class="caret"></b></a><ul class="dropdown-menu"><li><a href="insect_guest.html">我是昆蟲嗎？</a></li><li><a href="insect_home.html">昆蟲的家在那裡？</a></li><li><a href="insect_move.html">昆蟲大風吹</a></li><li><a href="insect_structure.html">昆蟲構造總整理</a></li><li><a href="insect_test1.html">我是昆蟲PK賽</a></li></ul></li><li class="dropdown" id="menutest2"><a class="dropdown-toggle" data-toggle="dropdown" href="#menutest2">昆蟲奧運會<b class="caret"></b></a><ul class="dropdown-menu"><li><a href="magnifier.html">昆蟲放大鏡</a></li><li><a href="insect_painter.html">昆蟲素描</a></li><li><a href="#">昆蟲運動家</a></li></ul></li></ul></div>';
function addmenu(){
	$("#top_menu").append(menu);
	//$('#nav-collapse').html(menu);
}

/*
    <div class="hero-unit" id="hero-unit">
	<div id="myCarousel" class="carousel slide">
    <!-- Carousel items -->
    <div class="carousel-inner">
    <div class="active item"><img src="img/00DSC_0651.jpg" />
        <div class="carousel-caption">
          <h4>標題一</h4>
          <p>內容一</p>
        </div>
    </div>
    <div class="item"><img src="img/00DSC_0674.jpg" /></div>
    <div class="item"><img src="img/00DSC_0686.jpg" /></div>
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
	</div>
*/


var header='<div class="hero-unit" id="hero-unit"><div id="myCarousel" class="carousel slide"><!-- Carousel items --><div class="carousel-inner"><div class="active item"><img src="img/00DSC_0651.jpg" /><div class="carousel-caption"><h4>標題一</h4><p>內容一</p></div> </div> <div class="item"><img src="img/00DSC_0674.jpg" /></div> <div class="item"><img src="img/00DSC_0686.jpg" /></div> </div> <!-- Carousel nav --> <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a> </div></div>';
function addheader(){
	$("#main_content").prepend(header);
	//$('#hero-unit').prepend(header);
}