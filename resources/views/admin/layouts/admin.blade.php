<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title-body'){{ $title or config('app.name', '微风尚')}} - {{ config('app.name', '微风尚') }}服务管理控制台</title>

    <!-- Styles -->
    @section('link')
        <link href="{{ asset('css/admin/admin.css') }}" rel="stylesheet" type="text/css">
    @endsection
    @yield('link')

    <style scoped>
        body {
            font-family: 'Lato';
        }
        .index-div{
            display: block;
            width: 100%;
            height: 60px;
            line-height: 60px;
            position: fixed !important;
            top: 0;
            z-index: 9;
        }
        .ivu-menu{
            background-color: #3A4750 !important;
        }
        .ivu-menu-dark{
            background-color: #59606D !important;
        }
        /* 头部导航 */
        .layout{
            /*border: 1px solid #d7dde4;*/
            background: #f5f7f9;
            position: relative;
        }

        .layout-logo{
            width: 100px;
            height: 30px;
            float: left;
            padding: 5px 10px;
        }

        .layout-logo img {
            width: 160px;
            height: 50px;
            padding:0 10px;
        }

        .layout-nav{
            width: 420px;
            float: right;
        }

        .layout-nav .ivu-menu-item{
            float: right;
        }

        .layout-nav .ivu-menu-item a{
            color: hsla(0,0%,100%,.7);
        }
        /* 头部导航 */
        .ivu-menu-dark{
        }
        .ivu-row-flex {
            position: relative;
        }

        /* 左边菜单 */
        .layout-menu-left{
            width: 220px;
            background: #464c5b;
            float: left;
            padding-bottom: 80px;
            position: fixed !important;
            left: 0px;
            height:calc(100% - 120px);
            overflow-y: auto;
            transition: all .4s ease-in-out;
            z-index: 99;
        }

        .layout-menu-left .ivu-menu .ivu-menu-item a{
            color: hsla(0,0%,100%,.7);
        }

        .layout-menu-left .ivu-menu .ivu-menu-submenu-title a{
            color: hsla(0,0%,100%,.7);
        }

        .layout-menu-left .ivu-menu-vertical .ivu-menu-item {
            padding: 0px;
        }

        .layout-menu-left .ivu-menu-vertical .ivu-menu-item a{
            display: block;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding-left: 43px;
        }

        .layout-menu-left .ivu-icon {
            width: 21px;
            text-align: center;
            font-size: 20px;
        }

        /*.ivu-menu-submenu .ivu-menu-submenu-title i.ivu-icon-ios-arrow-down {
            display: none !important;
        }*/
        /* 左边菜单 */
        .layout-menu-left{
            background-color: #59606D;
            margin-top: 60px;
        }

        /* 右边内容 */
        .layout-content-right {
            width: 100%;
            padding-bottom: 80px;
            margin-left: 220px;
            margin-top: 80px;
        }

        /* 内容区域 */
        .layout-breadcrumb{     /* 面包屑导航 */
            padding: 10px 15px 0;
        }

        .layout-content{
            min-height: 200px;
            margin: 15px;
            overflow: hidden;
            background: #fff;
            border-radius: 4px;
        }
        .layout-content-main{
            padding: 10px;
        }

        .oper_div {
            margin-bottom: 24px;
        }

        /* 右边内容 */

        /* 底部内容 */
        .layout-bottom {
            position: fixed;
            bottom: 0px;
            width: 100%;
            height: 60px;
            background: #59606D;
            z-index: 100;
        }

        .layout-bottom-content {
            width: 100%;
            height: 100%;
            line-height: 60px;
            text-align: center;
            color: #FFFFFF;
        }
    </style>

    @yield('style')

    <script type="text/javascript">
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token()
            ])
        !!}
    </script>
</head>
<body>
    <div id="app" class="layout">
        <div class="index-div">
            <i-menu :mode="modeTop" :theme="theme" active-name="1">
                <Spin>
                <div class="layout-logo"><img src="/images/logo.png" /></div>
            	</Spin>
                <div class="layout-nav">
                    <Menu-item name="2">
                        <a href="javascript:;" >
                            <Icon type="ios-navigate"></Icon>
                            退出
                        </a>
                    </Menu-item>

                    <Menu-item name="1">
                        <a href="javascript:;" >
                            <Icon type="ios-keypad"></Icon>
                            修改密码
                        </a>
                    </Menu-item>
                    <Menu-item name="2">
                        <a href="javascript:;" >
                            <Icon type="ios-navigate"></Icon>
                            我的资料
                        </a>
                    </Menu-item>
                </div>
            </i-menu>
        </div>
		<div>
            <Row type="flex">
                <i-col class="layout-menu-left">
                    <i-menu :theme="theme" width="auto" active-name="{{ Request::url() }}" :open-names="['']">
                        <div class="layout-logo-left"></div>
                        <Submenu name="{{ route('admin') }}" list="1">
                            <template slot="title">
                                <Icon type="ios-people"></Icon>
                                推广员管理
                            </template>
                            <Menu-item name="{{ route('admin.users.index') }}" list="1-1"><a href="{{ route('admin.users.index') }}">推广员列表</a></Menu-item>
                        </Submenu>
                        <Submenu name="{{ route('admin') }}" list="1">
                            <template slot="title">
                                <Icon type="document-text"></Icon>
                                文章管理
                            </template>
                            <Menu-item name="{{ route('admin.articles.index') }}" list="1-1"><a href="{{ route('admin.articles.index') }}">文章列表</a></Menu-item>
                            <Menu-item name="{{ route('admin.articleCats.index') }}" list="1-1"><a href="{{ route('admin.articleCats.index') }}">分类列表</a></Menu-item>
                        </Submenu>
                    </i-menu>
                </i-col>
                <i-col class="layout-content-right" >
                    <!-- <div class="layout-header"></div> -->
                    <div class="layout-breadcrumb">
                        <Breadcrumb>
                            <Breadcrumb-item href="{{ route('admin') }}">首页</Breadcrumb-item>
                        </Breadcrumb>
                    </div>
                    <div class="layout-content">
                        <div class="layout-content-main" id="page-content">
                            @yield('content')
                        </div>
                    </div>
                </i-col>
            </Row>
        </div>
        <Row class="layout-bottom" :theme="theme">
            <div class="layout-bottom-content">
                2011-2017 &copy; 微风尚科技
            </div>
        </Row>
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('js/admin/admin.js') }}" type="text/javascript"></script>
    @section('script')
        <script type="text/javascript">

        </script>
    @endsection
    @yield('script')
</body>
</html>
