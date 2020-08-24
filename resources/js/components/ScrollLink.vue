<template>
    <a  @click.prevent="scrollTo" :href="selector">
        <slot></slot>
        <inline-svg name="s1kjUOmYA60VzXYMR7mAoeueQZqAEJY4CZMFPYCL.jpeg"></inline-svg>
    </a>
</template>

<script>
    import InlineSvg from "./InlineSvg";
    export default {
        name: "ScrollLink",
        components:{InlineSvg},
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
