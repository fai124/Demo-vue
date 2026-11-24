<template>
    <div class="auth-page">
        <div class="header">
            <a href="" @click.prevent="changePage('Dashboard')">
                <img class="photo" src="/storage/imgbin-orange.jpg" alt="1" />
                <h1>Конференции.РФ</h1>
            </a>
        </div>
        <div class="form-container">
            <h2>Регистрация</h2>
            <form @submit.prevent="register">
                <label for="login">Логин</label>
                <input type="text" name="login" id="login" placeholder="Введите логин" v-model="login" />
                <div class="error-message" v-if="errors.login">{{ errors.login.join('. ') }}</div>

                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" placeholder="Введите пароль" v-model="password" />
                <div class="error-message" v-if="errors.password">{{ errors.password.join('. ') }}</div>

                <label for="FIO">ФИО</label>
                <input type="text" name="FIO" id="FIO" placeholder="Введите ФИО" v-model="FIO" />
                <div class="error-message" v-if="errors.FIO">{{ errors.FIO.join('. ') }}</div>

                <label for="number">Номер телефона</label>
                <input type="text" name="number" id="number" placeholder="Введите номер телефона" v-model="number" />
                <div class="error-message" v-if="errors.number">{{ errors.number.join('. ') }}</div>

                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Введите email" v-model="email" />
                <div class="error-message" v-if="errors.email">{{ errors.email.join('. ') }}</div>

                <div class="error-message" v-if="errors.system">{{ errors.system.join('. ') }}</div>

                <button type="submit" :disabled="loading">Зарегистрироваться</button>
            </form>
            <p class="link">Уже зарегистрированы? <a href="" @click.prevent="changePage('Login')">Войти</a></p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Register',
    props: ['datasend', 'changePage', 'changeToken'],
    data() {
        return {
            login: null,
            password: null,
            FIO: null,
            number: null,
            email: null,
            errors: {},
            loading: false,
        };
    },
    methods: {
        register() {
            this.errors = {};
            this.loading = true;
            let formdata = new FormData();
            formdata.append('login', this.login);
            formdata.append('password', this.password);
            formdata.append('FIO', this.FIO);
            formdata.append('number', this.number);
            formdata.append('email', this.email);
            this.datasend('register', 'POST', formdata).then((result) => {
                this.loading = false;
                if (result.errors) {
                    for (const key in result.errors) {
                        this.errors[key] = Array.isArray(result.errors[key]) ? result.errors[key] : [result.errors[key]];
                    }
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
