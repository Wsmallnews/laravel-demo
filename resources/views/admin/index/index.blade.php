@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="users">
        <my-table>


        </my-table>
    </div>
@endsection
@section('script')
    <!-- 本页面专属js 文件 -->

    <script type="text/javascript">
        // Vue.component('example', example);

        var page = Util.Vue({
            el: "#app",
            data: {
                
            }
        });
    </script>
@endsection
