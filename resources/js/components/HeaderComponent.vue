<template>
    <div class="header">
        <a href="" @click.prevent="changePage('Dashboard')">
            <img class="photo" src="/storage/imgbin-orange.jpg" alt="1" />
            <h1>Конференции.РФ</h1>
        </a>
        <div>
            <template v-if="user">
                <span v-if="userInfo?.FIO">{{ userInfo.FIO }}</span>
                <form @submit.prevent="logout" class="form-inline">
                    <button type="submit" class="btn-logout">Выйти</button>
                </form>
            </template>
            <template v-else>
                <a href="" class="btn-create" @click.prevent="changePage('Login')">Войти</a>
                <a href="" class="btn-create" @click.prevent="changePage('Register')">Регистрация</a>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HeaderComponent',
    props: ['datasend', 'changeToken', 'user', 'isAdmin', 'logout', 'changePage', 'userInfo'],
    data() {
        return {};
    },
    mounted() {},
    methods: {},
};
</script>
