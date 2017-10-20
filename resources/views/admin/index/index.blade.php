@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="users">
        <div class="visible-print text-center">
            <!-- 像素点，不是图片 -->
            {!! QrCode::size(100)->generate("this is contents."); !!}
            {!! QrCode::generate('Hello,LaravelAcademy!') !!}
            {!! QrCode::encoding('UTF-8')->generate('你好，Laravel学院！') !!}


            {{-- {!! QrCode::format('png')->generate('this is png encode!') !!} --}}

            <img src="" alt="">
        </div>
    </div>
@endsection
@section('script')
    <!-- 本页面专属js 文件 -->

    <script type="text/javascript">

        var page = Util.Vue({
            el: "#app",
            data: {

            },
            mounted: function(){
                this.spinShow = false;
            }
        });
    </script>
@endsection
