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
        .button_bottom {
            background-color: #5ab8cc;
            line-height: 60px;
            font-size: 18px;
            color: white;
            text-align: center;
            cursor: pointer;
        }
        .button_bottom:hover {
            background-color: #418595;
        }
        .row_line {
            /*height: 50px;*/
            line-height: 50px;
            font-size: 25px;
            text-align: left;
        }
    </style>

</head>
<body>
    <div>
        <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">EPOS-我的</div>
        <div id="Desk_ID" style="height: calc(100vh - 120px);width: 100%;overflow-y: auto">
            <div class="row">
                <div class="col-8 row_line" style="">今日总流水(应收)</div>
                <div id="today-income" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">今日总流水(实收)</div>
                <div id="today-income-real" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">今日菜品成本</div>
                <div id="today-cost" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">今日净收入</div>
                <div id="today-profit" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">昨日总流水(应收)</div>
                <div id="last-income" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">昨日总流水(实收)</div>
                <div id="last-income-real" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">昨日菜品成本</div>
                <div id="last-cost" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">昨日净收入</div>
                <div id="last-profit" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">总计流水(应收)</div>
                <div id="all-income" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">总计流水(实收)</div>
                <div id="all-income-real" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">总计菜品成本</div>
                <div id="all-cost" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">总计净收入</div>
                <div id="all-profit" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 30px;width: 100%"></div>
            <div class="row">
                <div class="col-8 row_line" style="">总计进货支出</div>
                <div id="all-item" class="col-4 row_line" style=""></div>
            </div>
            <div class="row">
                <div class="col-8 row_line" style="">总计支出/收入差</div>
                <div id="all-real-profit" class="col-4 row_line" style=""></div>
            </div>
            <div style="height: 60px;width: 100%;"></div>
        </div>
        <div class="row" style="position: absolute;bottom: 0;height: 60px;width: 100%;z-index: 99">
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/') }}'">点餐</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/purchase') }}'">采购</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/bill') }}'">账单</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/personal') }}'">我的</div>
        </div>
    </div>

    <script>
        //有这样一中情形：假如存为书签的话，不能按照token获取用户数据，解决办法如下
        let _token = localStorage.getItem("_token");
        if(_token == null || _token == undefined || _token == "undefined")
        {
            window.location.href = "{{ URL::to('/epos/login') }}";
        }
        pwd = _token;
        pid = localStorage.getItem("ddid");
        cate = localStorage.getItem("cate");
        console.log(pid);
        console.log(pwd);

        function calcIncome() {
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            fetch("/epos/calc_income", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    console.log(_resJson.data)
                    document.getElementById('today-income').innerHTML = _resJson.data.today_income_info[0].Bill_Equal_Sale;
                    document.getElementById('today-income-real').innerHTML = _resJson.data.today_income_info[0].Bill_Equal_Sale_Real
                    document.getElementById('last-income').innerHTML = _resJson.data.last_day_income_info[0].Bill_Equal_Sale;
                    document.getElementById('last-income-real').innerHTML = _resJson.data.last_day_income_info[0].Bill_Equal_Sale_Real;
                    document.getElementById('all-income').innerHTML = _resJson.data.all_income_info[0].Bill_Equal_Sale;
                    document.getElementById('all-income-real').innerHTML = _resJson.data.all_income_info[0].Bill_Equal_Sale_Real;
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
        }
        function calcCost() {
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            fetch("/epos/calc_cost", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    console.log(_resJson.data)
                    document.getElementById('today-cost').innerHTML = _resJson.data.today_cost_info[0].Total_Dish_Cost;
                    document.getElementById('last-cost').innerHTML = _resJson.data.last_day_cost_info[0].Total_Dish_Cost;
                    document.getElementById('all-cost').innerHTML = _resJson.data.all_cost_info[0].Total_Dish_Cost;
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
        }
        function calcItem() {
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            fetch("/epos/calc_item", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    console.log(_resJson.data)
                    document.getElementById('all-item').innerHTML = _resJson.data.item_info[0].Item_Cost;
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
        }
        function calcProfit() {
            let today_income = document.getElementById('today-income-real').innerHTML;
            let last_income = document.getElementById('last-income-real').innerHTML;
            let all_income = document.getElementById('all-income-real').innerHTML;

            let today_cost = document.getElementById('today-cost').innerHTML;
            let last_cost = document.getElementById('last-cost').innerHTML;
            let all_cost = document.getElementById('all-cost').innerHTML;

            let all_item = document.getElementById('all-item').innerHTML;

            document.getElementById('today-profit').innerHTML = today_income - today_cost;
            document.getElementById('last-profit').innerHTML = last_income - last_cost;
            document.getElementById('all-profit').innerHTML = all_income - all_cost;
            document.getElementById('all-real-profit').innerHTML = all_income - all_item;
        }
        setTimeout(calcIncome, 1000);
        setTimeout(calcCost, 2000);
        setTimeout(calcItem, 3000);
        setTimeout(calcProfit, 4000);
    </script>
</body>
</html>
