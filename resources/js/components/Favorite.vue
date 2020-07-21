<template>
    <button @click="toggle" type="submit" :class="classes">
        <i class="fas fa-heart"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
       props: ['reply'],
       data(){
        return {
            count: this.reply.favoritesCount,
            active : this.reply.isFavorited

        }
       },

        computed: {
           classes(){
               return ['btn', this.active ? 'btn-primary' : 'btn-secondary']
           },
            endpoint(){
               return `/replies/${this.reply.id}/favorites`;
            }
        },
        methods: {
           toggle(){
               this.active ? this.destroy() : this.create()
            },
            destroy(){
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            },
            create(){
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            }
        },
    }
</script>

<style>

</style>
