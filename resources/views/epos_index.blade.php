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
        /* 隐藏 Chrome、Safari 和 Opera 的滚动条 */
        #Desk_ID::-webkit-scrollbar {
            display: none;
        }
        /* 隐藏 IE、Edge 和 Firefox 的滚动条 */
        #Desk_ID {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

</head>
<body>
    <div>
        <div class="sticky-top" style="height: 60px;width: 100%;background-color: #5ab8cc;line-height: 60px;text-align: center;font-size: 25px;color: white">江湖鱼坊-点餐</div>
        <div style="height: 15px;width: 100%"></div>
        <div style="margin-left: 20px">请选择桌号：</div>
        <div style="height: 11px;width: 100%"></div>
        <div id="Desk_ID" style="height: calc(100vh - 170px);width: 100%;overflow-y: auto">
{{--            <div style="margin: 10px;padding: 10px;height: 50px;background-color: #e8e8e8;border-radius: 10px;line-height: 30px;text-align: center"></div>--}}
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

        //初始化页面
        function freshPage(){
            let _formData = new FormData;
            _formData.append("_token", "{{ csrf_token() }}");
            fetch("{{ URL::to('/epos/get_index') }}", {method: 'post', body: _formData}).then(function (_res) {
                return _res.json();
            }).then(function (_resJson) {
                console.log(_resJson.data.desk_info);
                getDeskInfo(_resJson.data.desk_info);
            })
        }
        //写入桌号
        function getDeskInfo(_resJson){
            let dom = document.getElementById('Desk_ID');
            if(dom.children.length == 0) {
                for (let i = 0; i < _resJson.length; i++) {
                    let div = document.createElement('div');
                    div.style.margin = '10px';
                    div.style.padding = '10px';
                    div.style.height = '50px';
                    div.style.backgroundColor = '#e8e8e8';
                    div.style.borderRadius = '10px';
                    div.style.lineHeight = '30px';
                    div.style.textAlign = 'center';
                    div.setAttribute("onclick","window.open('{{ URL::to('/epos/order') }}" + "?desk=" + _resJson[i].Desk_ID + "')");
                    div.innerHTML = _resJson[i].Desk_Name;
                    dom.append(div);
                }
            }
        }
        freshPage();
    </script>
</body>
</html>
