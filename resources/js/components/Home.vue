<template>
    <div class="card mt-5">
        <div class="card-body">
            <h2>Booj Books</h2>
            <p>A quick demo web-app written by Peter Seymour</p>
            <br>
            <div class="navbar-brand">
                <p>
                    Take a look at our <router-link :to="{ name: 'books.index' }">Books</router-link>
                </p>
                <span>
                    Build a <router-link :to="{ name: 'lists.index' }">List</router-link> or see examples
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            pressed() {
                this.$store.dispatch('fetchToken', {
                    username: 'tesla@coil.com',
                    password: 'pigeons',
                }).then(() => {
                    this.$router.push({ name: 'home'});
                })
            },
            destroy() {
                this.$store.dispatch('destroyToken').then(() => {
                    this.$router.push({ name: 'home'});
                })
            }
        }
    }
</script>
