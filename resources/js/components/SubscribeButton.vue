<template>
    <button :class="classes" @click="subscribe" >
        Subscribe
    </button>
</template>

<script>
    export default {
        name: "SubscribeButton",
        props: ['active'],
        data(){
            return {
                isActive: this.active
            }
        },
        computed:{
            classes(){
                return ['btn', this.isActive ? 'btn-primary' : 'btn-outline-secondary']
            }
        },
        methods:{
            async subscribe(){
                let requestType = this.isActive ? 'delete' : 'post';
                await axios[requestType](location.pathname+'/subscriptions')
                this.isActive = !this.isActive
            }
        },
    }
</script>

<style scoped>

</style>
