<template>
    <div>
        <div v-for="(reply,index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
</template>

<script>

    import Reply from "./Reply";

    export default {
        props: ['data'],
        data (){
            return {
                items: this.data
            }
        },
        components: {Reply},
        methods: {
            remove(index){
                this.items.splice(index,1)

                this.$emit('removed');

                flash('Your reply has benn deleted!')
            }
        }
    }
</script>

<style scoped>

</style>
