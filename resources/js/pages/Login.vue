<template>
    <div class="auth-page">
        <div class="header">
            <a href="" @click.prevent="changePage('Dashboard')">
                <img class="photo" src="/storage/imgbin-orange.jpg" alt="1" />
                <h1>Конференции.РФ</h1>
            </a>
        </div>
        <div class="form-container">
            <h2>Авторизация</h2>
            <form @submit.prevent="doLogin">
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" placeholder="Введите логин" v-model="login" />
                <div class="error-message" v-if="errors.login">{{ errors.login.join('. ') }}</div>

                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" placeholder="Введите пароль" v-model="password" />
                <div class="error-message" v-if="errors.password">{{ errors.password.join('. ') }}</div>

                <div class="error-message" v-if="errors.system">{{ errors.system.join('. ') }}</div>

                <button type="submit">Войти</button>
            </form>
            <p class="link">Ещё не зарегистрированы? <a href="" @click.prevent="changePage('Register')">Регистрация</a></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    props: ['datasend', 'changePage', 'changeToken'],
    data() {
        return {
            login: null,
            password: null,
            errors: {},
            loading: false,
        };
    },
    methods: {
        doLogin() {
            this.errors = {};
            let formdata = new FormData();
            if (this.login) formdata.append('login', this.login);
            if (this.password) formdata.append('password', this.password);

            this.datasend('login', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                    if (result.token) {
                        this.changeToken(result.token);
                        this.changePage('Dashboard');
                    }
                });
        },
    },
};
</script>
