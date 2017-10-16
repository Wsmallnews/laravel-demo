@extends('admin.layouts.admin')

@section('link')
    <!-- 本页面专属css 文件 -->
    @parent
@endsection

@section('content')
    <div class="users">

        <my-table :list-conf="listConf" ref="listTable" :noSearch="true">
            <template slot="formItem" scope="props">
                <Form-item prop="order_code">
                    <i-input type="text" v-model="props.parmas.order_code" placeholder="用户名"></i-input>
                </Form-item>
            </template>

            <template slot="formBtn" scope="props">
                <i-button type="primary" @click="jumpPage('{{ route('admin.users.index') }}')"><Icon type="plus-round"></Icon> 用户列表 </i-button>
            </template>

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
                currentRow:{},
                listConf: {
                    url: "{{ route('admin.users.index') }}",
                    searchParams: {
                        name : ""
                    },
                    item: [],
                    columns: [
                        {type: 'index', align: 'center',width:100},
                        {title: '用户', key: 'name'},
                        {title: '手机', key: 'phone'},
                        {title: '邮箱', key: 'email'},
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
            }
        });
    </script>
@endsection
