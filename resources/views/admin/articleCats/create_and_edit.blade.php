@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="articles-save">
        <i-form ref="formValidate" class="form-edit" :model="formValidate" :rules="ruleValidate" :label-width="90">
            <Form-item label="分类名称" prop="name">
                <i-input v-model="formValidate.name" placeholder="标题"></i-input>
            </Form-item>

            <Form-item label="上级分类" prop="parent_id">
                <i-input v-model="formValidate.parent_id" placeholder="分类"></i-input>
            </Form-item>

            {{-- <Form-item label="is_nav" prop="is_nav">
                <radio-group v-model="formValidate.is_nav">
                    <Radio label="1">是</Radio>
                    <Radio label="0">不是</Radio>
                </radio-group>
            </Form-item> --}}

            <Form-item label="排序" prop="sort_order">
                {{-- <i-input v-model="formValidate.view_num"></i-input> --}}
                <input-number :min="1" v-model="formValidate.sort_order" placeholder="排序"></input-number>
            </Form-item>

            <Form-item label="描述" prop="desc">
                <i-input v-model="formValidate.desc" type="textarea" :autosize="{minRows: 3,maxRows: 5}" placeholder="描述"></i-input>
            </Form-item>

            <Form-item>
                <i-button type="primary" @click="handleSubmit('formValidate')">提交</i-button>
                <i-button type="ghost" @click="handleReset('formValidate')" style="margin-left: 8px">重置</i-button>
            </Form-item>
        </i-form>
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
                formValidate: {
                    id: 0,
                    name: "",
                    parent_id: "",
                    is_nav: 0,
                    sort_order: 50,
                    desc: ""
                },
                ruleValidate: {
                    name: [
                        { required: true, message: '请输入标题', trigger: 'blur' }
                    ]
                }
            },
            methods: {
                handleSubmit: function () {
                    var _this = this;
                    _this.$refs["formValidate"].validate((valid) => {
                        if (valid) {
                            var method = "POST";
                            if (_this.formValidate.id != "") {
                                method = 'PATCH';
                            }

                            Util.ajax({
                                url: "/admin/articleCats" + (_this.formValidate.id ? "/"+_this.formValidate.id : ""),
                                method: method,
                                data: _this.formValidate,
                                success: function(result){
                                    if (result.error == 0) {
                                        _this.$Notice.success({ title: '提示', desc: '保存成功' });
                                    }else {
                                        _this.$Notice.error({ title: '提示', desc: result.info });
                                    }
                                }
                            });
                        } else {
                            _this.$Notice.error({ title: '提示', desc: '表单验证失败' });
                        }
                    })
                },
                handleReset () {                // 表单数据重置, name ,表单数据
                    var _this = this;
                    _this.$refs["formValidate"].resetFields();
                }
            },
            created: function () {
                var _this = this;
                @if (isset($articleCat_json) && !empty($articleCat_json))
                    var articleCat_json = {!! $articleCat_json !!};
                    for (var i in _this.formValidate) {
                        _this.formValidate[i] = articleCat_json[i];
                    }
                @endif
            }
        });
    </script>
@endsection
