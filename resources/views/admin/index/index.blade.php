@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->

@endsection

@section('content')
    <div class="users">
        <router-view></router-view>
    </div>
@endsection
