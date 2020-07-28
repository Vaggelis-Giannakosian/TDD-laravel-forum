<template>
    <li class="nav-item dropdown" v-if="notifications">

        <a id="notifications_dropdown" class="nav-link dropdown-toggle" href="#" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell" aria-hidden="true"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notifications_dropdown">

            <a class="dropdown-item"
               v-for="notification in notifications"
               v-text="notification.data.message"
               :href="notification.data.link"
               @click="markAsRead(notification)"
            ></a>

        </div>

    </li>
</template>

<script>
    export default {
        async created() {
            const response = await axios.get(`/profiles/${window.App.user.name}/notifications`)
            this.notifications = response.data;
        },
        data() {
            return {
                notifications: false
            }
        },
        methods: {
            async markAsRead(notification){
                await axios.delete(`/profiles/${window.App.user.name}/notifications/${notification.id}`)
                const notificationIndex = this.notifications.indexOf(notification)
                this.notifications.splice(notificationIndex,1)
            }
        }
    }
</script>

<style scoped>

</style>
