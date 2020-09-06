<template>
    <div>
        <input type="hidden" id="trix" :value="value" :name="name">
        <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix'

    export default {
        name: "Wysiwyg",
        props: ['name','value','placeholder','shouldClear'],
        mounted(){
            this.$refs.trix.addEventListener('trix-change',(e)=>{
                this.$emit('input',e.target.innerHTML)
            })

            this.$watch('shouldClear',()=>{
                this.reset()
            })
        },
        methods:{
            reset(){
                this.$refs.trix.value = ''
            }
        },
    }
</script>

<style scoped>

</style>
