<template>
    <div class="card mt-5">
        <div class="card-body">
            <h2>Books</h2>
            <hr>
            <books-table :books="books"></books-table>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            books() {
                return this.$store.getters.getBooks
            }
        },
        created() {
            this.$store.dispatch('fetchBooks');
        }
    };
</script>
