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
        .btn-flow {
            position: absolute;
            left: 10px;
            top: 10px;
            padding: 0;
            height: 40px;
            width: 60px;
            background-color: #55b9ce;
            line-height: 40px;
            text-align: center;
            font-size: 15px;
            color: white;
            z-index: 999;
        }
    </style>

</head>
<body>
<div>
    <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;font-size: 25px;color: white">
        <button type="button" class="btn btn-info btn-flow" onclick="window.location.href = '{{ URL::to('/epos/personal') }}'">返回</button>
        <div class="row" style="display: flex;align-items: center;justify-content: center">江湖鱼坊-明细</div>
    </div>
    <div id="div_day" style="display: none">
        <div style="height: 20px;width: 100%;"></div>
        <button id="button_last_day" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openLastDay()">前一天</button>
        <button id="button_today" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openToday()">当天</button>
        <div style="height: 10px;width: 100%;"></div>
    </div>
    <table id="detail_table"></table>
    <div style="height: 160px;width: 100%;"></div>
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

    //存放日期信息
    function DateInfo(){}
    DateInfo.prototype.Date = 'today';
    let dateInfo = new DateInfo();

    function switchMode() {
        let mode = getQueryString('info')
        if (mode == '1') {
            getTodayIncomeTable()
        }else if (mode == '2') {
            getTodayDishTable()
        }else if (mode == '3') {
            getAllIncomeTable()
        }else if (mode == '4') {
            getAllDishTable()
        }else if (mode == '5') {
            getAllItemTable()
        }
    }
    switchMode()

    //查看前一天
    function openLastDay() {
        if (dateInfo.Date == 'today'){
            dateInfo.Date = '-1';
        }else {
            dateInfo.Date--;
        }
        let mode = getQueryString('info')
        if (mode == '1') {
            getTodayIncomeTable()
        }else if (mode == '2') {
            getTodayDishTable()
        }
    }
    //查看当天
    function openToday() {
        dateInfo.Date = 'today';
        let mode = getQueryString('info')
        if (mode == '1') {
            getTodayIncomeTable()
        }else if (mode == '2') {
            getTodayDishTable()
        }
    }

    function getTodayIncomeTable() {
        document.getElementById("div_day").style.display = "";
        $('#detail_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_today_income') }}",
            pagination: "false",//开启分页
            method: 'post',
            pageSize: 10000,//每页大小
            pageList: [12, 20, 50,100,500,1500],
            pageNumber: 1,
            rowHeights:20,
            striped: true,
            sortName:"Bill_Equal_Date",
            sortable: true,//是否启用排序
            sortOrder:"ASC",//排序方式
            showFooter: true,//开启页脚
            queryParamsType :'',
            //设置请求参数
            queryParams:function(){
                let tem= {
                    _token:"{{ csrf_token() }}",
                    bill_date:dateInfo.Date
                };
                return tem;
            },
            responseHandler:function(_responseJson){
                return {
                    // "total":_responseJson.total,
                    "rows":_responseJson.data
                }
            },
            columns: [
                {
                    field: 'Bill_Equal_ID',
                    title: 'ID',
                    // sorter:'customSort',

                }, {
                    field: 'Desk_Name',
                    title: '桌号',
                    // sortable: true,
                    footerFormatter: function (value) {
                        return '合计';
                    },
                    // sorter:'customSort',
                }, {
                    field: 'Bill_Equal_Date',
                    title: '时间',
                    sortable: true,
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale',
                    title: '应收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale_Real',
                    title: '实收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale_Real);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                }],}
        $("#detail_table").bootstrapTable(tableSettings);
        $("#detail_table").bootstrapTable('hideColumn', 'Bill_Equal_ID');
        $("#detail_table").bootstrapTable('togglePagination');
    }
    function getTodayDishTable() {
        document.getElementById("div_day").style.display = "";
        $('#detail_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_today_dish') }}",
            pagination: "false",//开启分页
            method: 'post',
            pageSize: 10000,//每页大小
            pageList: [12, 20, 50,100,500,1500],
            pageNumber: 1,
            rowHeights:20,
            striped: true,
            sortName:"Bill_Date",
            sortable: true,//是否启用排序
            sortOrder:"ASC",//排序方式
            showFooter: true,//开启页脚
            queryParamsType :'',
            //设置请求参数
            queryParams:function(){
                let tem= {
                    _token:"{{ csrf_token() }}",
                    bill_date:dateInfo.Date
                };
                return tem;
            },
            responseHandler:function(_responseJson){
                return {
                    // "total":_responseJson.total,
                    "rows":_responseJson.data
                }
            },
            columns: [
                {
                    field: 'Bill_Date',
                    title: '时间',
                    footerFormatter: function (value) {
                        return '合计';
                    },
                    // sorter:'customSort',
                }, {
                    field: 'Bill_Desk_ID',
                    title: 'ID',
                    sortable: true,
                    // sorter:'customSort',
                }, {
                    field: 'Desk_Name',
                    title: '桌号',
                    // sortable: true,
                    // sorter:'customSort',
                },{
                    field: 'Bill_DishCost',
                    title: '成本',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_DishCost);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale_Real',
                    title: '实收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale_Real);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                }],}
        $("#detail_table").bootstrapTable(tableSettings);
        $("#detail_table").bootstrapTable('hideColumn', 'Bill_Desk_ID');
        $("#detail_table").bootstrapTable('togglePagination');
    }
    function getAllIncomeTable() {
        document.getElementById("div_day").style.display = "none";
        $('#detail_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_all_income') }}",
            pagination: "false",//开启分页
            method: 'post',
            pageSize: 10000,//每页大小
            pageList: [12, 20, 50,100,500,1500],
            pageNumber: 1,
            rowHeights:20,
            striped: true,
            sortName:"Bill_Equal_Date",
            sortable: true,//是否启用排序
            sortOrder:"DESC",//排序方式
            showFooter: true,//开启页脚
            queryParamsType :'',
            //设置请求参数
            queryParams:function(){
                let tem= {
                    _token:"{{ csrf_token() }}",
                };
                return tem;
            },
            responseHandler:function(_responseJson){
                return {
                    // "total":_responseJson.total,
                    "rows":_responseJson.data
                }
            },
            columns: [
                {
                    field: 'Bill_Equal_Date',
                    title: '日期',
                    sortable: true,
                    footerFormatter: function (value) {
                        return '合计';
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale',
                    title: '应收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale_Real',
                    title: '实收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale_Real);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                }],}
        $("#detail_table").bootstrapTable(tableSettings);
        $("#detail_table").bootstrapTable('togglePagination');
    }
    function getAllDishTable() {
        document.getElementById("div_day").style.display = "none";
        $('#detail_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_all_dish') }}",
            pagination: "false",//开启分页
            method: 'post',
            pageSize: 10000,//每页大小
            pageList: [12, 20, 50,100,500,1500],
            pageNumber: 1,
            rowHeights:20,
            striped: true,
            sortName:"Bill_Date",
            sortable: true,//是否启用排序
            sortOrder:"DESC",//排序方式
            showFooter: true,//开启页脚
            queryParamsType :'',
            //设置请求参数
            queryParams:function(){
                let tem= {
                    _token:"{{ csrf_token() }}",
                };
                return tem;
            },
            responseHandler:function(_responseJson){
                return {
                    // "total":_responseJson.total,
                    "rows":_responseJson.data
                }
            },
            columns: [
                {
                    field: 'Bill_Date',
                    title: '日期',
                    sortable: true,
                    footerFormatter: function (value) {
                        return '合计';
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_DishCost',
                    title: '成本',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_DishCost);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                },{
                    field: 'Bill_Equal_Sale_Real',
                    title: '实收',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Bill_Equal_Sale_Real);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                }],}
        $("#detail_table").bootstrapTable(tableSettings);
        $("#detail_table").bootstrapTable('togglePagination');
    }
    function getAllItemTable() {
        document.getElementById("div_day").style.display = "none";
        $('#detail_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_all_item') }}",
            pagination: "false",//开启分页
            method: 'post',
            pageSize: 10000,//每页大小
            pageList: [12, 20, 50,100,500,1500],
            pageNumber: 1,
            rowHeights:20,
            striped: true,
            sortName:"Item_Date",
            sortable: true,//是否启用排序
            sortOrder:"DESC",//排序方式
            showFooter: true,//开启页脚
            queryParamsType :'',
            //设置请求参数
            queryParams:function(){
                let tem= {
                    _token:"{{ csrf_token() }}",
                };
                return tem;
            },
            responseHandler:function(_responseJson){
                return {
                    // "total":_responseJson.total,
                    "rows":_responseJson.data
                }
            },
            columns: [
                {
                    field: 'Item_Date',
                    title: '日期',
                    sortable: true,
                    footerFormatter: function (value) {
                        return '合计';
                    },
                    // sorter:'customSort',
                },{
                    field: 'Item_Cost',
                    title: '支出',
                    sortable: true,
                    footerFormatter: function (value) {
                        let count = 0;
                        for (let i in value) {
                            count += parseInt(value[i].Item_Cost);
                        }
                        return count;
                    },
                    // sorter:'customSort',
                }],}
        $("#detail_table").bootstrapTable(tableSettings);
        $("#detail_table").bootstrapTable('togglePagination');
    }
</script>
</body>
</html>
