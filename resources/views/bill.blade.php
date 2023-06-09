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
    </style>

</head>
<body>
    <div>
        <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">账单</div>
        <div style="height: 20px;width: 100%"></div>
        <div style="height: 40px;text-align: left">
            <button id="button_last_day" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openLastDay()">前一天</button>
            <button id="button_today" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openToday()">当天</button>
        </div>
        <div style="height: 20px;width: 100%"></div>

        <div id="div_table" style="height: calc(100vh - 200px);width: 100%;overflow-y: auto">
            <table id="bill_equal_table"></table>
            <div style="height: 60px;width: 100%;"></div>
        </div>

        <div class="row" style="position: absolute;bottom: 0;height: 60px;width: 100%;z-index: 99">
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/') }}'">点餐</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/purchase') }}'">采购</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/bill') }}'">账单</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/personal') }}'">我的</div>
        </div>
    </div>

    <script>
        //存放日期信息
        function DateInfo(){}
        DateInfo.prototype.Date = 'today';
        let dateInfo = new DateInfo();

        //初始化菜品列表
        function getBillEqualTable() {
            $('#bill_equal_table').bootstrapTable('destroy');
            let tableSettings = {
                url:"{{ URL::to('/get_bill_equal') }}",
                pagination: "false",//开启分页
                method: 'post',
                pageSize: 10000,//每页大小
                pageList: [12, 20, 50,100,500,1500],
                pageNumber: 1,
                rowHeights:20,
                striped: true,
                // sortName:"Dish_Cate",
                sortable: false,//是否启用排序
                // sortOrder:"ASC",//排序方式
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
                        "rows":_responseJson.data.bill_equal_info
                    }
                },
                columns: [
                    {
                        field: 'Bill_Equal_ID',
                        title: 'ID',
                        // sorter:'customSort',
                    }, {
                        field: 'Bill_Equal_DeskID',
                        title: 'DeskID',
                        sortable: true,
                        // sorter:'customSort',
                    }, {
                        field: 'Bill_Equal_DeskName',
                        title: '桌号',
                        // sorter:'customSort',
                    },{
                        field: 'Bill_Equal_Sale',
                        title: '消费金额',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'Bill_Equal_Value',
                        title: 'Value',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'Bill_Value',
                        title: '状态',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'Bill_Equal_Date',
                        title: '时间',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'oprator',
                        title: '操作',
                        align: 'center',
                        valign: 'middle',
                        // width: '200',
                        events: {
                            'click #bill_equal_edit':function (e,value, row, index) {
                                // console.log(row)
                                layer.confirm('请选择需要进行的操作', {
                                    btn: ['加单','结单'] //按钮
                                }, function(){
                                    // layer.msg('加单');
                                    window.open("{{ URL::to('/order_again') }}" + "?desk=" + row.Bill_Equal_DeskID + "&bill=" + row.Bill_Equal_ID);
                                    window.location.reload();
                                }, function(){
                                    layer.msg('结单')
                                });
                            },
                            'click #bill_equal_delete':function (e,value, row, index) {
                                layer.confirm('确认删除？', {
                                    btn: ['取消','确认'] //按钮
                                }, function(){
                                    layer.msg('已取消');
                                    // console.log("已取消");
                                }, function(){
                                    let _formData = new FormData;
                                    _formData.append('_token', "{{ csrf_token() }}");
                                    _formData.append('Bill_Equal_ID',row.Bill_Equal_ID);

                                    fetch("/delete_bill", {method: 'post', body: _formData}).then(function (_res) {
                                        return _res.json();
                                    }).then(function (_resJson) {
                                        console.log(_resJson);
                                        if (_resJson.status == "success"){
                                            layer.msg("删除成功！页面将自动刷新！", {
                                                zIndex:10000,
                                                time: 2000,
                                                end: function () {
                                                    window.location.reload();
                                                }
                                            })
                                        }else {
                                            layer.msg("出错了！错误原因：" + _resJson.message);
                                        }
                                    })
                                });
                            }
                        },
                        formatter: function (value, row, index) {
                            let result = "";
                            if (row.Bill_Equal_Value == 0){
                                result += '<button id="bill_equal_edit" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">编辑</button>';
                            }
                            result += '<button id="bill_equal_delete" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">删除</button>';
                            return result;
                        }
                    }],}
            $("#bill_equal_table").bootstrapTable(tableSettings);
            $("#bill_equal_table").bootstrapTable('hideColumn', 'Bill_Equal_ID');
            $("#bill_equal_table").bootstrapTable('hideColumn', 'Bill_Equal_DeskID');
            $("#bill_equal_table").bootstrapTable('hideColumn', 'Bill_Equal_Value');
            $('#bill_equal_table').bootstrapTable('togglePagination');
        }
        getBillEqualTable()

        function openLastDay() {
            if (dateInfo.Date == 'today'){
                dateInfo.Date = '-1';
            }else {
                dateInfo.Date--;
            }
            getBillEqualTable()
        }
        function openToday() {
            dateInfo.Date = 'today';
            getBillEqualTable()
        }
    </script>
</body>
</html>
