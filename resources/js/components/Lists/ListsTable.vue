<template>
    <div class="row">
        <div class="col-8">
            <table class="table table-striped text-center align-middle">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Book Count</th>
                </tr>
                </thead>
                <draggable v-model="lists" tag="tbody">
                    <tr v-for="list in lists" :key="list.id">
                        <td class="align-middle">{{ list.id }}</td>
                        <td class="align-middle">
                            <router-link :to="{ name: 'lists.show', params: { id:list.id } }">
                                {{ list.name }}
                            </router-link>
                        </td>
                        <td>{{list.books.length}}</td>
                    </tr>
                </draggable>
            </table>
        </div>
    </div>
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        components: {
            draggable
        },
        props: {
           lists: {
               required: true
           }
        }
    };
</script>
