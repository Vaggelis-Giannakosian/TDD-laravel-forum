<template>

</template>

<script>
    import Replies from "../Replies";
    import SubscribeButton from "../SubscribeButton";

    export default {
        name: "Thread",
        props: ['initialRepliesCount'],
        data(){
            return {
                repliesCount: this.initialRepliesCount
            }
        },
        components: {Replies,SubscribeButton},
    }
</script>

<style scoped>

</style>
