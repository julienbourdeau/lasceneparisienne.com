import Vue from 'vue';
import InstantSearch from 'vue-instantsearch';
import 'alpinejs'

window.mapboxgl = require('mapbox-gl/dist/mapbox-gl.js');

Vue.use(InstantSearch);

Vue.component('search-container', require('./components/SearchContainer.vue').default);

document.addEventListener("DOMContentLoaded", function(event) {
  new Vue({
    el: '#search',
  });
});
