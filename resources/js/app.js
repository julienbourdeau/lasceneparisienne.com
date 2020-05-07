import 'alpinejs'

import Vue from 'vue';
import InstantSearch from 'vue-instantsearch';

Vue.use(InstantSearch);

Vue.component('search-container', require('./components/SearchContainer.vue').default);

new Vue({
    el: '#search',
});
