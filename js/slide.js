var tab_visible;
var tab_s_visible;
var tab_s_section_visible;


window.onload = function () {

    //小圖連結註冊
    var imgs = document.querySelectorAll('aside ul li ');
    for (var key in imgs) {
        imgs[key].onclick = function () {
            var idname = this.getAttribute('id') + '_b';
            if (tab_s_visible)
                        tab_s_visible.setAttribute('class', 'img_hidden');
            tab_s_visible = document.getElementById(idname);
            tab_s_visible.setAttribute('class', 'img_visible');
        }     
    }
    switch_tab_visible('tab_flower'); //顯示第一組
    //頁籤註冊 click 事件
    var tab_lis = document.querySelectorAll('.cat_tab');
    for (var key in tab_lis) {
        tab_lis[key].onclick = function () {
            switch_tab_visible(this.getAttribute('img_tab'));
        };
    }
};
function switch_tab_visible(tabname) {
    if (tab_visible)
        tab_visible.setAttribute('class', 'img_hidden');
    tab_visible = document.getElementById(tabname);
    tab_visible.setAttribute('class', 'img_visible');  
    //顯示第一張圖
    if (tab_s_visible)
        tab_s_visible.setAttribute('class', 'img_hidden');
    tab_s_visible = tab_visible.getElementsByTagName('div')[0];

    tab_s_visible.setAttribute('class', 'img_visible');


    if(tab_s_section_visible)
        tab_s_section_visible.setAttribute('class', 'img_hidden');
    tab_s_section_visible = document.getElementById(tabname + '_section');
    tab_s_section_visible.setAttribute('class', 'img_visible');  


}
function switch_tab_s_visible(tabname) {
    
}

