
require('./bootstrap');

import Vue from 'vue';
import Vuelidate from  'vuelidate';
Vue.config.debug = true;
Vue.config.devtools = true;

Vue.use(Vuelidate);

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


//Filemanager
Vue.component('filemanager-app', require('./components/Filemanager/FilemanagerApp').default);


// App
const app = new Vue({
    el: '#app',
    data: {
        showCreateCourse: false
    }
});

