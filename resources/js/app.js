require('./bootstrap');

import Vue from 'vue';
import InstantSearch from 'vue-instantsearch';
import algoliasearch from 'algoliasearch/lite';

Vue.use(InstantSearch);

new Vue({
    el: '#app',
    data: {
        searchClient: algoliasearch(
            'YourApplicationID',
            'YourAdminAPIKey',
        ),
    },
});

window.toggleMenu = function() {
    $('#nav').slideToggle();
}
