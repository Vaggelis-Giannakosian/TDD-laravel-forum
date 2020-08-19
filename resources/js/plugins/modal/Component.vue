<template>
    <div :id="name" class="overlay text-left">
        <a href="#" class="cancel"></a>

        <div class="modal">
            <slot></slot>

            <a href="#" class="close">&times;</a>

            <footer class="mt-4">
                <slot name="footer"></slot>
            </footer>
        </div>


    </div>
</template>

<script>
    export default {
        name: "Modal",
        props:['name'],
        mounted(){
            console.log('mounted')
        }
    }
</script>

<style lang="scss">
    .overlay {
        visibility: hidden;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .4);
        transition: opacity .4s;
        opacity: 0;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }
    .modal {
        display: block;
        left: 50%;
        top: 35%;
        height: auto;
        position: fixed;
        width: 500px;
        max-width: 80%;
        background: white;
        border-radius: 4px;
        padding: 2.5em;
        transform: translate(-50%,-50%);
        box-shadow: 0 5px 11px rgba(36, 37, 38, 0.08);
    }
    .modal .close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: grey;
        text-decoration: none;
    }
    .overlay .cancel {
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: default;
    }

    footer:empty{
        display: none;
    }
</style>
