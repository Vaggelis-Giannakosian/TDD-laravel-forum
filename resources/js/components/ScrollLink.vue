<template>
    <a  @click.prevent="scrollTo" :href="selector">
        <slot></slot>
    </a>
</template>

<script>
    export default {
        name: "ScrollLink",
        props:['selector'],
        methods:{
            scrollTo()
            {
                document.querySelector(this.selector)
                    .scrollIntoView({behavior:'smooth'})
            }
        }
    }
</script>

<style>

</style>
