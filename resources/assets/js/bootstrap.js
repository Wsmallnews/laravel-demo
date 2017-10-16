
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// import Vue from 'vue'
// import iView from 'iview';

window.Util = {
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
    }
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
