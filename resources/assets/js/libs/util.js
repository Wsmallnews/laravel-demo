const Util = {
    Vue: function (options) {
        var defaults = {
            el: '#app',
            data: {
                theme: 'dark',  // light
                modeTop: 'horizontal',
                modeMenu: 'vertical',
                lighlightRow: true,
                border: true,
                stripe: true,
            }
        };

        var cur_options = this.extend(defaults, options);

        return new Vue(cur_options);
    },
    ajax: function (options) {
        var defaults_options = {
            url:'',
            method:'get',
        }

        if (options.data != undefined) {
            options.data.timeStamp = (new Date()).getTime();
        }

        if (options.method == 'get' && options.params == undefined) {
            options.params = options.data != undefined ? options.data : {};
        }

        $.extend(defaults_options, options);

        axios(defaults_options)
            .then(function (response) {
                if (defaults_options.success) {
                    defaults_options.success(response.data, response);
                }else {
                    // iView.Notice.success({ title: '提示', desc: '操作成功' });
                }
            })
            .catch(function (error) {
                if (error.response) {
                    if (defaults_options.error) {
                        defaults_options.error(response);
                    }else {
                        // iView.Notice.error({ title: '提示', desc: '操作失败' });
                    }
                } else {
                    // iView.Notice.error({ title: '提示', desc: error.message });
                }
            });
    },
    extend: function (objFirst, objSecond, mergeArray) {
        if (typeof objSecond === 'object' && !isNaN(objSecond.length)) {    // 如果 第二个对象 是数组对象
            if (mergeArray == undefined || mergeArray == null) {
                objFirst = objSecond;   // 直接覆盖
            }else {
                objFirst = objFirst.concat(objSecond);
            }
        }else {
            for (var s in objSecond) {
                if (objFirst[s] == undefined || (typeof objFirst[s] != 'object' && typeof objSecond[s] === 'object')) { // 如果 objFrist 不存在, 或者类型不一致 ，直接赋值,
                    objFirst[s] = objSecond[s];
                } else if (typeof objSecond[s] === 'object' && !isNaN(objSecond[s].length)){    // 如果 是数组对象，直接赋值,默认前面也是数组对象
                    if (mergeArray == undefined || mergeArray == null) {      // 不合并数组
                        objFirst[s] = objSecond[s];     // 默认直接赋值
                    }else {
                        objFirst[s] = objFirst[s].concat(objSecond[s]);     // 合并
                    }
                } else if (typeof objSecond[s] === 'object') {          // 如果是对象
                    objFirst[s] = Util.extend(objFirst[s], objSecond[s], mergeArray);
                } else {                        // 直接赋值
                    objFirst[s] = objSecond[s];
                }
            }
        }

        return objFirst;
    },
    initEdit: function(obj, options){
        window.UEDITOR_HOME_URL = "/public/plus/ueditor";
        window.UEDITOR_CONFIG.toolbars = [
            [
                'fullscreen', 'source', 'undo', 'redo', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough',
                'superscript', 'subscript', 'removeformat', 'formatmatch',
                'autotypeset', 'blockquote', 'pasteplain',
            ],
            [
                'forecolor',
                'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',
                'cleardoc', 'simpleupload', 'insertimage'
            ]
        ];
        window.UEDITOR_CONFIG.serverUrl = "/myEditorUpload";

        var ue = UE.getEditor(obj);
        ue.ready(function() {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            ue.execCommand('serverparam', '_token', token.content);
            ue.execCommand('serverparam', 'file_type', 'editor');
        });

        return ue;
    }
}

export default Util;
