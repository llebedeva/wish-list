import {getWishlist, createWishAction, updateWishAction, deleteWishAction} from './wishActions.js';

Vue.component('create-button', {
    template: `
    <button @click="showWishModal">New wish</button>
    `,
    methods: {
        showWishModal() {
            this.$emit('show-wish-modal', {
                id: null,
                name: '',
                link: '',
                description: ''
            });
        }
    }
});

Vue.component('wish-item', {
    props: {
        item: Object
    },
    computed: {
        url: function() {
            return "/wish/" + this.id;
        },
    },
    template: `
    <div>
        <a v-bind:href="url">{{ name }}</a>
        <button @click="showWishModal">Edit</button>
        <button @click="deleteItem">Delete</button>
    </div>
    `,
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
        showWishModal() {
            this.$emit('show-wish-modal', {
                id: this.id,
                name: this.name,
                link: this.link,
                description: this.description
            });
        }
    }
});

Vue.component('wish-modal', {
    props: {
        wishObj: {
            type: Object
        },
    },
    created: function() {
        this.id = this.wishObj['id'];
        this.name = this.wishObj['name'];
        this.link = this.wishObj['link'];
        this.description = this.wishObj['description'];
    },
    template: `
    <div class="modal">
        <form class="modal-content" @submit.prevent="formSubmit">
        <span class="close" @click="hideModal">&times;</span>
            <label for="wish">Wish:</label>
            <br>
            <input v-model.trim="name" type="text" required>
            <br>
            <label for="link">Reference:</label>
            <br>
            <input v-model.trim="link" type="text">
            <br>
            <label for="description">Additional information:</label>
            <br>
            <textarea v-model.trim="description" rows="3" cols="40"></textarea>
            <br>
            <input type="submit">
        </form>
    </div>
    `,
    methods: {
        hideModal() {
            this.$emit('hide-modal');
        },
        async formSubmit() {
            if (this.id) {
                if (await updateWishAction(this.id, this.name, this.link, this.description)) {
                    app.updateWishItem(this.id, this.name, this.link, this.description);
                    this.hideModal();
                }
            } else {
                this.id = await createWishAction(this.name, this.link, this.description);
                if (this.id) {
                    app.addWishItem(this.id, this.name, this.link, this.description);
                    this.hideModal();
                }
            }
        }
    }
})

let app = new Vue({
    el: '#app',
    template: `<div>
        <h2>I wish...</h2>
        <p v-if="!wishlist.length">You don't have any wishes yet. Please, create your first wish.</p>
        <create-button @show-wish-modal="showWishModal"></create-button>
        <wish-item @show-wish-modal="showWishModal" 
        v-for="item in wishlist"
              :item="item"
        ></wish-item>

        <wish-modal 
        :wishObj="wishObj"
        v-show="isShownWishModal" 
        @hide-modal="hideModal"
        ></wish-modal>
        </div>`,
    data: {
        wishlist: [],
        isShownWishModal: false,
        wishObj: {}
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
        showWishModal(wishObj) {
            this.isShownWishModal = true;
            this.wishObj = wishObj;
        },
        hideModal() {
            this.isShownWishModal = false;
        },
        addWishItem(id, name, link, description) {
            this.wishlist.push({
                id: id,
                name: name,
                link: link,
                description: description
            });
        },
        updateWishItem(id, name, link, description) {
            //
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
