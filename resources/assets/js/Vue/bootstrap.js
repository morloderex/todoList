import Vue from 'vue'
Vue.use(require('vue-resource'));

import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed);

// Grab the CSRF Token
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

/**
 * Vue-resource equivalent to jwtAuth interceptor
 */
Vue.http.interceptors.push(function(request, next){
    var token;

    token = localStorage.getItem('jwt-token');
    if ( token !== null && token !== 'undefined') {
        Vue.http.headers.common['Authorization'] = token;
    }

    next(function (response) {
        if (response.status && response.status.code == 401) {
            localStorage.removeItem('jwt-token');
        }
        if (response.headers && response.headers.Authorization) {
            localStorage.setItem('jwt-token', response.headers.Authorization)
        }
        if (response.data && response.data.token && response.data.token.length > 10) {
            localStorage.setItem('jwt-token', 'Bearer ' + response.data.token);
        }
    })
});

require('../Laravel/Echo/bootstrap');