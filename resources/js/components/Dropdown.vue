<template>
    <div class="dropdown" v-cloak>

        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="isOpen"
             @click="isOpen = !isOpen">
            <slot name="trigger"></slot>
        </div>


        <transition name="pop-out-quick">
            <div v-show="isOpen" class="dropdown-list bg-dark rounded-lg shadow mt-2 border">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        name: "Dropdown",
        data() {
            return {
                isOpen: false
            }
        },
        methods: {
            closeIfClickedOutside(event) {
                if (!event.target.closest('.dropdown'))
                    this.isOpen = false;
            }
        },
        watch: {
            isOpen(isOpen) {
                if (isOpen) {
                    document.addEventListener('click', this.closeIfClickedOutside)
                }
            }
        }
    }
</script>

<style lang="scss">

    a.text-info:hover {
        color: black !important;
    }

    .dropdown {

        .dropdown-list {
            position: absolute;
            right: 0;
        }

        li {
            list-style: none;
        }

    }


    [v-cloak] {
        display: none;
    }

    .pop-out-quick-enter-active,
    .pop-out-quick-leave-active {
        transition: all .4s;
    }

    .pop-out-quick-enter,
    .pop-out-quick-leave-active {
        opacity: 0;
        transform: translateY(-7px);
    }
</style>
