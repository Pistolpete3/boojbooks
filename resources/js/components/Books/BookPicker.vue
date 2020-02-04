<template>
    <books-table :books="books" :picker="true"></books-table>
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        data() {
            return {
                pagination: {}
            }
        },
        components: {
            draggable
        },
        computed: {
            books() {
                return this.$store.getters.getBooks
            },
            list() {
                return this.$store.getters.getList
            }
        },
        created() {
            this.$store.dispatch('fetchBooks')
        }
    };
</script>
