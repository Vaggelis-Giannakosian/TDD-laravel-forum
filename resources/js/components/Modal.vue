<template>
    <div>
        <slot>

        </slot>
    </div>
</template>

<script>
    export default {
        name: "Modal",
        props:['name'],
        mounted(){
            console.log(this.name)
        }
    }
</script>

<style lang="scss">

</style>
