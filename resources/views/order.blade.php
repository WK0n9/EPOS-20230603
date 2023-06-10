<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width,user-scalable=0,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Index</title>
    <link rel="stylesheet" href="{{ asset('./css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('./bootstrap-table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/JqueryUI/jquery-ui.min.css') }}">
    <script src="{{ asset('./js/jquery.js') }}"></script>
    <script src="{{ asset('./js/popper.min.js') }}"></script>
    <script src="{{ asset('./js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('./js/jetpl.js') }}"></script>
    <script src = "{{ asset('./js/layer/layer.js') }}" ></script>
    <script src="{{ asset('./js/bootstrap-table.min.js') }}"></script>
    <script src = "{{ asset('./js/jquery-ui.min.js') }}" ></script>
    <style>
        body{
            margin: 0 auto;
            padding: 0;
        }
        .row{
            --bs-gutter-x: 0px;
            --bs-gutter-y: 0px;
            display: flex;
            flex-wrap: wrap;
            margin-top: 0;
            margin-right: 0;
            margin-left: 0;
        }
        .container-fluid, .container-lg, .container-md, .container-sm, .container-xl{
            --bs-gutter-x: 0;
            padding-right: 0;
            padding-left: 0;
        }
        .container {
            max-width: 1300px;
        }
        /* 隐藏 Chrome、Safari 和 Opera 的滚动条 */
        #Cate::-webkit-scrollbar {
            display: none;
        }
        #Dish::-webkit-scrollbar {
            display: none;
        }
        /* 隐藏 IE、Edge 和 Firefox 的滚动条 */
        #Cate {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        #Dish {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        /*平滑滚动条*/
        #Cate {
            scroll-behavior: smooth;
        }
        #Dish {
            scroll-behavior: smooth;
        }
        .btn-outline-secondary {
            padding: 0;
            height: 30px;
            width: 30px;
            /*border-radius: 15px;*/
        }
        .btn-flow {
            position: absolute;
            right: 20px;
            padding: 0;
            height: 60px;
            width: 60px;
            background-color: #5ab8cc;
            border-radius: 30px;
            line-height: 60px;
            text-align: center;
            font-size: 15px;
            color: white;
            z-index: 99;
        }
        .form-control {
            height: 30px;
        }
        .mb-3, .my-3 {
            margin-bottom: 0!important;
        }
    </style>

</head>
<body>
{{--    已点列表--}}
    <div class="modal fade" tabindex="-1" id="ydModal">
        <div class="modal-dialog" style="width: 97%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">已点</h5>
                </div>
                <div class="modal-body" style="height: calc(90vh - 200px);overflow-y: auto">
                    <div id="yd_div"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeYidian()">关闭</button>
                    <button type="button" class="btn btn-primary" id="ydButton" onclick="confirmDish()">提交</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">下单</div>
        <div id="Desk_ID" style="padding-left: 15px;height: 30px;width: 100%;line-height: 30px">桌号：</div>
        <div class="row" style="height: calc(100vh - 90px)">
            <div id="Cate" class="col-2" style="width: 100%;height: 100%;background-color: #e5e5e5;overflow-y: auto;padding: 0 5px 0 5px">
{{--                <div style="margin: 0;border-bottom-color: #ededed;border-bottom-style: solid;height: 50px;line-height: 50px;text-align: center">--}}
{{--                    <a href="#dish_1">小食</a>--}}
{{--                </div>--}}
            </div>
            <div id="Dish" class="col-10" style="width: 100%;height: 100%;overflow-y: auto;padding: 0 5px 180px 5px">
{{--                <div class="row" id="dish_1" style="margin: 10px 0 10px 0;padding: 10px;height: 60px;background-color: #e8e8e8;border-radius: 10px">--}}
{{--                    <div class="col-6" style="line-height: 40px;font-size: 18px">松鼠鳜鱼</div>--}}
{{--                    <div class="col-6" style="padding: 5px 0 5px 0">--}}
{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <button class="btn btn-outline-secondary bt_1" type="button" data-put="mo" data-input="1" onclick="putDishNum(this)">-1</button>--}}
{{--                                <button class="btn btn-outline-secondary bt_1" type="button" data-put="mpf" data-input="1" onclick="putDishNum(this)">-0.5</button>--}}
{{--                            </div>--}}
{{--                            <input type="text" class="form-control fc_1" value="0">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <button class="btn btn-outline-secondary bt_1" type="button" data-put="ppf" data-input="1" onclick="putDishNum(this)">0.5</button>--}}
{{--                                <button class="btn btn-outline-secondary bt_1" type="button" data-put="po" data-input="1" onclick="putDishNum(this)">+1</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row" id="dish_1" style="margin: 10px 0 10px 0;padding: 10px;height: 60px;background-color: #e8e8e8;border-radius: 10px">--}}
{{--                    <div class="col-6" style="line-height: 40px;font-size: 18px">松鼠鳜鱼</div>--}}
{{--                    <div class="col-6" style="line-height: 40px">--}}
{{--                        数量：3--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <button type="button" class="btn btn-info btn-flow" style="bottom: 100px" onclick="openYidian()">已点</button>
        <button type="button" class="btn btn-info btn-flow" style="bottom: 20px" onclick="confirmDish()">提交</button>
    </div>

{{--    菜品模板--}}
    <script type="text/html" id="dish-template">
        {% for(let i=0 ; i<list.length; i++){ %}
        <div class="row dish_list" id="{%= 'dish_' + list[i].Dish_ID %}" style="margin: 10px 0 10px 0;padding: 10px;height: 70px;background-color: #e8e8e8;border-radius: 10px">
            <div class="col-5 dish_head" style="padding: 0;line-height: 40px;font-size: 16px" data-id="{%= list[i].Dish_ID %}">{%= list[i].Dish_Name %}</div>
            <div class="col-7" style="padding: 5px 0 5px 0">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="{%= 'btn btn-outline-secondary bt_' + list[i].Dish_ID %}" type="button" data-put="mo" data-input="{%= list[i].Dish_ID %}" onclick="putDishNum(this)">-</button>
                        <button class="{%= 'btn btn-outline-secondary bt_' + list[i].Dish_ID %}" type="button" data-put="mpf" data-input="{%= list[i].Dish_ID %}" onclick="putDishNum(this)">0.5</button>
                    </div>
                    <input type="text" class="{%= 'form-control fc_' + list[i].Dish_ID %}" value="0" data-sale="{%= list[i].Dish_Sale %}">
                    <div class="input-group-append">
                        <button class="{%= 'btn btn-outline-secondary bt_' + list[i].Dish_ID %}" type="button" data-put="ppf" data-input="{%= list[i].Dish_ID %}" onclick="putDishNum(this)">0.5</button>
                        <button class="{%= 'btn btn-outline-secondary bt_' + list[i].Dish_ID %}" type="button" data-put="po" data-input="{%= list[i].Dish_ID %}" onclick="putDishNum(this)">+</button>
                    </div>
                </div>
            </div>
            <div class="col-4" style="padding: 0;height: 10px;line-height: 10px;font-size: 10px;color: gray">价格：{%= list[i].Dish_Sale %}</div>
{{--            <div class="col-4" style="padding: 0;height: 10px;line-height: 10px;font-size: 10px;color: gray">库存：{%= list[i].Dish_Stock %}</div>--}}
            <div class="col-4" style="padding: 0;height: 10px;line-height: 10px;font-size: 10px;color: gray">已售：{%= list[i].Dish_Num %}</div>
        </div>
        {% } %}
    </script>

{{--    菜品预览模板--}}
    <script type="text/html" id="dish-yd-template">
        {% for(let i=0 ; i<list.length; i++){ %}
        <div class="row dish_yd_list" id="{%= 'dish_yd_' + list[i].Dish_ID %}" style="margin: 10px 0 10px 0;padding: 10px;height: 60px;background-color: #e8e8e8;border-radius: 10px">
            <div class="col-6" style="padding: 0;line-height: 40px;font-size: 16px">{%= list[i].Dish_Name %}</div>
            <div class="col-6" style="padding: 0;line-height: 40px">数量：{%= list[i].Dish_Num %}</div>
        </div>
        {% } %}
    </script>

    <script>
        //解析get传值
        function getQueryString(name) {
            let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            let reg_rewrite = new RegExp("(^|/)" + name + "/([^/]*)(/|$)", "i");
            let r = window.location.search.substr(1).match(reg);
            let q = window.location.pathname.substr(1).match(reg_rewrite);
            if(r != null){
                return unescape(r[2]);
            }else if(q != null){
                return unescape(q[2]);
            }else{
                return null;
            }
        }

        //初始化页面
        function freshPage() {
            let desk_id = getQueryString('desk');
            let _formData = new FormData;
            _formData.append("_token", "{{ csrf_token() }}");
            fetch("{{ URL::to('/epos/get_order') }}", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                document.getElementById("Desk_ID").innerHTML += (desk_id + "-" + _resJson.data.desk_info[desk_id - 1].Desk_Name);
                let gethtml = document.getElementById('dish-template').innerHTML;
                jetpl(gethtml).render({list:_resJson.data.dish_info}, function(html){
                    $('#Dish').html(html);
                });
                getCateInfo(_resJson.data)
            })
        }

        //写入分类
        function getCateInfo(_resJson) {
            let dom = document.getElementById('Cate');
            if(dom.children.length == 0) {
                for (let i = 0; i < _resJson.cate_info.length; i++) {
                    let div = document.createElement('div');
                    div.style.margin = '0';
                    div.style.borderBottomColor = '#ededed';
                    div.style.borderBottomStyle = 'solid';
                    div.style.height = '50px';
                    div.style.lineHeight = '50px';
                    div.style.textAlign = 'center';
                    div.id = 'Cate-' + i;
                    dom.append(div);
                    let dom1 = document.getElementById('Cate-' + i);
                    let a = document.createElement('a');
                    for (let j = 0;j < _resJson.dish_info.length;j++){
                        if (_resJson.cate_info[i].Cate_ID == _resJson.dish_info[j].Dish_Cate){
                            a.href = '#dish_' + _resJson.dish_info[j].Dish_ID;
                            break;
                        }
                    }
                    a.innerHTML = _resJson.cate_info[i].Cate_Name;
                    dom1.append(a);
                }
            }
        }

        //控制点菜数量
        function putDishNum(dish) {
            let input_class = '.fc_' + dish.getAttribute('data-input')
            const inputBox = document.querySelector(input_class);
            if (dish.getAttribute('data-put') == 'mo') {
                let currentValue = parseFloat(inputBox.value);
                currentValue -= 1;
                if (currentValue < 0) {
                    currentValue = 0;
                }
                inputBox.value = currentValue;
            } else if (dish.getAttribute('data-put') == 'mpf') {
                let currentValue = parseFloat(inputBox.value);
                currentValue -= 0.5;
                if (currentValue < 0) {
                    currentValue = 0;
                }
                inputBox.value = currentValue;
            } else if (dish.getAttribute('data-put') == 'ppf') {
                let currentValue = parseFloat(inputBox.value);
                currentValue += 0.5;
                inputBox.value = currentValue;
            } else if (dish.getAttribute('data-put') == 'po') {
                let currentValue = parseFloat(inputBox.value);
                currentValue += 1;
                inputBox.value = currentValue;
            }
        }

        //初始化页面
        freshPage();

        //开启已点
        function openYidian(){
            $("#ydModal").on('show.bs.modal',function () {
                let dish_yd = [];
                // 获取所有菜品的样式
                const dishes = document.querySelectorAll('.dish_list');
                // 循环遍历每个菜品的样式
                for (let i = 0; i < dishes.length; i++) {
                    // 获取当前菜品的input元素
                    const input = dishes[i].querySelector('.form-control');
                    // 如果input元素的value属性不为0
                    if (input.value !== '0') {
                        const input_name = dishes[i].querySelector('.dish_head');
                        // 将当前菜品的数据插入到集合中
                        let dish_info = [];
                        dish_info.Dish_ID = input_name.getAttribute('data-id');
                        dish_info.Dish_Name = input_name.innerHTML;
                        dish_info.Dish_Num = input.value;
                        dish_yd.push(dish_info);
                    }
                }
                console.log(dish_yd)
                let gethtml = document.getElementById('dish-yd-template').innerHTML;
                jetpl(gethtml).render({list:dish_yd}, function(html){
                    $('#yd_div').html(html);
                });
                $('#ydModal').off('show.bs.modal');
            })
            $("#ydModal").modal('show');  //手动开启
        }

        //关闭已点
        function closeYidian(){
            $("#ydModal").on('hide.bs.modal',function () {
                $("#yd_div").empty();
            })
            $("#ydModal").modal('hide');  //手动关闭
        }

        //提交订单
        function confirmDish() {
            let Dish_Count = 0;
            let _formData = new FormData;
            //获取桌号
            let desk_id = getQueryString('desk');
            _formData.append("desk_id", desk_id);

            //获取账单总计
            let dish_equal = 0;

            //获取点单信息
            const dishes = document.querySelectorAll('.dish_list');
            for (let i = 0; i < dishes.length; i++) {
                const input = dishes[i].querySelector('.form-control');
                if (input.value !== '0') {
                    const input_name = dishes[i].querySelector('.dish_head');
                    _formData.append("dish_id_" + Dish_Count, input_name.getAttribute('data-id'));
                    _formData.append("dish_name_" + Dish_Count, input_name.innerHTML);
                    _formData.append("dish_num_" + Dish_Count, input.value);
                    _formData.append("dish_sale_" + Dish_Count, input.getAttribute('data-sale'));
                    _formData.append("dish_sale_equal_" + Dish_Count, input.getAttribute('data-sale') * input.value);
                    Dish_Count++;
                    dish_equal += input.getAttribute('data-sale') * input.value;
                }
            }
            _formData.append("dish_count", Dish_Count);
            _formData.append("dish_equal", dish_equal);
            _formData.append("_token", "{{ csrf_token() }}");
            fetch("{{ URL::to('/epos/add_order') }}", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    layer.msg("下单成功！页面将自动关闭！", {
                        zIndex:10000,
                        time: 2000,
                        end: function () {
                            window.close();
                        }
                    })
                    // window.location.reload();
                    // let pid = _resJson[0].id;
                }else {
                    layer.msg("下单失败！");
                }
            })
        }
    </script>
</body>
</html>
