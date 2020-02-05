<template>
    <div class="card mt-5">
        <div class="card-body">
            <h2>Booj Books</h2>
            <p>A quick demo web-app written by Peter Seymour</p>
            <br>
            <div class="navbar-brand">
                <p>
                    Take a look at our <router-link :to="{ name: 'books.index' }">Books</router-link>
                </p>
                <span>
                    Build a <router-link :to="{ name: 'lists.index' }">List</router-link> or see examples
                </span>
            </div>
            <hr>
            <div>
                <h3>Logging In</h3>
<!--                @todo replace the block below with registration-->
                <p>First you will need to login to gain access to the site. Registration is under construction so please use one of the sample users from the table below. </p>
                <table class="table table-striped text-center align-middle">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Carl Sagan</td>
                        <td>sagan@cornell.edu</td>
                        <td>billions</td>
                    </tr>
                    <tr>
                        <td>Nikola Tesla</td>
                        <td>tesla@coil.com</td>
                        <td>pigeons</td>
                    </tr>
                    <tr>
                        <td>Marie Curie</td>
                        <td>curie@rad.org</td>
                        <td>radium</td>
                    </tr>
                    <tr>
                        <td>Albert Einstein</td>
                        <td>einstein@princeton.edu</td>
                        <td>emc2</td>
                    </tr>
                </table>
            </div>
            <hr>
        </div>
    </div>
</template>
