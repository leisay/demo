<!DOCTYPE html >
<html >
<head>
    <title>shop</title>
    <meta charset="utf-8">
    <style>
        body
        {
            height: 100%;
            margin-top: 0;
        }
        ul
        {
            overflow: hidden;
        }
        ul li
        {
            list-style-type: none;
            float: left;
            width: 150px;
            font-size: 11px;
            line-height: 1.8em;
            padding: 5px 10px;
        }
        div#msection
        {
            margin: 0 auto;
            width: 1000px;
        }
        span.scbutton
        {
            font-size: 10px;
            font-weight: 600;
            color: Maroon;
            cursor: pointer;
            border: 1px dotted red;
        }
        hr
        {
            line-height: 0.5px;
        }
        img
        {
            width: 118px;
        }
        img#itemimageSelect
        {
            width: 86px;
            float: left;
            margin: 4px;
        }
        #itemAddMsg
        {
            font-size: large;
            font-weight: 900;
            margin: 20px;
        }
        span.cartprocess
        {
            border: 2px solid maroon;
            margin: 4px 4px 4px 10px;
            cursor: pointer;
        }
        a
        {
            color: maroon;
            font-weight: 600;
            text-decoration: none;
            margin: 4px;
        }
    </style>
    <script>
        window.onload = function () {
            if (sessionStorage['additemlist'] == undefined) {
                sessionStorage['additemlist'] = '';
            }
            //為每個購物車按鈕註冊 click 事件
            var spans = document.querySelectorAll('span.scbutton');
            for (var i = 0; i < spans.length; i++) {

                spans[i].addEventListener('click', function () {
                    var bookinfo = document.querySelector('#' + this.id + ' input').value;
                    addItem(this.id, bookinfo);
                });
            }
        }
        function addItem(itemid, itemvalue) {

            // 移除舊項目，顯示最新一筆購物車項目
            var newItem = document.getElementById("newItem");
            if (newItem.hasChildNodes()) {
                while (newItem.childNodes.length >= 1) {
                    newItem.removeChild(newItem.firstChild);
                }
            }
            var img = document.createElement('img');
            img.src = 'image/' + itemvalue.split('：')[1];
            img.id = 'itemimageSelect';
            var title = document.createElement('span');
            title.innerHTML = itemvalue.split('：')[0];
            title.id = 'titleSelect';
            var sprice = document.createElement('div');
            sprice.innerHTML = '價格 ：' + itemvalue.split('：')[2];
            document.getElementById('newItem').appendChild(img);
            document.getElementById('newItem').appendChild(title);
            document.getElementById('newItem').appendChild(sprice);

            // true 表示這個項目已經選取過了，不再加入
            // 顯示訊息要求使用者至購物車進行編輯
            if (sessionStorage[itemid]) {
                alert('購物已包含此項目，請直接修改購物車品項數量 !');
            } else {
                sessionStorage['additemlist'] += (itemid + ',');
                sessionStorage[itemid] = itemvalue;
                //計算總合
                var total = 0;
                var itemstring = sessionStorage['additemlist'];
                var items = itemstring.substr(0, itemstring.length - 1).split(',');
                for (var key in items) {
                    var iteminfo = sessionStorage[items[key]];
                    var price = parseInt(iteminfo.split('：')[2]);
                    total += price;
                }
                document.getElementById('subtotal').innerHTML = total;
                document.getElementById('itemcount').innerHTML = items.length;
            }

            document.getElementById('cartmsg').innerHTML = '選購了一項商品 ';
        }
        function checkout() {
            alert('進行結帳匯款動作 …')
        }
    </script>
</head>
<body>
    <div id="msection">
        <div id="sclast">
            <div id="itemAddMsg">
                <span id='cartmsg'>購物車中無任何項目</span>
            </div>
            <div style="float: left; width: 360px; height: 120px; margin-left: 20px; margin-right: 20px">
                <div id="newItem" style="float: left;">
                </div>
                <div style="clear: both">
                </div>
            </div>
            <div style="float: left; width: 600px">
                <div style="float: left">
                    <div style="width: 180px; height: 22px">
                        訂購金額小計：<span id="subtotal" style="padding-left: 6px;">0</span>元</div>
                    <div style="width: 180px; height: 22px">
                        選購品項樣數：<span id="itemcount" style="padding-left: 6px;">0</span>項</div>
                </div>
                <div style="float: left">
                    <span class="cartprocess"><a href="shop2.php" target="_blank">編輯購物車內容</a></span></div>
                <div style="float: left">
                    <span class="cartprocess" onclick='checkout()'>結帳</span></div>
            </div>
            <div style="clear: both">
            </div>
        </div>
        <hr />
        <div id="booklist">
            <ul>
                <li>
                    <div>
                        <img src="image/XP11157.JPG" /><br />
                        Visual C# 2010 精要剖析</div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1001" class="scbutton">加入購物車<input type="hidden" value="Visual C# 2010 精要剖析：XP11157.jpg：520" />
                        </span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="image/sknp00019.jpg" /><br />
                        Entity Framework LINQ 開發實戰</div>
                    <div>
                        定價：590</div>
                    <div>
                        <span id="KT1002" class="scbutton">加入購物車<input type="hidden" value="Entity Framework LINQ 開發實戰：sknp00019.jpg：590" /></span></div>
                </li>
                <li>
                    <div>
                        <img src="image/BO0201.jpg" /><br />
                        C 語言入門經典</div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1003" class="scbutton">加入購物車<input type="hidden" value="C 語言入門經典：BO0201.jpg：520" /></span></div>
                </li>
                <li>
                    <div>
                        <img src="image/linq.jpg" /><br />
                        LINQ 最佳實務講座</div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1004" class="scbutton">加入購物車<input type="hidden" value="LINQ 最佳實務講座：linq.jpg：520" /></span></div>
                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <div>
                        <img src="image/BO0203.jpg" /><br />
                        資料結構－使用 Java
                    </div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1005" class="scbutton">加入購物車<input type="hidden" value="資料結構－使用 Java：BO0203.jpg：520" /></span></div>
                </li>
                <li>
                    <div>
                        <img src="image/BO0204.png" /><br />
                        資料結構－使用 C 語言</div>
                    <div>
                        定價：590</div>
                    <div>
                        <span id="KT1006" class="scbutton">加入購物車<input type="hidden" value="資料結構－使用 C 語言：BO0204.png：590" /></span></div>
                </li>
                <li>
                    <div>
                        <img src="image/BO9212.png" /><br />
                        Java 程式設計學習教本</div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1007" class="scbutton">加入購物車<input type="hidden" value="Java 程式設計學習教本：BO9212.png：520" /></span></div>
                </li>
                <li>
                    <div>
                        <img src="image/BO9213.jpg" /><br />
                        Visual Basic 2008 程式設計學習教本</div>
                    <div>
                        定價：520</div>
                    <div>
                        <span id="KT1008" class="scbutton">加入購物車<input type="hidden" value="Visual Basic 2008 程式設計學習教本：BO9213.jpg：520" /></span></div>
                </li>
            </ul>
        </div>
        <div>
        </div>
    </div>
</body>
</html>
