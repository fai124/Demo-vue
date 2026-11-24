<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <div class="form-container">
                <h2>Редактирование зала</h2>
                <form @submit.prevent="editRoom" enctype="multipart/form-data">
                    <label for="name">Название зала</label>
                    <input type="text" name="name" id="name" v-model="name" />
                    <div class="error-message" v-if="errors.name">{{ errors.name.join('. ') }}</div>

                    <label for="description">Описание</label>
                    <textarea name="description" id="description" v-model="description"></textarea>
                    <div class="error-message" v-if="errors.description">{{ errors.description.join('. ') }}</div>

                    <div v-if="room && room.image" class="current-image">
                        <img :src="storage + room.image" :alt="room.name" />
                    </div>

                    <label for="image">Новое изображение</label>
                    <input type="file" name="image" id="image" ref="fileInput" />
                    <div class="error-message" v-if="errors.image">{{ errors.image.join('. ') }}</div>

                    <button type="submit">Сохранить</button>
                </form>
                <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'RoomEdit',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'pageId', 'userInfo'],
    data() {
        return {
            room: null,
            name: null,
            description: null,
            errors: {},
        };
    },
    mounted() {
        this.getRoom();
    },
    methods: {
        getRoom() {
            this.datasend('room/' + this.pageId).then((result) => {
                this.room = result;
                this.name = result.name;
                this.description = result.description;
            });
        },
        editRoom() {
            let formdata = new FormData();
            formdata.append('name', this.name);
            formdata.append('description', this.description);
            formdata.append('old_image', this.room?.image || '');
            if (this.$refs.fileInput && this.$refs.fileInput.files[0]) {
                formdata.append('image', this.$refs.fileInput.files[0]);
            }
            this.datasend('room/' + this.pageId, 'POST', formdata).then((result) => {
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
