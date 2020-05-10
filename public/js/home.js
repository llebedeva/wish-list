import {getWishlist, deleteWishAction} from './wishActions.js';

Vue.component('wish-item', {
    props: {
        item: Object
    },
    computed: {
        url: function() {
            return "/wish/" + this.id;
        },
    },
    created: function() {
        this.id = this.item['id'];
        this.name = this.item['name'];
        this.link = this.item['link'];
        this.description = this.item['description'];
        this.priority = this.item['priority'];
    },
    methods: {
        async deleteItem() {
            if (await deleteWishAction(this.id)) {
                app.removeWishItem(this.id);
            }
        },
    },
    template: `
    <div>
        <a v-bind:href="url">{{ name }}</a>
        <button>Edit</button>
        <button @click="deleteItem">Delete</button>
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
                link: wish['link'],
                description: wish['description'],
                priority: wish['priority']
            });
        });
    },
    methods: {
        showModal() {
            this.showWishModal = true;
        },
        hideModal() {
            this.showWishModal = false;
        },
        removeWishItem(id) {
            let index = 0;
            for (let item of this.wishlist) {
                if (item.id === id) {
                    app.wishlist.splice(index, 1);
                    break;
                }
                index++;
            }
        }
    }
});