<template>

</template>

<script>
    import Replies from "../Replies";
    import SubscribeButton from "../SubscribeButton";

    export default {
        name: "Thread",
        props: ['dataRepliesCount','datalLocked'],
        data(){
            return {
                repliesCount: this.dataRepliesCount,
                locked:this.datalLocked
            }
        },
        components: {Replies,SubscribeButton},
    }
</script>

<style scoped>

</style>
