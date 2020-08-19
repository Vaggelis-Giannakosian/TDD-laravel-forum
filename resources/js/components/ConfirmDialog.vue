<template>
    <modal name="dialog">

        <p v-text="params.message"></p>

        <template v-slot:footer>
            <button @click.prevent="handleClick(false)" class="btn btn-secondary rounded-lg" v-text="params.cancelButton"></button>
            <button @click.prevent="handleClick(true)" class="btn btn-primary rounded-lg ml-2" v-text="params.confirmButton"></button>
        </template>
    </modal>
</template>

<script>
    import Modal from './../plugins/modal/ModalPlugin'

    export default {
        name: "ConfirmDialog",
        data(){
            return {
                params:{
                    message:'Are you sure?',
                    confirmButton: 'Proceed',
                    cancelButton: 'Cancel'
                }
            }
        },
        beforeMount(){
            //listen for the event to fetch params and assign the data
            Modal.events.$on('show',(params)=>{
               Object.assign(this.params, params)
            })

        },
        methods: {
            handleClick(confirmed) {
                Modal.events.$emit('clicked',confirmed)

                this.$modal.hide();
            }
        },
    }
</script>

<style scoped>

</style>
