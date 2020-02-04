<template>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="navbar-brand">Booj Books</div>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <router-link :to="{ name: 'home' }" class="nav-item nav-link">Home</router-link>
                <router-link :to="{ name: 'books.index' }" class="nav-item nav-link">Books</router-link>
                <router-link :to="{ name: 'lists.index' }" class="nav-item nav-link">Lists</router-link>
            </div>
            <div class="navbar-nav ml-auto">
                <router-link v-if="!loggedIn" :to="{ name: 'login' }" class="nav-item nav-link">Login</router-link>
                <router-link v-if="loggedIn" :to="{ name: 'logout' }" class="nav-item nav-link">Logout</router-link>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        computed: {
            loggedIn() {
                return this.$store.getters.loggedIn
            }
        }
    }
</script>
