<template>

</template>

<script>
    import Replies from "../Replies";
    import SubscribeButton from "../SubscribeButton";

    export default {
        name: "Thread",
        props: ['thread'],
        computed:{
            lockUri(){
                return '/locked-threads/'+this.thread.slug;
            },
            updateUri(){
              return `/threads/${this.thread.channel.slug}/${this.thread.slug}`
          }
        },
        data(){
            return {
                repliesCount: this.thread.replies_count,
                locked:this.thread.locked,
                editing:false,
                title:this.thread.title,
                body: this.thread.body,
                form: {}
            }
        },
        created(){
            this.resetForm()
        },
        components: {Replies,SubscribeButton},
        methods:{
            toggleLock(){
                axios[this.locked ? 'delete' : 'post'](this.lockUri)
                this.locked = ! this.locked
            },
            onUpdate(){
                axios.patch(this.updateUri,this.form).then(()=>{
                    flash('Your thread has been updated')
                    this.title = this.form.title
                    this.body = this.form.body
                    this.editing = false
                })
            },
            resetForm(){
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body,
                }

                this.editing = false
            }
        }
    }
</script>

<style scoped>

</style>
