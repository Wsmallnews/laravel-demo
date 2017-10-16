<template>
    <div class="upload-index">
        <div class="upload-list" v-for="(item,index) in uploadList">
            <template v-if="item.status === 'finished'">
                <img :src="item.url">
                <div class="upload-list-cover">
                    <Icon type="ios-eye-outline" @click.native="handleView(item)"></Icon>
                    <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                </div>
            </template>
            <template v-else>
                <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
            </template>
        </div>
        <Upload
            ref="upload"
            :show-upload-list="cUploadConf.showUploadList"
            :default-file-list="cUploadConf.defaultList"
            :headers="cUploadConf.headers"
            :name="cUploadConf.name"
            :data="cUploadConf.data"
            :on-success="handleSuccess"
            :format="cUploadConf.format"
            :max-size="cUploadConf.maxSize"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            :multiple="cUploadConf.multiple"
            :type="cUploadConf.type"
            :action="cUploadConf.action"
            style="display: inline-block;width:58px;">
            <div style="width: 58px;height:58px;line-height: 58px;">
                <Icon type="camera" size="20"></Icon>
            </div>
        </Upload>
        <Modal title="查看图片" v-model="cUploadConf.visible">
            <img :src="cUploadConf.maxImg" v-if="cUploadConf.visible" style="width: 100%">
        </Modal>
    </div>
</template>
<script>
    import Util from '@/libs/util';
    // import { getToken } from '@/libs/auth';

    export default {
        props: [
            'uploadConf',
        ],
        data () {
            return {
                defaultUploadConf: {
                    showUploadList: false,
                    defaultList: [],
                    format: ['jpg','jpeg','png', 'gif'],
                    name: "FileContent",
                    maxSize: 10240,      // 10M,
                    multiple: false,
                    type: "drag",
                    imgName: '',
                    visible: false,
                },
                cUploadConf: {},
                uploadList: []
            }
        },
        computed: {

        },
        methods: {
            uploadConfMerge: function(){
                this.cUploadConf = Util.extend(this.defaultUploadConf, this.uploadConf);
            },
            handleSuccess (res, file) {
                // res 服务端返回，file 处理之后的结果，res == file.response;
                if (res.error == 0) {
                    file.url = res.filename;
                    file.name = file.name;

                    if (this.cUploadConf.multiple) {
                        this.uploadList.push(file);
                    }else {
                        this.uploadList = [file];
                    }
                }else {
                    this.$Notice.warning({
                        title: '图片上传失败',
                        desc: res.info
                    });
                }
            },
            handleFormatError (file) {
                // file 原始文件内容，包括，原始文件名， 修改时间大小，类型
                var format_str = " ";
                var format = this.cUploadConf.format;
                for (var i in format) {
                    format_str += format[i] + " ";
                }
                this.$Notice.warning({
                    title: '文件格式不正确',
                    desc: '文件 ' + file.name + ' 格式不正确，请上传'+ format_str +'格式的图片。'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: '超出文件大小限制',
                    desc: '文件 ' + file.name + ' 太大，不能超过 10M。'
                });
            },
            handleBeforeUpload () {
                const img_length = this.cUploadConf.multiple ? 10 : 1;
                const check = this.uploadList.length <= img_length;
                if (!check) {
                    this.$Notice.warning({
                        title: '最多只能上传 '+ img_length +' 张图片。'
                    });
                }
                return check;
            },
            handleRemove (file) {
                const fileList = this.$refs.upload.fileList;
                this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
            },
            handleView (file) {
                this.cUploadConf.maxImg = file['url'];
                this.cUploadConf.visible = true;
            },
        },
        created: function () {
            this.uploadConfMerge();
        },
        mounted: function (){
            this.uploadList = this.uploadList.concat(this.$refs.upload.fileList);
        }
    };
</script>

<style scoped>
    .upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .upload-list img{
        width: 100%;
        height: 100%;
    }
    .upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .upload-list:hover .upload-list-cover{
        display: block;
    }
    .upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
</style>
