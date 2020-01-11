import lodash from "lodash";
import anime from "animejs";
import jquery from "jquery";
import axios from "axios";

window._ = lodash;
window.anime = anime;
window.$ = window.jQuery = jquery;


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
