<!DOCTYPE html >
<html>
<head>
    <title>更新購物車</title>
    <meta charset="utf-8">
    <style>
        div#msection
        {
            margin: 0 auto;
            width: 900px;
        }
        h2
        {
            font-weight: 800;
        }
        input.quantity
        {
            width: 60px;
        }
        tr.item
        {
            border-bottom: 1px dotted #AAA;
        }
        table
        {
            border-collapse: collapse;
        }
        td
        {
            margin: 0px;
            padding: 1px 10px 4px 10px;
            border-bottom: 1px dotted #e1eafe;
            text-align: left;
            vertical-align: top;
        }
        p#title
        {
            height: 26px;
            font-size: medium;
            font-weight: 600;
        }
        p.price, p.price_off
        {
            color: Maroon;
        }
        p.price_off
        {
            font-weight: 800;
        }        
        div#listtitle
        {
            font-size: medium;
            font-weight: 800;
            border-bottom: 1px solid #AAA;
        }
        #subtotal, div.subtotalsection
        {
            font-size: medium;
            font-weight: 600;
            color: Maroon;
        }
        div.subtotalsection
        {
            text-align: right;
            margin-top: 10px;
            margin-right: 40px;
        }
    </style>
    <script>
        var newitem;
        var newitemtable;
        window.onload = function () {
            var total = 0;
            var itemstring = sessionStorage['additemlist'];
            var items = itemstring.substr(0, itemstring.length - 1).split(',');
            newitem = document.createElement('div');
            //newitem.setAttribute('class', 'item');
            newitemtable = document.createElement('table');
            for (var key in items) {
                var iteminfo = sessionStorage[items[key]];
                createCartlist(iteminfo, items[key]);
            }
            subtotal();
        }
        function createCartlist(iteminfo, itemkey) {
            var total = 0;
            var itemtitle = iteminfo.split('：')[0]
            var imgurl = iteminfo.split('：')[1];
            var price = parseInt(iteminfo.split('：')[2]);
            total += price;

            //建立商品清單區
            var trx = document.createElement('tr');
            trx.setAttribute('class', 'item');
            newitemtable.appendChild(trx);
            //商品圖片
            var tdx_imgurl = document.createElement('td');
            tdx_imgurl.style.width = '120px';
            var bookimg = document.createElement('img');
            bookimg.setAttribute('src', 'image/' + imgurl);
            bookimg.width = 60;
            tdx_imgurl.appendChild(bookimg);
            trx.appendChild(tdx_imgurl);
            //商品名稱與刪除按鈕
            var tdx_title = document.createElement('td');
            tdx_title.style.width = '360px';
            tdx_title.setAttribute('id', itemkey);
            var p_title = document.createElement('p');
            p_title.innerHTML = itemtitle
            tdx_title.appendChild(p_title);

            var button = document.createElement('button');
            button.innerHTML = '刪除';
            button.onclick = deleteHandler;
            tdx_title.appendChild(button);
            trx.appendChild(tdx_title);
            //小計
            var tdx_price = document.createElement('td');
            tdx_price.style.width = '170px';
            tdx_price.innerHTML = price;
            trx.appendChild(tdx_price);
            //項目數量
            var tdx_item_count = document.createElement('td');
            tdx_item_count.style.width = '60px';
            var item_count = document.createElement('input');
            item_count.type = 'text';
            item_count.size = 4;
            item_count.value = 1;
            item_count.setAttribute('sprice', price);
            item_count.oninput = inputHandler;
            tdx_item_count.appendChild(item_count);
            trx.appendChild(tdx_item_count);
            newitem.appendChild(newitemtable);
            document.getElementById('cartlist').appendChild(newitem);
        }
        function inputHandler(event) {
            subtotal();
        }
        function deleteHandler() {
            var item_title = this.parentNode.getAttribute('id');
            sessionStorage['additemlist'] =
                    sessionStorage['additemlist'].replace(item_title + ',', '');
            this.parentNode.parentNode.parentNode.removeChild(
                    this.parentNode.parentNode);
            if (window.event) {
                event.cancelBubble = true;
            } else {
                event.stopPropagation();
            }
            subtotal();
        }
        function subtotal() {
            try {
                var subtotal = 0;
                var items = document.getElementsByTagName('input');
                for (var key in items) {
                    if (items[key].type == 'text') {
                        subtotal += (parseInt(items[key].getAttribute('sprice')) *
                                            parseInt(items[key].value));
                    }
                }
                document.getElementById('subtotal').value = subtotal;
            } catch (ex) {
                alert(ex);
            }
        }
    </script>
</head>
<body>
    <div id="msection">
        <h2>
            購物車</h2>
        <div id="cartlist">
            <div id="listtitle">
                <table>
                    <tr class="itemhead">
                        <td style="width: 120px;">
                            項目清單
                        </td>
                        <td style="width: 360px;">
                        </td>
                        <td style="width: 170px;">
                            價格
                        </td>
                        <td style="width: 60px;">
                            數量
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="subtotalsection">
            小計：<output id="subtotal">0</output></div>
    </div>
</body>
</html>
