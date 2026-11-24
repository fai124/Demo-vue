<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <div class="form-container">
                <h2>Создание зала</h2>
                <form @submit.prevent="createRoom" enctype="multipart/form-data">
                    <label for="name">Название зала</label>
                    <input type="text" name="name" id="name" placeholder="Введите название" v-model="name" />
                    <div class="error-message" v-if="errors.name">{{ errors.name.join('. ') }}</div>

                    <label for="description">Описание</label>
                    <textarea name="description" id="description" placeholder="Введите описание" v-model="description"></textarea>
                    <div class="error-message" v-if="errors.description">{{ errors.description.join('. ') }}</div>

                    <label for="image">Изображение</label>
                    <input type="file" name="image" id="image" ref="fileInput" />
                    <div class="error-message" v-if="errors.image">{{ errors.image.join('. ') }}</div>

                    <button type="submit">Создать</button>
                </form>
                <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'RoomCreate',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'PUBLIC', 'userInfo'],
    data() {
        return {
            name: null,
            description: null,
            errors: {},
        };
    },
    methods: {
        createRoom() {
            let formdata = new FormData();
            if (this.name) formdata.append('name', this.name);
            if (this.description) formdata.append('description', this.description);
            if (this.$refs.fileInput && this.$refs.fileInput.files[0]) {
                formdata.append('image', this.$refs.fileInput.files[0]);
            }
            this.datasend('room/store', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.changePage('Dashboard');
                    }
                });
        },
        logout() {
            this.$emit('logout');
        },
    },
    components: { HeaderComponent },
};
</script>
