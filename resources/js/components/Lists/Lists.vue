<template>
    <div>
        <div class="card mt-5">
            <div class="card-body">
                <h2>Existing Lists</h2>
                <hr>
                <lists-table :lists="lists"></lists-table>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <h2>Create a new List</h2>
                <hr>
                <form action="#" @submit.prevent="createList">
                    <div class="form-group d-flex flex-row">
                        <label for="listName" class="p-2"><h5>List Name: </h5></label>
                        <input v-model="list.name" class="form-control w-25 p-2" id="listName" placeholder="Awesome List" >
                        <button type="submit" class="btn btn-primary p-2 ml-3 h-25">Pick Books</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list: {
                    name: '',
                    books: [],
                    bookIds: [],
                }
            }
        },
        computed: {
            lists() {
                return this.$store.getters.getLists
            }
        },
        created() {
            this.$store.dispatch('fetchLists');
        },
        methods: {
            createList() {
                this.$store.commit('setList', this.list)
                return this.$router.push({name: 'lists.make'})
            }
        }
    };
</script>
