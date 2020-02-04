import Lists from "./components/Lists/Lists";
import List from "./components/Lists/List";
import Books from "./components/Books/Books";
import Book from "./components/Books/Book";
import Home from "./components/Home";
import Login from "./components/Auth/Login";
import Logout from "./components/Auth/Logout";
import ListForm from "./components/Lists/ListForm";

export const routes = [
    {
        path: '/',
        name: 'src',
        component: Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/logout',
        name: 'logout',
        component: Logout,
    },
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/books:id',
        name: 'books.show',
        component: Book,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/books',
        name: 'books.index',
        component: Books,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/lists/new',
        name: 'lists.make',
        component: ListForm,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/lists:id',
        name: 'lists.show',
        component: List,
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/lists',
        name: 'lists.index',
        component: Lists,
        meta: {
            requiresAuth: true,
        },
    },

];
