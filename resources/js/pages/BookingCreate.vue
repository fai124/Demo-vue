<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <div class="form-container">
                <h2>Создание заявки</h2>
                <form @submit.prevent="createBooking">
                    <label for="room_id">Зал</label>
                    <select name="room_id" id="room_id" v-model="room_id">
                        <option :value="room.id" v-for="room in rooms" :key="room.id">{{ room.name }}</option>
                    </select>
                    <div class="error-message" v-if="errors.room_id">{{ errors.room_id.join('. ') }}</div>

                    <label for="date">Дата</label>
                    <input type="date" name="date" id="date" v-model="date" />
                    <div class="error-message" v-if="errors.date">{{ errors.date.join('. ') }}</div>

                    <label for="payment">Способ оплаты</label>
                    <select name="payment" id="payment" v-model="payment">
                        <option value="cash">Наличные</option>
                        <option value="sbp">СБП</option>
                    </select>
                    <div class="error-message" v-if="errors.payment">{{ errors.payment.join('. ') }}</div>

                    <button type="submit">Создать заявку</button>
                </form>
                <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'BookingCreate',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'userInfo', 'logout'],
    data() {
        return {
            rooms: [],
            room_id: null,
            date: null,
            payment: 'cash',
            errors: {},
        };
    },
    components: { HeaderComponent },
    mounted() {
        this.getRooms();
    },
    methods: {
        getRooms() {
            this.datasend('rooms').then((result) => {
                this.rooms = result.filter(r => !r.name.includes('удален'));
            });
        },
        createBooking() {
            let formdata = new FormData();
            if (this.room_id) formdata.append('room_id', this.room_id);
            if (this.date) formdata.append('date', this.date);
            if (this.payment) formdata.append('payment', this.payment);
            this.datasend('booking/store', 'POST', formdata)
                .then((result) => {
                    console.log(result);
                    if (result.errors) {
                        this.errors = result.errors;
                    } else {
                        this.changePage('Dashboard');
                    }
                });
        },

    },
};
</script>
