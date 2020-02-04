<template>
    <div class="card mt-5">
        <div class="card-body">
            <h2>Login</h2>
            <form action="#" @submit.prevent="login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input v-model="username" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" >
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'login',
        data() {
            return {
                username: '',
                password: '',
            }
        },
        methods: {
            login() {
                this.$store.dispatch('fetchToken', {
                    username: this.username,
                    password: this.password,
                }).then(() => {
                    this.$router.push({name: 'home'})
                })
            }
        }
    }
</script>
