<template>

</template>

<script>
    import Replies from "../Replies";
    import SubscribeButton from "../SubscribeButton";

    export default {
        name: "Thread",
        props: ['thread'],
        data(){
            return {
                repliesCount: this.thread.replies_count,
                locked:this.thread.locked,
                editing:false,
            }
        },
        components: {Replies,SubscribeButton},
        methods:{
            toggleLock(){
                axios[this.locked ? 'delete' : 'post']('/locked-threads/'+this.thread.slug)
                this.locked = ! this.locked
            },
            onEdit(){
                this.editing = false

                // axios
            }
        }
    }
</script>

<style scoped>

</style>
