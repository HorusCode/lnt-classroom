
require('./bootstrap');

import Vue from 'vue';
Vue.config.debug = true;
Vue.config.devtools = true;



const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));



// App
const app = new Vue({
    el: '#app',
    data: {
        showCreateCourse: false
    }
});

