<template>
    <div v-show="isActive" role="tabpanel">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: "Tab",
        props:{
            title:{},
            active:{
                type:Boolean,
                default:false
            }
        },
        data(){
            return {
                isActive:this.active
            }
        }
    }
</script>

<style scoped>

</style>
