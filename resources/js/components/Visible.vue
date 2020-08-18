<template>
    <transition name="fade">
        <div v-show="isVisible">
            <slot></slot>
        </div>
    </transition>
</template>

<script>
    import inViewport from 'in-viewport'
    import {throttle} from 'lodash'

    export default {
        name: "Visible",
        props: {
            whenHidden: {
                required: false
            }
        },
        data() {
            return {
                isVisible: false
            }
        },
        methods: {
            onScroll() {
                const element = document.querySelector(this.whenHidden)

                throttle(function () {

                }, 150)
            }
        },
        mounted() {
            const element = document.querySelector(this.whenHidden)
            this.isVisible = !inViewport(element)
            window.addEventListener('scroll', () => {
                this.isVisible = !inViewport(element)
            }, {passive: true})
        }
    }
</script>

<style lang="scss">

    .fade-enter,
    .fade-leave-to{
       opacity: 0;
    }

    .fade-enter-active,
    .fade-leave-active{
       transition: opacity .3s;
    }

</style>
