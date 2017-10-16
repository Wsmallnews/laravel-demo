@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="articles">
        <my-table :list-conf="listConf" ref="listTable" :noSearch="true">
            <template slot="formItem" scope="props">
                <Form-item prop="order_code">
                    <i-input type="text" v-model="props.parmas.order_code" placeholder="文章标题"></i-input>
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
                currentRow:{},
                listConf: {
                    url: "{{ route('admin.articles.index') }}",
                    searchParams: {
                        name : ""
                    },
                    item: [],
                    columns: [
                        {type: 'index', align: 'center',width:100},
                        {title: '标题', key: 'name'},
                        {title: '分类', key: 'cat_name', render: (h, params) => {
                            if(params.row.articleCat != null){
                                return params.row.articleCat.name;
                            }
                        }},
                        {title: '关键词', key: 'keywords'},
                        {title: '状态', key: 'status_name'},
                        {title: '添加时间', key: 'created_at'},
                        {title: '更新时间', key: 'updated_at',width:200},
                        {title: '操作', key: 'action',align: 'center',width:100,
                            render: (h, params) => {
                                return h('div', [
                                    h('Button', {
                                        props: {
                                            type: 'error',
                                            size: 'small'
                                        },
                                        style: {
                                            marginRight: '5px',
                                            marginBottom: '5px'
                                        },
                                        on: {
                                            click: () => {
                                                var id = params.row.id;
                                                this.userDelConf(id);
                                            }
                                        }
                                    }, '删除'),
                                ]);
                            }
                        }
                    ]
                },
            },
            methods: {
                jumpPage: function(url){
                    window.location.href = url;
                }
            }
        });
    </script>
@endsection
