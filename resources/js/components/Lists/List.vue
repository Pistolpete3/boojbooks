<template>
    <div class="card mt-5 row">
        <div class="card-body col-8">
            <h3>{{ list.name }}</h3>
            <hr>
            <books-table :books="list.books"></books-table>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            list() {
                return this.$store.getters.getList
            }
        },
        created() {
            this.$store.dispatch('fetchList', this.$route.params.id);
        }
    };
</script>
