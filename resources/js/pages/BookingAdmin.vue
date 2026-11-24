<template>
    <div class="form-page">
        <HeaderComponent :datasend="datasend" :changeToken="changeToken" :logout="logout" :user="user" :isAdmin="isAdmin"
            :changePage="changePage" :userInfo="userInfo" />
        <div class="container">
            <h2>Панель администратора</h2>

            <table class="bookings-table" v-if="bookings.length > 0">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Пользователь</th>
                        <th>Зал</th>
                        <th>Дата</th>
                        <th>Оплата</th>
                        <th>Статус</th>
                        <th>Комментарий</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(booking, index) in bookings" :key="booking.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ booking.user.FIO }}</td>
                        <td>{{ booking.room.name }}</td>
                        <td>{{ formatDate(booking.date) }}</td>
                        <td>{{ booking.payment == 'cash' ? 'Наличные' : 'СБП' }}</td>
                        <td>{{ formatStatus(booking.status) }}</td>
                        <td>{{ booking.comment || '—' }}</td>
                        <td>
                            <form @submit.prevent="updateStatus(booking)" class="status-form">
                                <select v-model="booking.status" class="status-select">
                                    <option value="new">Новая</option>
                                    <option value="confirmed">Подтверждена</option>
                                    <option value="completed">Завершена</option>
                                </select>
                                <button type="submit" class="btn-small">Обновить</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="empty-state">
                <p>Заявок пока нет</p>
            </div>

            <a href="" class="btn-back" @click.prevent="changePage('Dashboard')">Назад</a>
        </div>
    </div>
</template>

<script>
import HeaderComponent from '../components/HeaderComponent.vue';
export default {
    name: 'BookingAdmin',
    props: ['datasend', 'changePage', 'changeToken', 'user', 'isAdmin', 'storage', 'userInfo'],
    data() {
        return {
            bookings: [],
        };
    },
    mounted() {
        this.getBookings();
    },
    methods: {
        getBookings() {
            this.datasend('booking/admin').then((result) => {
                this.bookings = result;
            });
        },
        updateStatus(booking) {
            let formdata = new FormData();
            formdata.append('status', booking.status);
            this.datasend('booking/' + booking.id + '/status', 'POST', formdata).then(() => {
                this.getBookings();
            });
        },
        logout() {
            this.$emit('logout');
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const year = d.getFullYear();
            return `${day}.${month}.${year}`;
        },
        formatStatus(status) {
            const map = { new: 'Новая', confirmed: 'Подтверждена', completed: 'Завершена' };
            return map[status] || status;
        },
    },
    components: { HeaderComponent },
};
</script>
