const NotFound = { template: '<p>Страница не найдена</p>' }
const Home = { template: '<p>home</p>' }
const Wish = { template: '<p>wish</p>' }

const routes = {
    '/': Home,
    '/wish': Wish
}

new Vue({
    el: '#app',
    data: {
        currentRoute: window.location.pathname
    },
    computed: {
        ViewComponent () {
            return routes[this.currentRoute] || NotFound
        }
    },
    render (h) { return h(this.ViewComponent) }
});
