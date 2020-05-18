import {getWishlist, createWishAction, updateWishAction, deleteWishAction} from './wishActions.js';

Vue.component('wish-item', {
    props: {
        item: Object,
        show: Function
    },
    computed: {
        url: function() {
            return "/wish/" + this.id;
        },
    },
    template: `
    <div>
        <a v-bind:href="url">{{ name }}</a>
        <button @click="show(item)">Edit</button>
        <button @click="deleteItem">Delete</button>
    </div>
    `,
    created: function() {
        this.id = this.item['id'];
        this.name = this.item['name'];
    },
    methods: {
        async deleteItem() {
            if (await deleteWishAction(this.id)) {
                app.removeWishItem(this.id);
            }
        }
    }
});

Vue.component('wish-modal', {
    template: `
    <div class="modal">
        <div class="modal-content">
            <span class="close" @click="hideModal">&times;</span>
            <slot></slot>
        </div>
    </div>
    `,
    methods: {
        hideModal() {
            this.$emit('hide');
        }
    }
});

let app = new Vue({
    el: '#app',
    template: `
        <div>
            <h2>I wish...</h2>
            <p v-if="!wishlist.length">You don't have any wishes yet. Please, create your first wish.</p>
            <button @click="showModal">New wish</button>
            <wish-item v-for="item in wishlist"
                  :item="item"
                  :show="showModal"
            ></wish-item>
            <wish-modal v-show="isModalVisible" @hide="hideModal">
                <form @submit.prevent="formSubmit">
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
            </wish-modal>
        </div>`,
    data: {
        wishlist: [],
        isModalVisible: false,
        id: null,
        name: '',
        link: '',
        description: ''
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
        showModal(item=null) {
            if (item) {
                this.id = item['id'];
                this.name = item['name'];
                this.link = item['link'];
                this.description = item['description'];
            }
            this.isModalVisible = true;
        },
        hideModal() {
            this.isModalVisible = false;
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
});
