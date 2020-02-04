<template>
    <div class="card mt-5 row">
        <div class="card-body">
            <h3>{{ list.name }}</h3>
            <hr>
            <book-picker></book-picker>
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
    };
</script>
