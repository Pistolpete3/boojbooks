<template>
    <div class="card mt-5 row">
        <div class="card-body col-8">
            <h2>Title {{ book.title }}</h2>
            <hr>
            <h6>By {{ book.author }}</h6>
            <br>
            <img :src=book.book_image class="rounded mx-auto img-fluid w-50">
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            book() {
                return this.$store.getters.getBook
            }
        },
        created() {
            this.$store.dispatch('fetchBook', this.$route.params.id);
        }
    };
</script>
