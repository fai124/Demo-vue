<template>
    <Login v-if="page == 'Login'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken" />
    <Register v-if="page == 'Register'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken" />
    <Dashboard v-if="page == 'Dashboard'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :userInfo="userInfo"
        @logout="logout" />
    <RoomCreate v-if="page == 'RoomCreate'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :userInfo="userInfo"
        @logout="logout" />
    <RoomEdit v-if="page == 'RoomEdit'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :pageId="pageId" :userInfo="userInfo"
        @logout="logout" />
    <BookingCreate v-if="page == 'BookingCreate'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :userInfo="userInfo"
        @logout="logout" />
    <BookingRoom v-if="page == 'BookingRoom'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :pageId="pageId" :userInfo="userInfo"
        @logout="logout" />
    <BookingMy v-if="page == 'BookingMy'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :userInfo="userInfo"
        @logout="logout" />
    <BookingAdmin v-if="page == 'BookingAdmin'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
        :logout="logout" :user="user" :isAdmin="isAdmin" :storage="storage" :userInfo="userInfo"
        @logout="logout" />
</template>

<script>
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Dashboard from './pages/Dashboard.vue';
import RoomCreate from './pages/RoomCreate.vue';
import RoomEdit from './pages/RoomEdit.vue';
import BookingCreate from './pages/BookingCreate.vue';
import BookingRoom from './pages/BookingRoom.vue';
import BookingMy from './pages/BookingMy.vue';
import BookingAdmin from './pages/BookingAdmin.vue';

export default {
    name: 'App',
    data() {
        return {
            API: '/api/',
            storage: '/storage/',
            user: false,
            isAdmin: false,
            userInfo: {},
            page: localStorage.getItem('page') || 'Dashboard',
            pageId: localStorage.getItem('pageId') || null,
        };
    },
    mounted() {
        this.getCsrfCookie();
        if (localStorage.getItem('token')) {
            this.getUser();
        }
    },
    methods: {
        getCsrfCookie() {
            fetch('/sanctum/csrf-cookie', {
                credentials: 'include',
            });
        },
        changeToken(token) {
            localStorage.setItem('token', token);
            this.user = true;
            this.getUser();
        },
        getUser() {
            this.datasend('user').then((response) => {
                this.user = true;
                this.userInfo = response;
                if (response.role == 'admin') {
                    this.isAdmin = true;
                }
            });
        },
        changePage(page, pageId = null) {
            this.page = page;
            this.pageId = pageId;
            localStorage.setItem('page', page);
            localStorage.setItem('pageId', pageId);
        },
        logout() {
            localStorage.removeItem('token');
            this.user = false;
            this.isAdmin = false;
            this.changePage('Dashboard');
        },
        async datasend(route, method = 'GET', formdata = null, userid = null) {
            const myHeaders = new Headers();
            myHeaders.append('Accept', 'application/json');
            myHeaders.append('X-Requested-With', 'XMLHttpRequest');

            if (userid) {
                myHeaders.append('userid', userid);
            }
            const token = localStorage.getItem('token');
            if (token) {
                myHeaders.append('Authorization', 'Bearer ' + token);
            }
            const requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: 'follow',
                credentials: 'include',
            };
            if (method != 'GET') {
                requestOptions.body = formdata;
            }
            try {
                const response = await fetch(this.API + route, requestOptions);
                if (response.status === 401) {
                    this.logout();
                    return { errors: { system: ['Сессия истекла. Войдите снова.'] } };
                }
                return await response.json();
            } catch (error) {
                return { errors: { system: ['Ошибка соединения с сервером'] } };
            }
        },
    },
    components: {
        Login,
        Register,
        Dashboard,
        RoomCreate,
        RoomEdit,
        BookingCreate,
        BookingRoom,
        BookingMy,
        BookingAdmin,
    },
};
</script>
