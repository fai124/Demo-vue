<template>
    <div class="dashboard-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />

        <div class="container">
            <div class="welcome">
                <h2 v-if="user">Добро пожаловать, {{ userInfo.FIO }}!</h2>
                <h2 v-else>Конференции.РФ</h2>

                <div v-if="user && !isAdmin" class="welcome-actions">
                    <a href="" class="btn-create" @click.prevent="changePage('BookingMy')">Мои заявки</a>
                </div>

                <div v-if="user && isAdmin" class="welcome-actions">
                    <a href="" class="btn-create" @click.prevent="changePage('RoomCreate')">Создать зал</a>
                    <a href="" class="btn-create" @click.prevent="changePage('BookingAdmin')">Панель администратора</a>
                </div>
            </div>

            <div class="rooms">
                <h3>Залы</h3>
                <div class="room-card" v-for="room in rooms" :key="room.id">
                    <a href="" class="room-link" @click.prevent="changePage('BookingRoom', room.id)">
                        <img :src="storage + room.image" :alt="room.name" class="room-image" />
                    </a>
                    <div class="room-info">
                        <a href="" class="room-link" @click.prevent="changePage('BookingRoom', room.id)">{{ room.name }}</a>
                        <p>{{ room.description }}</p>
                        <div v-if="user && isAdmin">
                            <a href="" class="btn-booking" @click.prevent="changePage('RoomEdit', room.id)">Редактировать</a>
                        </div>
                        <div v-else-if="user">
                            <a href="" class="btn-booking" @click.prevent="changePage('BookingRoom', room.id)">Записаться</a>
                        </div>
                    </div>
                    <div v-if="user && isAdmin">
                        <form @submit.prevent="deleteRoom(room.id)" class="form-inline">
                            <button type="submit" class="btn-delete">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'Dashboard',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'userInfo', 'logout'],
    components: { HeaderComponent },
    data() {
        return {
            rooms: [],
        };
    },
    mounted() {
        this.getRooms();
    },
    methods: {
        getRooms() {
            this.datasend('rooms').then((result) => {
                if (Array.isArray(result)) {
                    this.rooms = result.filter(r => r.name && !r.name.includes('удален'));
                }
            });
        },
        deleteRoom(id) {
            if (confirm('Удалить зал?')) {
                this.datasend('room/' + id, 'DELETE').then(() => {
                    this.getRooms();
                });
            }
        },
    },
};
</script>
