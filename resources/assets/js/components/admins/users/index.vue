<template>
    <div class="users-index">
        <myTable :listConf="listConf" ref="listTable" @select="selectRow">
            <template slot="formItem" scope="props">
                <Form-item prop="name">
                    <Input type="text" v-model="props.parmas.name" placeholder="搜索用户"></Input>
                </Form-item>
            </template>

            <template slot="formBtn" scope="props">
                <i-button type="primary" @click="jumpPage({path: '/users/create'})"><Icon type="plus-round"></Icon> 代理商添加 </i-button>

                <i-button type="primary" @click="alertPage({path: '/users/'+ currentRow.id +'/setting'})"><Icon type="ios-eye"></Icon> 查看模块价格 </i-button>

                <i-button type="primary" @click="alertPage({path: '/users/'+ currentRow.id +'/customList'})"><Icon type="ios-eye"></Icon> 查看客户 </i-button>
            </template>
        </myTable>
    </div>
</template>

<script>
    import myTable from '@/components/admins/includes/myTable';

    export default {
        components: {
            myTable
        },
        data () {
            return {
                currentRow:{},
                listConf: {
                    url: "/api/users",
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
                        {title: '操作', key: 'action',align: 'center',width:500,
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
        },
        methods: {
            selectRow: function(index){
                this.currentRow = index;
            },
            alertPage: function(path){
                if(this.currentRow.id == undefined || this.currentRow.id == null || this.currentRow.id == ""){
                    this.$Notice.error({ title: '提示', desc: '请先选择一行记录' });
                }else{
                    this.$router.push(path);
                }
            },
            jumpPage: function(path){
                this.$router.push(path);
            },
            userDelConf: function (id){
                var _this = this;
                _this.$Modal.confirm({
                    title: "提示",
                    content: "此为永久删除，确定删除吗？",
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
                    url: "/api/users/" + id,
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
            }
        },
        created: function () {

        },
        mounted: function (){
        }
    }
</script>
