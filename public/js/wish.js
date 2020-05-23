import {getWish, deleteWishAction} from "./wishActions.js";

const wishId = window.location.pathname.split('/')[2];

let app = new Vue({
    el: '#app',
    data: {
        id: wishId,
        name: '',
        link: '',
        description: ''
    },
    template: `
        <div>
            <h2>{{ name }}</h2>
            <p><a :href="link">{{ link }}</a></p>
            <p>{{ description }}</p>
            <button>Edit</button>
            <button @click="deleteItem">Delete</button>
            <p><a id="back" href="/">Back to wishlist</a></p>
        </div>`,
    created : async function() {
        let wish = await getWish(this.id);
        wish = wish[0];
        this.name = wish['wish'];
        this.link = wish['link'];
        this.description = wish['description'];
    },
    methods: {
        async deleteItem() {
            await deleteWishAction(this.id);
            document.getElementById('back').click();
        }
    }
});


