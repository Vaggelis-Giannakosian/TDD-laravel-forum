<template>
    <div>
        <div v-for="reply in items">
            <reply :data="reply"></reply>
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
    }
</script>

<style scoped>

</style>
