@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="users">
        <router-view></router-view>
    </div>
@endsection

@section('script')
    <!-- 本页面专属js 文件 -->
    <script src="{{ asset('js/admin/index.js') }}" type="text/javascript"></script>

@endsection
