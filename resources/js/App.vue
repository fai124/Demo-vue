<template>
    <div id="wrapper">
        <Login v-if="page == 'Login'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken" />
        <Register v-if="page == 'Register'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken" />
        <Dashboard v-if="page == 'Dashboard'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :userInfo="userInfo" />
        <RoomCreate v-if="page == 'RoomCreate'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :userInfo="userInfo" />
        <RoomEdit v-if="page == 'RoomEdit'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :pageId="pageId" :userInfo="userInfo" />
        <BookingCreate v-if="page == 'BookingCreate'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :userInfo="userInfo" />
        <BookingRoom v-if="page == 'BookingRoom'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :pageId="pageId" :userInfo="userInfo" />
        <BookingMy v-if="page == 'BookingMy'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :userInfo="userInfo" />
        <BookingAdmin v-if="page == 'BookingAdmin'" :datasend="datasend" :changePage="changePage" :changeToken="changeToken"
            :logout="logout" :user="user" :isAdmin="isAdmin" :storage="PUBLIC" :userInfo="userInfo" />
    </div>
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
            page: localStorage.getItem('page') || 'Dashboard',
            pageId: localStorage.getItem('pageId') || null,
            API: '/api/',
            PUBLIC: '/storage/',
            user: false,
            isAdmin: false,
            userInfo: {},
        };
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
    mounted() {
        if (localStorage.getItem('token')) {
            this.getUser();
        }
    },
    methods: {
        logout() {
            this.datasend('logout', 'POST')
                .then((result) => {
                    if (result) {
                        localStorage.removeItem('token');
                        this.changePage('Dashboard');
                        this.user = false;
                        this.isAdmin = false;
                        this.userInfo = {};
                        this.page = 'Dashboard';
                        this.pageId = null;
                        console.log(result);
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        changePage(page, pageId = null) {
            this.page = page;
            this.pageId = pageId;
            localStorage.setItem('page', page);
            localStorage.setItem('pageId', pageId);
        },

        getUser() {
            this.datasend('user')
                .then((response) => {
                    this.user = true;
                    this.userInfo = response;
                    if (response.role == 'admin') {
                        this.isAdmin = true;
                    }
                })
                .catch((error) => {
                    console.error(error);
                    localStorage.removeItem('token');
                });
        },

        datasend(route, method, formdata) {
            if (method === undefined) method = 'GET';
            if (formdata === undefined) formdata = null;

            let myHeaders = new Headers();
            myHeaders.append('Accept', 'application/json');

            if (localStorage.getItem('token')) {
                myHeaders.append('Authorization', 'Bearer ' + localStorage.getItem('token'));
            }

            let requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: 'follow',
            };

            if (method != 'GET') {
                requestOptions.body = formdata;
            }

            return fetch(this.API + route, requestOptions).then((response) => {
                if (response.status == 401) {
                    localStorage.removeItem('token');
                    this.changePage('Dashboard');
                    this.user = false;
                    this.isAdmin = false;
                    this.userInfo = {};
                }
                return response.json();
            });
        },

        changeToken(token) {
            localStorage.setItem('token', token);
            this.user = true;
            this.getUser();
        },
    },
};
</script>
