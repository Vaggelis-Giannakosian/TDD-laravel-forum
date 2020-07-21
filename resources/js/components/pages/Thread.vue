<template>

</template>

<script>
    import Replies from "../Replies";
    export default {
        name: "Thread",
        props: ['initialRepliesCount'],
        data(){
            return {
                repliesCount: this.initialRepliesCount
            }
        },
        components: {Replies},
    }
</script>

<style scoped>

</style>
