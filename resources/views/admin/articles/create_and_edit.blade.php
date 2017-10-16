@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="articles-save">
        <i-form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="90">
            <Form-item label="标题" prop="title">
                <i-input v-model="formValidate.title" placeholder="标题"></i-input>
            </Form-item>

            <Form-item label="分类" prop="cat_id">
                <i-input v-model="formValidate.cat_id" placeholder="分类"></i-input>
            </Form-item>

            <Form-item label="图片" prop="images">
                <my-upload ref="uploadImg" :upload-conf="uploadConf"></my-upload>
            </Form-item>

            <Form-item label="内容" prop="content">
                <script id="content" type="text/plain" style="width:800px;height:400px;">
                    @{{ formValidate.content }}
                </script>
            </Form-item>

            <Form-item label="摘要" prop="desc">
                <Input v-model="formValidate.desc" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="摘要"></Input>
            </Form-item>

            <Form-item label="关键字" prop="keywords">
                <i-input v-model="formValidate.keywords" placeholder="关键字"></i-input>
            </Form-item>

            <Form-item label="状态" prop="status">
                <i-input v-model="formValidate.status" placeholder="状态"></i-input>
            </Form-item>

            <Form-item label="浏览量" prop="view_num">
                <i-input v-model="formValidate.view_num" placeholder="浏览量"></i-input>
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

    <script type="text/javascript">

        var page = Util.Vue({
            el: "#app",
            data: {
                formValidate: {
                    id: 0,
                    title: "",
                    cat_id: "",
                    images: "",
                    content: "",
                    desc: "",
                    keywords: "",
                    status: "",
                    view_num: ""
                },
                ruleValidate: {
                    title: [
                        { required: true, message: '请输入标题', trigger: 'blur' }
                    ],
                    cat_id: [
                        { required: true, message: '请选择文章分类', trigger: 'blur' }
                    ],
                    content: [
                        { required: true, message: '请输入文章内容', trigger: 'blur' }
                    ]
                },
                uploadConf: {
                    action: "{{ route("myUpload") }}",
                    defaultList: [
                        {
                            name:"",
                            url: ""
                        }
                    ],
                    multiple: true,
                    data: {file_type: "articles"}
                }
            },
            methods: {
                handleSubmit: function () {
                    var _this = this;
                    _this.$refs["formValidate"].validate((valid) => {
                        if (valid) {
                            if (_this.formValidate.id) {
                                var url = "{{ route('admin.articles.store') }}"
                                var method = "POST";
                            }else {
                                var url = "/admin/articles/" + _this.formValidate.id
                                var method = "PATCH";
                            }

                            Util.ajax({
                                url: url,
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
                @if (isset($article_json) && !empty($article_json))
                    var article_json = {!! $article_json !!};
                    for (var i in _this.formValidate) {
                        _this.formValidate[i] = article_json[i];
                    }

                    _this.uploadConf.defaultList = {!! $article['images'] !!};
                @endif
            }
        });
    </script>
@endsection
