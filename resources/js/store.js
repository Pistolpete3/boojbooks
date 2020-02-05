import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);
axios.defaults.baseURL = process.env.MIX_APP_URL + '/api/';

export const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        pagination: {},
        books: [],
        book: {
            id: '',
            title: '',
            author: '',
            book_image: '',
        },
        lists: [],
        list: {
            id: '',
            name: '',
            books: [],
            bookIds: [],
        },
    },
    getters: {
        getToken(state) {
          return state.token;
        },
        loggedIn(state) {
            return state.token != null;
        },
        getBooks(state) {
            return state.books;
        },
        getBook(state) {
            return state.book;
        },
        getLists(state) {
            return state.lists;
        },
        getList(state) {
            return state.list;
        },
    },
    mutations: {
        setToken(state, token) {
            state.token = token
        },
        destroyToken(state) {
            state.token = null;
        },
        makePagination(state, meta, links) {
            state.pagination = {
                meta: meta,
                links: links
            }
        },
        setBooks(state, books) {
            state.books = books
        },
        setBook(state, book) {
            state.book = book
        },
        setLists(state, lists) {
            state.lists = lists
        },
        setList(state, list) {
            state.list = list
        },
        changeListBook(state, payload) {
            if (payload.addToList) {
                state.list.bookIds.push(parseInt(payload.bookId))
            } else {
                state.list.bookIds = state.list.bookIds.filter(item => item !== parseInt(payload.bookId))
            }
        }
    },
    actions: {
        fetchToken(context, credentials) {
            return new Promise((resolve, reject) => {
                axios.post('login', {
                    username: credentials.username,
                    password: credentials.password
                }).then(response => {
                    const token = response.data.access_token;
                    if (token !== 'undefined') {
                        localStorage.setItem('access_token', token);
                        context.commit('setToken', token);
                    }
                    resolve(response);
                }).then(error => {
                    console.log(error);
                    reject(error);
                })
            })
        },
        destroyToken(context) {
            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
                    axios.post('logout').then(response => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        resolve(response);
                    }).then(error => {
                        localStorage.removeItem('access_token');
                        context.commit('destroyToken');
                        console.log(error);
                        reject(error);
                    })
                })
            }
        },
        fetchBooks(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('books')
                .then(response => {
                    context.commit('setBooks', response.data.data)
                    context.commit('makePagination', response.data.meta, response.data.links)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        fetchBook(context, bookId) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('books/' + bookId)
                .then(response => {
                    context.commit('setBook', response.data.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        fetchLists(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('lists')
                .then(response => {
                    context.commit('setLists', response.data.data)
                    context.commit('makePagination', response.data.meta, response.data.links)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        fetchList(context, listId) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('lists/' + listId)
                .then(response => {
                    context.commit('setList', response.data.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        createList(context) {
            return new Promise((resolve, reject) => {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
                axios.post('lists', context.state.list)
                    .then(response => {
                        resolve(response);
                }).then(error => {
                    console.log(error);
                    reject(error);
                })
            })
        },
    }
})
