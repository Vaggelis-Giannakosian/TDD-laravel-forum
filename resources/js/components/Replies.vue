<template>
    <div>
        <div v-for="(reply,index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>


        <new-reply :endpoint="endpoint" @created="add"></new-reply>

    </div>
</template>

<script>

    import Reply from "./Reply";
    import NewReply from "./NewReply";

    export default {
        props: ['data'],
        data (){
            return {
                items: this.data,
                endpoint : location.pathname + '/replies'
            }
        },
        components: {Reply, NewReply},
        methods: {
            remove(index){
                this.items.splice(index,1)

                this.$emit('removed');

                flash('Your reply has benn deleted!')
            },
            add(reply)
            {
                this.items.push(reply)
                this.$emit('added')
            }
        }
    }
</script>

<style scoped>

</style>
