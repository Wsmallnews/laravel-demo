{{-- */$title="404 not found";/* --}}
@section('style')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <!--案例展示-->
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">没有找到</h2>
            <p class="weui-msg__desc">您访问的内容不存在</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="" class="weui-btn weui-btn_primary">首页</a>
                {{-- <a href="javascript:;" class="weui-btn weui-btn_default">辅助操作</a> --}}
            </p>
        </div>
        {{-- <div class="weui-msg__extra-area">
            <div class="weui-footer">
                <p class="weui-footer__links">
                    <a href="javascript:void(0);" class="weui-footer__link">底部链接文本</a>
                </p>
                <p class="weui-footer__text">Copyright © 2008-2016 weui.io</p>
            </div>
        </div> --}}
    </div>
@endsection

@section('script')
    @parent
    <script type="text/javascript">
        var page = new Vue({
            el : "#apps",
            data : {
                loading: true
            },
            methods: {
            },
            mounted: function(){
                var _this = this;
                _this.loading = false;
            }
        });

    </script>
@endsection
