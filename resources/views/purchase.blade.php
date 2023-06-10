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
        #div_table::-webkit-scrollbar {
            display: none;
        }
        /* 隐藏 IE、Edge 和 Firefox 的滚动条 */
        #div_table {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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
        .button_pur_true {
            background-color: #418595;
        }
        .button_pur_false {
            background-color: #5ab8cc;
        }
        .button_pur:focus{
            box-shadow:none!important;
        }
        .ui-autocomplete {
            z-index: 215000000 !important;
            max-height: 40vh;
            overflow-y: auto;
        }
    </style>

</head>
<body>
    <div class="modal fade" tabindex="-1" id="purModal">
        <div class="modal-dialog" style="width: 97%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body" style="height: calc(90vh - 200px);overflow-y: auto">
                    <div id="pur_div">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">关闭</button>
                    <button type="button" class="btn btn-primary" id="purButton" onclick="confirmDish()">提交</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">采购</div>
        <div style="height: 20px;width: 100%"></div>
        <div class="row" style="height: 40px">
            <div class="col-6" style="text-align: left">
                <div class="btn-group" role="group" aria-label="">
                    <button id="button_dish" type="button" class="btn btn-info button_pur button_pur_true" onclick="switchDish()">菜品</button>
                    <button id="button_item" type="button" class="btn btn-info button_pur button_pur_false" onclick="switchItem()">货品</button>
                </div>
            </div>
            <div class="col-6" style="text-align: right">
                <button id="button_dish_item" type="button" class="btn btn-info" onclick="openDish()">添加菜品</button>
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>

        <div id="div_table" style="height: calc(100vh - 200px);width: 100%;overflow-y: auto">
            <table id="dish_item_table"></table>
            <div style="height: 60px;width: 100%;"></div>
        </div>

        <div class="row" style="position: absolute;bottom: 0;height: 60px;width: 100%;z-index: 99">
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/') }}'">点餐</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/purchase') }}'">采购</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/bill') }}'">账单</div>
            <div class="col-3 button_bottom" onclick="window.location.href = '{{ URL::to('/epos/personal') }}'">我的</div>
        </div>
    </div>

    <script type="text/html" id="dish-template">
        <div style="height: 30px;width: 100%"></div>
        <div>
            <div>菜品名称</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addDishName" class="form-control" placeholder="请输入名称" onfocus="getDishNameFocus()">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>菜品类别</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addDishCate" class="form-control" placeholder="请输入类别" onfocus="getDishCateFocus()">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>成本价</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addDishCost" class="form-control" placeholder="请输入成本价">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>售价</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addDishSale" class="form-control" placeholder="请输入售价">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>库存</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addDishStock" class="form-control" placeholder="暂未开放" disabled>
            </div>
        </div>
    </script>

    <script type="text/html" id="dish-edit-template">
        <div style="height: 30px;width: 100%"></div>
        <div>
            <div>菜品名称</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="oriDishID" class="form-control" placeholder="" value="{%= list.Dish_ID %}" style="display: none" disabled>
                <input type="text" id="oriDishName" class="form-control" placeholder="" value="{%= list.Dish_Name %}" disabled>
                <input type="text" id="editDishName" class="form-control" placeholder="请输入新名称" onfocus="getDishNameFocus()">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>菜品类别</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="oriDishCateID" class="form-control" placeholder="" value="{%= list.Dish_Cate %}" style="display: none" disabled>
                <input type="text" id="oriDishCate" class="form-control" placeholder="" value="{%= list.Dish_Cate_Name %}" disabled>
                <input type="text" id="editDishCate" class="form-control" placeholder="请输入新类别" onfocus="getDishCateFocus()">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>成本价</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="oriDishCost" class="form-control" placeholder="" value="{%= list.Dish_Cost %}" disabled>
                <input type="text" id="editDishCost" class="form-control" placeholder="请输入新成本价">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>售价</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="oriDishSale" class="form-control" placeholder="" value="{%= list.Dish_Sale %}" disabled>
                <input type="text" id="editDishSale" class="form-control" placeholder="请输入新售价">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div>
            <div>库存</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="editDishStock" class="form-control" placeholder="暂未开放" disabled>
            </div>
        </div>
    </script>

    <script type="text/html" id="item-template">
        <div style="height: 30px;width: 100%"></div>
        <div>
            <div>花销 (元)</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="addItemCost" class="form-control" placeholder="请输入花销 (元)">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div class="form-group">
            <label for="addTips">备注</label>
            <textarea class="form-control" id="addTips" rows="8"></textarea>
        </div>
    </script>

    <script type="text/html" id="item-edit-template">
        <div style="height: 30px;width: 100%"></div>
        <div>
            <div>花销 (元)</div>
            <div class="input-group flex-nowrap">
                <input type="text" id="oriItemID" class="form-control" placeholder="" value="{%= list.Item_ID %}" style="display: none" disabled>
                <input type="text" id="oriItemCost" class="form-control" placeholder="" value="{%= list.Item_Cost %}" disabled>
                <input type="text" id="editItemCost" class="form-control" placeholder="请输入新花销 (元)">
            </div>
        </div>
        <div style="height: 20px;width: 100%"></div>
        <div class="form-group">
            <label for="editTips">备注</label>
            <textarea class="form-control" id="editTips" rows="8"></textarea>
        </div>
    </script>

    <script>
        //存放下拉菜单信息
        function DishInfo(){}
        DishInfo.prototype.Dish_ID = [];
        DishInfo.prototype.Dish_Name = [];
        DishInfo.prototype.Cate_ID = [];
        DishInfo.prototype.Cate_Name = [];
        let dishInfo = new DishInfo();

        //初始化菜品列表
        function getVegTable() {
            $('#dish_item_table').bootstrapTable('destroy');
            let tableSettings = {
                url:"{{ URL::to('/epos/get_dish') }}",
                pagination: "false",//开启分页
                method: 'post',
                pageSize: 10000,//每页大小
                pageList: [12, 20, 50,100,500,1500],
                pageNumber: 1,
                rowHeights:20,
                striped: true,
                sortName:"Dish_Cate",
                sortable: true,//是否启用排序
                sortOrder:"ASC",//排序方式
                // paginationPreText: '上一页',
                // paginationNextText: '下一页',
                queryParamsType :'',
                // sidePagination : 'server',//服务端分页
                //设置请求参数
                queryParams:function(){
                    let tem= {
                        // pageSize:this.pageSize,
                        // pageNumber:this.pageNumber,
                        _token:"{{ csrf_token() }}",
                        // keywords:"",
                        // orderBy:this.sortName,
                        // sortType:this.sortOrder
                    };
                    return tem;
                },
                responseHandler:function(_responseJson){
                    return {
                        // "total":_responseJson.total,
                        "rows":_responseJson.data.dish_info
                    }
                },
                columns: [
                //     {
                //     checkbox: false,
                // },
                    // {
                //     field: 'myRowNumber',
                //     title: '行号',
                //     // sorter:'customSort',
                //     formatter: function (value, row, index){
                //         return index + 1;
                //     }
                // },
                    {
                    field: 'Dish_ID',
                    title: 'ID',
                    // sorter:'customSort',

                }, {
                    field: 'Dish_Name',
                    title: '名称',
                    sortable: true,
                    // sorter:'customSort',
                }, {
                    field: 'Dish_Cate',
                    title: '类别ID',
                    // sorter:'customSort',
                },{
                    field: 'Dish_Cate_Name',
                    title: '类别',
                    sortable: true,
                    // sorter:'customSort',
                },{
                    field: 'Dish_Cost',
                    title: '进价',
                    sortable: true,
                    // sorter:'customSort',
                },{
                    field: 'Dish_Sale',
                    title: '售价',
                    sortable: true,
                    // sorter:'customSort',
                },{
                    field: 'oprator',
                    title: '操作',
                    align: 'center',
                    valign: 'middle',
                    // width: '200',
                    events: {
                        'click #dish_edit':function (e,value, row, index) {
                            console.log(row)
                            editDish(row);
                        },
                        'click #dish_delete':function (e,value, row, index) {
                            layer.confirm('确认删除？', {
                                btn: ['取消','确认'] //按钮
                            }, function(){
                                layer.msg('已取消');
                                // console.log("已取消");
                            }, function(){
                                let _formData = new FormData;
                                _formData.append('_token', "{{ csrf_token() }}");
                                _formData.append('Dish_ID',row.Dish_ID);

                                fetch("/epos/delete_dish", {method: 'post', body: _formData}).then(function (_res) {
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
                        result += '<button id="dish_edit" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">编辑</button>';
                        result += '<button id="dish_delete" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">删除</button>';
                        return result;
                    }
                }],}
            $("#dish_item_table").bootstrapTable(tableSettings);
            $("#dish_item_table").bootstrapTable('hideColumn', 'Dish_ID');
            $("#dish_item_table").bootstrapTable('hideColumn', 'Dish_Cate');
            $('#dish_item_table').bootstrapTable('togglePagination');
        }
        //初始化货物列表
        function getItemTable() {
            $('#dish_item_table').bootstrapTable('destroy');
            let tableSettings = {
                url:"{{ URL::to('/epos/get_item') }}",
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
                        "total":_responseJson.total,
                        "rows":_responseJson.data.item_info
                    }
                },
                columns: [{
                        field: 'Item_ID',
                        title: 'ID',
                        // sorter:'customSort',
                    },{
                        field: 'Item_Date',
                        title: '日期',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'Item_Tips',
                        title: '备注',
                        sortable: true,
                        sorter:'customSort',
                        cellStyle: function (value, row, index) {
                            return {
                                css: {
                                    // "min-width": "100px",
                                    "white-space": "nowrap",
                                    "text-overflow": "ellipsis",
                                    "overflow": "hidden",
                                    "max-width": "100px"
                                }
                            }
                        },
                        formatter: function (value, row, index) {
                            return "" + value + "";
                        }
                    },{
                        field: 'Item_Cost',
                        title: '价格(元)',
                        sortable: true,
                        // sorter:'customSort',
                    },{
                        field: 'oprator',
                        title: '操作',
                        align: 'center',
                        valign: 'middle',
                        // width: '200',
                        events: {
                            'click #item_edit':function (e,value, row, index) {
                                // console.log('ID是' + row.id)
                                editItem(row)
                                $("#editTips").text(row.Item_Tips);
                            },
                            'click #item_delete':function (e,value, row, index) {
                                layer.confirm('确认删除？', {
                                    btn: ['取消','确认'] //按钮
                                }, function(){
                                    layer.msg('已取消');
                                    // console.log("已取消");
                                }, function(){
                                    let _formData = new FormData;
                                    _formData.append('_token', "{{ csrf_token() }}");
                                    _formData.append('Item_ID',row.Item_ID);

                                    fetch("/epos/delete_item", {method: 'post', body: _formData}).then(function (_res) {
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
                            result += '<button id="item_edit" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">编辑</button>';
                            result += '<button id="item_delete" class="btn-sm btn btn-primary" style="margin:2px 10px 2px 0;">删除</button>';
                            return result;
                        }
                    }],}
            $("#dish_item_table").bootstrapTable(tableSettings);
            $("#dish_item_table").bootstrapTable('hideColumn', 'Item_ID');
            $('#dish_item_table').bootstrapTable('togglePagination');
        }
        getVegTable();

        function switchDish() {
            document.getElementById("button_dish").className = "btn btn-info button_pur button_pur_true";
            document.getElementById("button_item").className = "btn btn-info button_pur button_pur_false";
            document.getElementById("button_dish_item").innerHTML = "添加菜品";
            document.getElementById("button_dish_item").setAttribute("onclick","openDish()");
            getVegTable();
        }
        function switchItem() {
            document.getElementById("button_dish").className = "btn btn-info button_pur button_pur_false";
            document.getElementById("button_item").className = "btn btn-info button_pur button_pur_true";
            document.getElementById("button_dish_item").innerHTML = "添加货物";
            document.getElementById("button_dish_item").setAttribute("onclick","openItem()");
            getItemTable();
        }

        //开启添加菜品
        function openDish() {
            $("#purModal").on('show.bs.modal',function () {
                document.getElementsByClassName('modal-title')[0].innerHTML = '添加菜品';
                document.getElementById("purButton").setAttribute("onclick","confirmDish()");
                let gethtml = document.getElementById('dish-template').innerHTML;
                jetpl(gethtml).render({list: ''}, function(html){
                    $('#pur_div').html(html);
                });
                //菜品名称栏输入数据时弹出推荐项
                $( "#addDishName" ).autocomplete({
                    source: dishInfo.Dish_Name
                });
                $( "#addDishCate" ).autocomplete({
                    source: dishInfo.Cate_Name
                });
                $('#purModal').off('show.bs.modal');
            })
            $("#purModal").modal('show');  //手动开启
        }
        //开启添加货物
        function openItem() {
            $("#purModal").on('show.bs.modal',function () {
                document.getElementsByClassName('modal-title')[0].innerHTML = '添加货物';
                document.getElementById("purButton").setAttribute("onclick","confirmItem()");
                let gethtml = document.getElementById('item-template').innerHTML;
                jetpl(gethtml).render({list: ''}, function(html){
                    $('#pur_div').html(html);
                });
                $('#purModal').off('show.bs.modal');
            })
            $("#purModal").modal('show');  //手动开启
        }
        //开启编辑菜品
        function editDish(Dish_List) {
            $("#purModal").on('show.bs.modal',function () {
                document.getElementsByClassName('modal-title')[0].innerHTML = '编辑菜品';
                document.getElementById("purButton").setAttribute("onclick","confirmEditDish()");
                let gethtml = document.getElementById('dish-edit-template').innerHTML;
                jetpl(gethtml).render({list: Dish_List}, function(html){
                    $('#pur_div').html(html);
                });
                //菜品名称栏输入数据时弹出推荐项
                $( "#editDishName" ).autocomplete({
                    source: dishInfo.Dish_Name
                });
                $( "#editDishCate" ).autocomplete({
                    source: dishInfo.Cate_Name
                });
                $('#purModal').off('show.bs.modal');
            })
            $("#purModal").modal('show');  //手动开启
        }
        //开启编辑货物
        function editItem(Item_List) {
            $("#purModal").on('show.bs.modal',function () {
                document.getElementsByClassName('modal-title')[0].innerHTML = '编辑货物';
                document.getElementById("purButton").setAttribute("onclick","confirmEditItem()");
                let gethtml = document.getElementById('item-edit-template').innerHTML;
                jetpl(gethtml).render({list: Item_List}, function(html){
                    $('#pur_div').html(html);
                });
                $('#purModal').off('show.bs.modal');
            })
            $("#purModal").modal('show');  //手动开启
        }

        //关闭模态框
        function closeModal(){
            $("#purModal").on('hide.bs.modal',function () {
                document.getElementsByClassName('modal-title')[0].innerHTML = '';
                document.getElementById("purButton").setAttribute("onclick","layer.msg('啊嘞，出错了')");
                $("#pur_div").empty();
            })
            $("#purModal").modal('hide');  //手动关闭
        }

        //提交菜品添加
        function confirmDish() {
            let Dish_Name = document.getElementById('addDishName').value;
            let Dish_Cate_ID = -1
            let Dish_Cate = document.getElementById('addDishCate').value;
            for (let i = 0;i < dishInfo.Cate_Name.length;i++){
                if (Dish_Cate == dishInfo.Cate_Name[i]){
                    Dish_Cate_ID = dishInfo.Cate_ID[i];
                }
            }
            let Dish_Cost = document.getElementById('addDishCost').value;
            let Dish_Sale = document.getElementById('addDishSale').value;
            if (Dish_Name == '' || (Dish_Cate_ID == -1 && Dish_Cate == '') || Dish_Cost == '' || Dish_Sale == ''){
                layer.msg("选项不能为空！")
            }else {
                let _formData = new FormData;
                _formData.append('_token', "{{ csrf_token() }}");
                _formData.append('Dish_Name',Dish_Name);
                _formData.append('Dish_Cate',Dish_Cate_ID);
                _formData.append('Dish_Cost',Dish_Cost);
                _formData.append('Dish_Sale',Dish_Sale);

                fetch("/epos/add_dish", {method: 'post', body: _formData}).then(function (_res) {
                    return _res.json();
                }).then(function (_resJson) {
                    console.log(_resJson);
                    if (_resJson.status == "success"){
                        layer.msg("添加成功！页面将自动刷新！", {
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
            }
        }
        //提交货物添加
        function confirmItem() {
            let Item_Cost = document.getElementById('addItemCost').value;
            let Item_Tips = document.getElementById('addTips').value;
            if (Item_Cost == '' || Item_Tips == ''){
                layer.msg("选项不能为空！")
            }else {
                let _formData = new FormData;
                _formData.append('_token', "{{ csrf_token() }}");
                _formData.append('Item_Cost',Item_Cost);
                _formData.append('Item_Tips',Item_Tips);

                fetch("/epos/add_item", {method: 'post', body: _formData}).then(function (_res) {
                    return _res.json();
                }).then(function (_resJson) {
                    console.log(_resJson);
                    if (_resJson.status == "success"){
                        layer.msg("添加成功！页面将自动刷新！", {
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
            }
        }

        //提交菜品编辑
        function confirmEditDish() {
            let Dish_ID = document.getElementById('oriDishID').value;
            let Ori_Dish_Name = document.getElementById('oriDishName').value;
            let Edit_Dish_Name = document.getElementById('editDishName').value;
            let Ori_Dish_Cate_ID = document.getElementById('oriDishCateID').value;
            // let Ori_Dish_Cate_Name = document.getElementById('oriDishCate').value;
            let Edit_Dish_Cate_ID = -1
            let Edit_Dish_Cate_Name = document.getElementById('editDishCate').value;
            for (let i = 0;i < dishInfo.Cate_Name.length;i++){
                if (Edit_Dish_Cate_Name == dishInfo.Cate_Name[i]){
                    Edit_Dish_Cate_ID = dishInfo.Cate_ID[i];
                }
            }
            let Ori_Dish_Cost = document.getElementById('oriDishCost').value;
            let Edit_Dish_Cost = document.getElementById('editDishCost').value;
            let Ori_Dish_Sale = document.getElementById('oriDishSale').value;
            let Edit_Dish_Sale = document.getElementById('editDishSale').value;

            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            _formData.append('Dish_ID',Dish_ID);
            if (Edit_Dish_Name == '') {
                _formData.append('Dish_Name',Ori_Dish_Name);
            }else {
                _formData.append('Dish_Name',Edit_Dish_Name);
            }
            if (Edit_Dish_Cate_Name == '') {
                _formData.append('Dish_Cate',Ori_Dish_Cate_ID);
            }else {
                _formData.append('Dish_Cate',Edit_Dish_Cate_ID);
            }
            if (Edit_Dish_Cost == '') {
                _formData.append('Dish_Cost',Ori_Dish_Cost);
            }else {
                _formData.append('Dish_Cost',Edit_Dish_Cost);
            }
            if (Edit_Dish_Sale == '') {
                _formData.append('Dish_Sale',Ori_Dish_Sale);
            }else {
                _formData.append('Dish_Sale',Edit_Dish_Sale);
            }

            fetch("/epos/edit_dish", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    layer.msg("编辑成功！页面将自动刷新！", {
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
        }
        //提交货物编辑
        function confirmEditItem() {
            let Item_ID = document.getElementById('oriItemID').value;
            let Ori_Item_Cost = document.getElementById('oriItemCost').value;
            let Edit_Item_Cost = document.getElementById('editItemCost').value;
            let Edit_Item_Tips = document.getElementById('editTips').value;

            let _formData = new FormData;
            _formData.append('_token', "{{ csrf_token() }}");
            _formData.append('Item_ID',Item_ID);
            if (Edit_Item_Cost == '') {
                _formData.append('Item_Cost',Ori_Item_Cost);
            }else {
                _formData.append('Item_Cost',Edit_Item_Cost);
            }
            _formData.append('Item_Tips',Edit_Item_Tips);

            fetch("/epos/edit_item", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson);
                if (_resJson.status == "success"){
                    layer.msg("编辑成功！页面将自动刷新！", {
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
        }

        //下拉菜单控制函数
        //加载名称选项
        function getDishNameFocus() {
            let _formData = new FormData;
            _formData.append("_token", "{{ csrf_token() }}");

            let data;
            //先清空再写入，避免组件重复获得焦点时重复写入
            dishInfo.Dish_ID.length = 0;
            dishInfo.Dish_Name.length = 0;
            getInfo('/epos/get_dish');
            function getInfo(URL){
                fetch(URL, {method: "post", body: _formData}).then(_res => {
                    return _res.json();
                }).then(_resJson => {
                    if (_resJson.status == "fail") {
                        layer.msg("出错了！错误原因：" + _resJson.message);
                    }
                    data = _resJson.data.dish_info;
                    for (let i = 0; i < data.length; i++) {
                        let num = 0;
                        if (dishInfo.Dish_Name.length == 0){
                            num = 1;
                        }
                        for (let j = 0; j < dishInfo.Dish_Name.length; j++) {
                            if (data[i].Dish_Name == dishInfo.Dish_Name[j]) {
                                num = 0;
                                break;
                            }
                            num++;
                        }
                        if (num != 0 && data[i].Dish_Name != null) {
                            dishInfo.Dish_ID.push(data[i].Dish_ID);
                            dishInfo.Dish_Name.push(data[i].Dish_Name);
                            console.log(dishInfo.Dish_ID)
                            console.log(dishInfo.Dish_Name)
                        }
                    }
                })
            }
        }
        function getDishCateFocus() {
            let _formData = new FormData;
            _formData.append("_token", "{{ csrf_token() }}");

            let data;
            //先清空再写入，避免组件重复获得焦点时重复写入
            dishInfo.Cate_ID.length = 0;
            dishInfo.Cate_Name.length = 0;
            getInfo('/epos/get_cate');
            function getInfo(URL){
                fetch(URL, {method: "post", body: _formData}).then(_res => {
                    return _res.json();
                }).then(_resJson => {
                    if (_resJson.status == "fail") {
                        layer.msg("出错了！错误原因：" + _resJson.message);
                    }
                    data = _resJson.data.cate_info;
                    for (let i = 0; i < data.length; i++) {
                        let num = 0;
                        if (dishInfo.Cate_Name.length == 0){
                            num = 1;
                        }
                        for (let j = 0; j < dishInfo.Cate_Name.length; j++) {
                            if (data[i].Cate_Name == dishInfo.Cate_Name[j]) {
                                num = 0;
                                break;
                            }
                            num++;
                        }
                        if (num != 0 && data[i].Cate_Name != null) {
                            dishInfo.Cate_ID.push(data[i].Cate_ID);
                            dishInfo.Cate_Name.push(data[i].Cate_Name);
                            console.log(dishInfo.Cate_ID)
                            console.log(dishInfo.Cate_Name)
                        }
                    }
                })
            }
        }
    </script>
</body>
</html>
