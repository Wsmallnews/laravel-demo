<template>
    <div class="table-index" style="width: 98%;">
        <Form ref="search" class="form-search" :model="cListConf.searchParams" inline v-if="searchShow">
            <slot name="formItem" :parmas="cListConf.searchParams" >

            </slot>

            <Form-item>
                <Button type="primary" icon="ios-search" @click="listSearch()">搜索</Button>
 <!--               <Button type="ghost" @click="listSearchReset()" style="margin-left: 8px">重置</Button>-->
            </Form-item>
        </Form>

        <div class="oper_div">
            <slot name="formBtn" >

            </slot>
        </div>

        <Table
            :loading="loading"
            :highlight-row="lighlightRow"
            :border="border"
            :stripe="stripe"
            :columns="cListConf.columns"
            :data="cListConf.item"
            @on-row-click="listSelect"
            >
        </Table>

        <div style="margin: 10px;overflow: hidden">
            <div style="float: right;">
                <Page
                    :total="cListConf.total"
                    :current="cListConf.current"
                    :page-size="cListConf.pageSize"
                    :show-elevator="showElevator"
                    :page-size-opts="pageSizeOpts"
                    :show-sizer="showSizer"
                    :show-total="showTotal"
                    @on-change="listChangePage"
                    @on-page-size-change="listChangeSize"
                    >
                </Page>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        props: [
            'listConf',
            'noSearch',
        ],
        data () {
            return {
                loading: true,
                lighlightRow: true,
                border: false,
                stripe: true,
                showSizer: true,    // 显示每页条数下拉框
                showTotal: true,
                showElevator: true,
                pageSizeOpts: [10, 30, 50, 100],
                defaultListConf: {
                    url: "",
                    current: 1,
                    pageSize: 10,
                    searchParams: {},
                    item: [],
                    columns: [],
                    queryParams: {}
                },
                cListConf: {}
            }
        },
        computed: {
            searchShow: function(){
                return this.noSearch == true ? false : true;
            }
        },
        methods: {
            // 列表 默认方法开始
            listConfMerge: function(){
                this.cListConf = Util.extend(this.defaultListConf, this.listConf);
            },
            listInit: function (){
                var _this = this;
                _this.cListConf['queryParams']['page'] = _this.cListConf['current'];
                _this.cListConf['queryParams']['page_size'] = _this.cListConf['pageSize'];
                _this.listLoad();
            },
            listLoadData: function (cb) {         // 只获取数据
                var _this = this;
                _this.listBaseRequest(cb);
            },
            listLoad: function () {      // 加载列表
                var _this = this;
                _this.loading = true;

                _this.listBaseRequest(function(result){
                    if (!result.error){
                        _this.loading = false;
                        var data = result.result;

                        _this.cListConf.item = data.data;
                        _this.cListConf['total'] = data.total;
                        _this.cListConf['current'] = data.current_page;
                    }
                })
            },
            listBaseRequest: function (cb) {      // ajax 请求
                var _this = this;

                Util.extend(_this.cListConf['queryParams'], _this.cListConf['searchParams']);
                Util.ajax({
                    url: _this.cListConf['url'],
                    data : _this.cListConf['queryParams'],
                    method:'get',
                    success: function (result){
                        if (cb != undefined) {
                            cb(result);
                            return true;
                        }else {
                            return result;
                        }
                    }
                });
            },
            listSearch: function(){         // 上下页
                var _this = this;

                _this.cListConf['queryParams']['page'] = 1;
                _this.listLoad();
            },
            listSearchReset () {                // 表单数据重置, name ,表单数据
                var _this = this;

                _this.$refs['search'].resetFields();
            },
            listChangePage: function(page){         // 上下页
                var _this = this;

                _this.cListConf['queryParams']['page'] = page;
                _this.listLoad();
            },
            listChangeSize: function(size){         // 每页条数
                var _this = this;

                _this.cListConf['queryParams']['page'] = 1;
                _this.cListConf['queryParams']['page_size'] = size;
                _this.listLoad();
            },
            listSelect: function(index){
                this.$emit('select', index);
            },
        },
        created: function () {
            this.listConfMerge();
            this.listInit();
        },
        mounted: function (){
        }
    };
</script>

<style scoped>
.oper_div{
	margin-bottom: 20px;
}

.ivu-form.form-search .ivu-cascader {
    width: 230px;
    margin-top: 2px;
}
</style>
