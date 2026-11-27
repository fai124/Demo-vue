<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <div class="room-detail" v-if="room">
                <h2>{{ room.name }}</h2>
                <img :src="storage + room.image" :alt="room.name" class="room-detail-img" />
                <p>{{ room.description }}</p>

                <form @submit.prevent="createBooking">
                    <input type="hidden" name="room_id" :value="room.id" />

                    <label for="date">Дата</label>
                    <input type="date" name="date" id="date" v-model="date" />
                    <div class="error-message" v-if="errors.date">{{ errors.date.join('. ') }}</div>

                    <label for="payment">Способ оплаты</label>
                    <select name="payment" id="payment" v-model="payment">
                        <option value="cash">Наличные</option>
                        <option value="sbp">СБП</option>
                    </select>
                    <div class="error-message" v-if="errors.payment">{{ errors.payment.join('. ') }}</div>

                    <button type="submit">Записаться</button>
                </form>

                <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'BookingRoom',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'pageId', 'userInfo', 'logout'],
    data() {
        return {
            room: null,
            date: null,
            payment: 'cash',
            errors: {},
        };
    },
    components: { HeaderComponent },
    mounted() {
        this.getRoom();
    },
    methods: {
        getRoom() {
            this.datasend('booking/room/' + this.pageId).then((result) => {
                this.room = result;
            });
        },
        createBooking() {
            let formdata = new FormData();
            if (this.room) formdata.append('room_id', this.room.id);
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
