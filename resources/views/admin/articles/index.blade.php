@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="articles">
        <my-table :list-conf="listConf" ref="listTable" @select="selectRow" :noSearch="true">
            <template slot="formItem" scope="props">
                <Form-item prop="title">
                    <i-input type="text" v-model="props.parmas.title" placeholder="文章标题"></i-input>
                </Form-item>

                <Form-item prop="cat_id">
                    <Cascader :data="catList" v-model="props.parmas.cat_id" placeholder="文章分类"></Cascader>
                </Form-item>
            </template>

            <template slot="formBtn" scope="props">
                <i-button type="primary" @click="jumpPage('{{ route('admin.articles.create') }}')"><Icon type="plus-round"></Icon> 文章添加 </i-button>
            </template>
        </my-table>
    </div>
@endsection
@section('script')
    <!-- 本页面专属js 文件 -->

    <script type="text/javascript">

        var page = Util.Vue({
            el: "#app",
            data: {
                catList: [],
                currentRow:{},
                listConf: {
                    url: "{{ route('admin.articles.index') }}",
                    searchParams: {
                        name : ""
                    },
                    item: [],
                    columns: [
                        {type: 'index', align: 'center', width:40, fixed: 'left'},
                        {title: '标题', align: 'center', key: 'title', width: 200},
                        {title: '分类', align: 'center', key: 'cat_name', width: 150, render: (h, params) => {
                            if(params.row.article_cat != null){
                                return params.row.article_cat.name;
                            }
                        }},
                        {title: '关键词', align: 'center', key: 'keywords', width: 150},
                        {title: '状态', align: 'center', key: 'status_name', width: 100, render: (h, params) => {
                            return h('div', [
                                h('i-switch', {
                                    props: {
                                        value: params.row.status,
                                        // size: 'large',
                                        'true-value': 1,
                                        'false-value': 0,
                                    },
                                    on: {
                                        'on-change': (status) => {
                                            page.switchStatus(status, params.row.id);
                                        }
                                    }
                                }),
                            ])
                        }},
                        {title: '添加时间', align: 'center', key: 'created_at', width:160},
                        {title: '更新时间', align: 'center', key: 'updated_at', width:160},
                        {title: '操作', key: 'action', align: 'center',width:130, fixed: 'right',
                            render: (h, params) => {
                                return h('div', [
                                    h('Button', {
                                        props: {
                                            type: 'primary',
                                            size: 'small',
                                            icon: 'eye'
                                        },
                                        style: {
                                            marginRight: '5px',
                                            marginBottom: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                var id = params.row.id;
                                                page.jumpPage("/admin/articles/" + id);
                                            }
                                        }
                                    }),
                                    h('Button', {
                                        props: {
                                            type: 'primary',
                                            size: 'small',
                                            icon: 'edit'
                                        },
                                        style: {
                                            marginRight: '5px',
                                            marginBottom: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                var id = params.row.id;
                                                page.jumpPage("/admin/articles/" + id + "/edit");
                                            }
                                        }
                                    }),
                                    h('Button', {
                                        props: {
                                            type: 'error',
                                            size: 'small',
                                            icon: 'android-delete'
                                        },
                                        style: {
                                            marginRight: '5px',
                                            marginBottom: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                var id = params.row.id;
                                                page.userDelConf(id);
                                            }
                                        }
                                    }),
                                ]);
                            }
                        }
                    ]
                },
            },
            methods: {
                selectRow: function(index){
                    this.currentRow = index;
                },
                alertPage: function(path){
                    if(this.currentRow.id == undefined || this.currentRow.id == null || this.currentRow.id == ""){
                        this.$Notice.error({ title: '提示', desc: '请先选择一行记录' });
                    }else{
                        // do something
                    }
                },
                jumpPage: function(url){
                    window.location.href = url;
                },
                userDelConf: function (id){
                    var _this = this;
                    _this.$Modal.confirm({
                        title: "提示",
                        content: "确定删除吗？删除之后不可恢复",
                        onOk: function(){
                            _this.userDel(id);
                        },
                        onCancel: function(){
                            this.$Notice.error({ title: '提示', desc: '操作取消' });
                        }
                    });
                },
                userDel(id) {
                    var _this = this;
                    Util.ajax({
                        url: "/admin/articles/" + id,
                        method: "DELETE",
                        success: function(result){
                            if (result.error == 0) {
                                _this.$Notice.success({ title: '提示', desc: '删除成功' });
                                _this.$refs.listTable.listLoad();
                            }else {
                                _this.$Notice.error({ title: '提示', desc: result.info });
                            }
                        }
                    });
                },
                switchStatus(status, id) {
                    var _this = this;
                    Util.ajax({
                        url: "/admin/articles/" + id + '/updateStatus',
                        data: {status: status},
                        method: "PATCH",
                        success: function(result){
                            if (result.error == 0) {
                                _this.$Notice.success({ title: '提示', desc: '切换成功' });
                            }else {
                                _this.$Notice.error({ title: '提示', desc: result.info });
                            }
                        }
                    });
                }
            },
            created: function() {
                var _this = this;
                Util.ajax({
                    url: "{{ route('admin.articleCats.index') }}",
                    method: 'get',
                    success: function(result){
                        if (result.error == 0) {
                            _this.catList = result.result;
                        }
                    }
                });
            },
            mounted: function(){
                this.spinShow = false;
            }
        });
    </script>
@endsection
