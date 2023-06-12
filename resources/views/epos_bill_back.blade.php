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
{{--    结单界面--}}
<div class="modal fade" tabindex="-1" id="finishModal">
    <div class="modal-dialog" style="width: 97%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">详情</h5>
            </div>
            <div class="modal-body" style="">
                <div id="finish_div" style="font-size: 14px;height: calc(90vh - 200px);overflow-y: auto"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeFinish()">关闭</button>
                <button type="button" class="btn btn-success">打印</button>
{{--                <button type="button" class="btn btn-info" onclick="addDish()">加单</button>--}}
{{--                <button type="button" class="btn btn-danger" id="ydButton" onclick="confirmFinish()">结单</button>--}}
            </div>
        </div>
    </div>
</div>

<div>
    <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">江湖鱼坊-后厨</div>
    <div style="height: 20px;width: 100%"></div>
    <div style="height: 40px;text-align: left">
        <button id="button_last_day" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openLastDay()">前一天</button>
        <button id="button_today" type="button" class="btn btn-info" style="margin-left: 20px" onclick="openToday()">当天</button>
    </div>
    <div style="height: 20px;width: 100%"></div>

    <div id="div_table" style="height: calc(100vh - 140px);width: 100%;overflow-y: auto">
        <table id="bill_equal_table"></table>
        <div style="height: 60px;width: 100%;"></div>
    </div>
</div>

<script type="text/html" id="finish-template">
    <div id="get_id" style="text-align: left;padding-left: 0;" data-id="{%= list[0].Desk_ID %}" data-eid="{%= list[0].Bill_Equal_ID %}">桌号：{%= list[0].Desk_Name %}</div>
    <div style="text-align: left;padding-left: 0;">时间：{%= list[0].Bill_Equal_Date %}</div>
    <div style="height: 8px;width: 100%;border-bottom:1px dashed #000;"></div>
    <div class="row" style="padding: 7px 0 10px 0">
        <div class="col-4" style="text-align: left;padding-left: 0;padding-right: 10px">菜品</div>
        <div class="col-2" style="text-align: center;padding-left: 0;padding-right: 10px">数量</div>
        <div class="col-3" style="text-align: center;padding-left: 0;padding-right: 10px">单价</div>
        <div class="col-3" style="text-align: center;padding-left: 0;padding-right: 10px">总价</div>
    </div>
    {% for(let i=0 ; i<list.length; i++){ %}
    <div class="row">
        <div class="col-4" style="text-align: left;padding-left: 0;padding-right: 10px">{%= list[i].Bill_DishName %}</div>
        <div class="col-2" style="text-align: center;padding-left: 0;padding-right: 10px">{%= list[i].Bill_DishNum %}</div>
        <div class="col-3" style="text-align: center;padding-left: 0;padding-right: 10px">{%= list[i].Bill_DishSale %}</div>
        <div class="col-3" style="text-align: center;padding-left: 0;padding-right: 10px">{%= list[i].Bill_DishSaleEqual %}</div>
    </div>
    {% } %}
    <div style="height: 8px;width: 100%;border-bottom:1px dashed #000;"></div>
    <div class="row" style="padding-top: 7px;">
        <div class="col-4" style="text-align: left;padding-left: 0;padding-right: 10px">总金额</div>
        <div class="col-5"></div>
        <div class="col-3" id="plan-finish" style="text-align: center;padding-left: 0;padding-right: 10px">{%= list[0].Bill_Equal_Sale %}</div>
    </div>
    <div class="row">
        <div class="col-4" style="text-align: left;padding-left: 0;padding-right: 10px">实收金额</div>
        <div class="col-5"></div>
        <div class="col-3" id="real-finish" style="text-align: center;padding-left: 0;padding-right: 10px" data-id="{%= list[0].Bill_Equal_ID %}">{%= list[0].Bill_Equal_Sale %}</div>
    </div>
</script>

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

    //存放日期信息
    function DateInfo(){}
    DateInfo.prototype.Date = 'today';
    let dateInfo = new DateInfo();

    //初始化菜品列表
    function getBillEqualTable() {
        $('#bill_equal_table').bootstrapTable('destroy');
        let tableSettings = {
            url:"{{ URL::to('/epos/get_bill_equal') }}",
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
            // onClickRow:function(row, $element, field)
            // {
            //     console.log(row);
            // },
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
                                window.open("{{ URL::to('/epos/order_again') }}" + "?desk=" + row.Bill_Equal_DeskID + "&bill=" + row.Bill_Equal_ID);
                                window.location.reload();
                            }, function(){
                                // layer.msg('结单')
                                openFinish(row.Bill_Equal_ID);
                            });
                        },
                        'click #bill_equal_detail':function (e,value, row, index) {
                            // console.log(row)
                            openDetail(row.Bill_Equal_ID,row.Bill_Equal_DeskID);
                        },
                        'click #bill_equal_print':function (e,value, row, index) {
                            // console.log(row)
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

                                fetch("/epos/delete_bill", {method: 'post', body: _formData}).then(function (_res) {
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
                        if (row.Bill_Equal_Value != 0){
                            // result += '<button id="bill_equal_edit" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">编辑</button>';
                            result += '<button id="bill_equal_detail" class="btn-sm btn btn-info" style="margin:2px 10px 2px 0;">查看</button>';
                        }
                        if (row.Bill_Equal_Value == 0){
                            result += '<button id="bill_equal_print" class="btn-sm btn btn-success" style="margin:2px 10px 2px 0;">打印</button>';
                        }
                        result += '<button id="bill_equal_delete" class="btn-sm btn btn-danger" style="margin:2px 10px 2px 0;">删除</button>';
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

    //查看前一天
    function openLastDay() {
        if (dateInfo.Date == 'today'){
            dateInfo.Date = '-1';
        }else {
            dateInfo.Date--;
        }
        getBillEqualTable()
    }
    //查看当天
    function openToday() {
        dateInfo.Date = 'today';
        getBillEqualTable()
    }

    //开启已点
    function openFinish(Bill_Equal_ID){
        $("#finishModal").on('show.bs.modal',function () {
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            _formData.append('Bill_Equal_ID',Bill_Equal_ID);
            fetch("/epos/get_finish", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    let gethtml = document.getElementById('finish-template').innerHTML;
                    jetpl(gethtml).render({list:_resJson.data.finish_info}, function(html){
                        $('#finish_div').html(html);
                    });
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
            $('#finishModal').off('show.bs.modal');
        })
        $("#finishModal").modal('show');  //手动开启
    }

    //开启详情
    function openDetail(Bill_Equal_ID,Bill_Equal_DeskID){
        $("#finishModal").on('show.bs.modal',function () {
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            _formData.append('Bill_Equal_ID',Bill_Equal_ID);
            fetch("/epos/get_finish", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    let gethtml = document.getElementById('finish-template').innerHTML;
                    jetpl(gethtml).render({list:_resJson.data.finish_info}, function(html){
                        $('#finish_div').html(html);
                    });
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
            $('#finishModal').off('show.bs.modal');
        })
        $("#finishModal").modal('show');  //手动开启
    }

    //关闭已点
    function closeFinish(){
        $("#finishModal").on('hide.bs.modal',function () {
            $("#finish_div").empty();
            // document.getElementById('giveDiscount').value = '';
        })
        $("#finishModal").modal('hide');  //手动关闭
    }

    //折扣计算
    function littleNumRemoved() {
        let num = document.getElementById('plan-finish').innerHTML;
        let floored = Math.floor(num);
        document.getElementById('real-finish').innerHTML = floored;
        console.log(floored);
    }
    function zeroRemoved() {
        let num = document.getElementById('plan-finish').innerHTML;
        let lastDigit = num % 10;
        let zeroesRemoved = num - lastDigit;
        document.getElementById('real-finish').innerHTML = zeroesRemoved;
        console.log(zeroesRemoved);
    }
    function giveDiscount() {
        let num = document.getElementById('plan-finish').innerHTML;
        let discount = document.getElementById('giveDiscount').value;
        let dis = 10;
        if (discount != '') {
            dis = discount;
        }
        if (dis < 0 || dis >10) {
            layer.msg("折扣范围不能超过0~10！", {
                zIndex:10000
            })
        }else {
            let floored = Math.floor(num * (dis/10));
            document.getElementById('real-finish').innerHTML = floored;
        }
    }
    function giveCoupon() {
        let num = document.getElementById('plan-finish').innerHTML;
        let coupon = document.getElementById('giveDiscount').value;
        if ((num - coupon) < 0 || (num - coupon) > num) {
            layer.msg("优惠券面额为正数且不能超过订单金额！", {
                zIndex:10000
            })
        }else {
            cou = num - coupon;
            document.getElementById('real-finish').innerHTML = cou;
        }
    }

    //加单
    function addDish() {
        let Eid = document.getElementById('get_id').getAttribute('data-eid');
        let Did = document.getElementById('get_id').getAttribute('data-id');
        window.open("{{ URL::to('/epos/order_again') }}" + "?desk=" + Did + "&bill=" + Eid);
        window.location.reload();
    }

    //提交结单
    function confirmFinish() {
        layer.confirm('确认结单？', {
            btn: ['取消','确认'] //按钮
        }, function(){
            layer.msg('已取消');
        }, function(){
            // layer.msg('确认')
            let bill_id = document.getElementById('real-finish').getAttribute('data-id');
            let real_sale = document.getElementById('real-finish').innerHTML;
            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            _formData.append('Bill_Equal_ID',bill_id);
            _formData.append('Bill_Real_Sale',real_sale);
            fetch("/epos/add_finish", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    layer.confirm('已结单！立即打印小票？', {
                        btn: ['取消','打印'] //按钮
                    }, function(){
                        layer.msg("已取消！", {
                            zIndex:10000,
                            time: 2000,
                            end: function () {
                                window.location.reload();
                            }
                        })
                    }, function(){
                        layer.msg('跳转打印');
                        //然后刷新页面
                        // window.location.reload();
                    });
                }else {
                    layer.msg("出错了！错误原因：" + _resJson.message);
                }
            })
        });
    }
</script>
</body>
</html>