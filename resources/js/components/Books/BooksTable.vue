<template>
    <div class="p-3 w-100">
        <input type="text" v-model="search" class="form-control w-25 mb-3 p-3 float-right" placeholder="Search"/>
        <button v-if="picker" v-on:click="createList" class="form-control w-25 mb-3 float-left btn btn-primary">Create
            List
        </button>
        <table class="table table-striped text-center align-middle">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Rank</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Cover</th>
                <th v-if="picker" scope="col">Select</th>
            </tr>
            </thead>
            <draggable tag="tbody">
                <tr v-for="book in filteredBooks" :key="book.id">
                    <td class="align-middle">
                        <router-link :to="{ name: 'books.show', params: { id:book.id } }">{{ book.id }}
                        </router-link>
                    </td>
                    <td class="align-middle">{{ book.title }}</td>
                    <td class="align-middle">{{ book.author }}</td>
                    <td class="align-middle w-25">
                        <router-link :to="{ name: 'books.show', params: { id:book.id } }">
                            <img :src=book.book_image class="rounded w-50">
                        </router-link>
                    </td>
                    <td v-if="picker" class="align-middle">
                        <form>
                            <div class="custom-control custom-switch">
                                <input @change="check($event)" :value="book.id" :id="book.id" type="checkbox"
                                       class="custom-control-input">
                                <label class="custom-control-label" :for="book.id"></label>
                            </div>
                        </form>
                    </td>
                </tr>
            </draggable>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: '',
            }
        },
        props: {
            books: {
                required: true
            },
            picker: {
                required: false
            },
        },
        methods: {
            check(event) {
                this.$store.commit('changeListBook', {
                    bookId: event.target.id,
                    addToList: event.target.checked,
                })
            },
            createList() {
                this.$store.dispatch('createList')
                    .then(() => {
                        this.$router.push({name: 'lists.index'})
                    })
            }
        },
        computed: {
            filteredBooks: function () {
                if (this.search) {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().match(this.search.toLowerCase()) ||
                            book.author.toLowerCase().match(this.search.toLowerCase());
                    })
                } else {
                    return this.books
                }
            }
        },
    };
</script>
