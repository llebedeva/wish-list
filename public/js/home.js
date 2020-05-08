import {getWishlist} from './wishActions.js';

Vue.component('wish', {
    props: {
        name: String,
        id: String
    },
    computed: {
        url: function() {
            return "/wish/" + this.id;
        }
    },
    template: `
    <div>
        <a v-bind:href="url">{{ name }}</a>
    </div>
    `
});

Vue.component('wish-modal', {
    template: `
    <div class="modal">
        <form class="modal-content">
        <span class="close" @click="hideModal">&times;</span>
            <label for="wish">Wish:</label>
            <br>
            <input type="text" id="wish" name="wish" required>
            <br>
            <label for="link">Reference:</label>
            <br>
            <input type="text" id="link" name="link">
            <br>
            <label for="description">Additional information:</label>
            <br>
            <textarea id="description" name="description" rows="3" cols="40"></textarea>
            <br>
            <input type="submit">
        </form>
    </div>
    `,
    methods: {
        hideModal: function () {
            this.$emit('hide-modal');
        }
    }
})

let app = new Vue({
    el: '#app',
    data: {
        wishlist: [],
        showWishModal: false
    },
    created : async function() {
        let wishlist = await getWishlist();
        wishlist.forEach(wish => {
            this.wishlist.push({
                id: wish['id'],
                name: wish['wish'],
                url: wish['link'],
                description: wish['description'],
                priority: wish['priority']
            });
        });
    },
    methods: {
        showModal: function () {
            this.showWishModal = true;
        },
        hideModal: function () {
            this.showWishModal = false;
        }
    }
});
