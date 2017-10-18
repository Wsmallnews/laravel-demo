@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="articles-save">
        {!! $article->title !!}
        {!! $article->content !!}
    </div>
@endsection
@section('script')
    <!-- 本页面专属js 文件 -->
    <script src="{{ asset('plus/ueditor/ueditor.config.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plus/ueditor/ueditor.all.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var page = Util.Vue({
            el: "#app",
            data: {

            },
            methods: {

            },
            created: function () {

            },
            mounted: function(){
                this.spinShow = false;
            }
        });
    </script>
@endsection
