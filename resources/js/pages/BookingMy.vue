<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <h2>Мои заявки</h2>

            <table class="bookings-table" v-if="bookings.length > 0">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Зал</th>
                        <th>Дата</th>
                        <th>Оплата</th>
                        <th>Статус</th>
                        <th>Комментарий</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(booking, index) in bookings" :key="booking.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ booking.room.name }}</td>
                        <td>{{ booking.date }}</td>
                        <td>{{ booking.payment == 'cash' ? 'Наличные' : 'СБП' }}</td>
                        <td>{{ booking.status }}</td>
                        <td>
                            <template v-if="booking.status == 'completed'">
                                <template v-if="!booking.comment">
                                    <form @submit.prevent="review(booking)" class="review-form">
                                        <input type="text" v-model="reviewText" placeholder="Оставьте отзыв" class="review-input" />
                                        <button type="submit" class="btn-small">Отправить</button>
                                    </form>
                                </template>
                                <template v-else>
                                    {{ booking.comment }}
                                </template>
                            </template>
                            <template v-else>-</template>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="empty-state">
                <p>У вас пока нет заявок</p>
            </div>

            <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'BookingMy',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'userInfo'],
    data() {
        return {
            bookings: [],
            reviewText: '',
            reviewBookingId: null,
        };
    },
    mounted() {
        this.getBookings();
    },
    methods: {
        getBookings() {
            this.datasend('booking/my').then((result) => {
                this.bookings = result;
            });
        },
        review(booking) {
            let formdata = new FormData();
            formdata.append('comment', this.reviewText);
            this.datasend('booking/' + booking.id + '/review', 'POST', formdata).then(() => {
                this.reviewText = '';
                this.getBookings();
            });
        },
        logout() {
            this.$emit('logout');
        },
    },
    components: { HeaderComponent },
};
</script>
