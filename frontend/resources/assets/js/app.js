import Vue from 'vue';

var app = new Vue({
    el: '#app',
    data: {
        isHover: false,
        isScrollDown: false,
        documentLastScrollTop: 0
    },
    methods: {
        handleIsHover: function() {
            this.isHover = !('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);
        },
        handleDocumentScroll: function() {
            var st = window.pageYOffset || document.documentElement.scrollTop;
            
            this.isScrollDown = st>this.documentLastScrollTop;

            this.documentLastScrollTop = st <= 0 ? 0 : st;
        },
    },
    computed: {
    },
    mounted () {
        this.handleIsHover();
    },
    created () {
    },
    destroyed () {
    }
});

Vue.config.devtools = false;
Vue.config.debug = true;
Vue.config.silent = false;