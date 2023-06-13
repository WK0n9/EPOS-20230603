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
    <script src = "{{ asset('./js/md5.min.js') }}" ></script>
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
        /* 隐藏 IE、Edge 和 Firefox 的滚动条 */
        #Cate {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>

</head>
<body>
    <div style="height: 30vh;width: 100%"></div>
    <div class="row" style="align-items: center;justify-content: center;height: 100%;">
        <div style="width: 300px;">
            <div style="height: 80px;line-height: 80px;text-align: center;font-size: 45px;font-weight: bold">江 湖 鱼 坊</div>
            <div style="height: 40px;width: 100%"></div>
            <div class="input-group flex-nowrap">
                <span class="input-group-text">口令</span>
                <input type="password" id="pwd" class="form-control" placeholder="输入登录口令">
            </div>
            <div style="height: 20px;"></div>
            <div class="btn btn-primary" id="loginBTN" style="width: 300px;">登录</div>
        </div>
    </div>

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('/js/bootstrap-table.min.js') }}"></script>
    <!-- Latest compiled and minified Locales -->
    <script src="{{ asset('/js/bootstrap-table-zh-cn.min.js') }}"></script>
    <script>
        document.getElementById("loginBTN").addEventListener("click",function () {
            let _formData = new FormData;
            let pwd_md5 = md5(md5(document.getElementById("pwd").value));
            _formData.append("pwd",document.getElementById("pwd").value);
            _formData.append("pwd_md5",pwd_md5);
            _formData.append("_token","{{ csrf_token() }}");
            fetch("{{ URL::to('/epos/login_token') }}",{method:"post",body:_formData}).then(function (_response) {
                return _response.json();
            }).then(function (_resJson) {
                if (_resJson.status == "success"){
                    let pid = _resJson.pid;
                    let cate = _resJson.cate;
                    localStorage.setItem("_token",pwd_md5);
                    localStorage.setItem("ddid",_resJson.pid);
                    localStorage.setItem("cate",_resJson.cate);
                    window.location.href = _resJson.href;
                    // window.location.href = _resJson.href + "?id=" + pwd_md5 + "&dd=" + pid;
                }
                if (_resJson.status == "fail"){
                    layer.msg("登录失败，请重试");
                }
            })
        })
    </script>
</body>
</html>
