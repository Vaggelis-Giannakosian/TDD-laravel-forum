<template>
    <div :id="'reply-'+id" class="card mb-4" :class="isBest ? 'shadow border-success': ''">
        <div class="card-header ">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/'+reply.owner.name" v-text="reply.owner.name">
                    </a>
                    said <span v-text="ago"></span>
                </h6>

                <div v-if="signedIn">
                    <div>
                        <favorite :reply="reply"></favorite>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div v-if="editing">

                <form @submit="update" action="">

                    <div class="form-group">
                        <wysiwyg v-model="body" ></wysiwyg>
                    </div>

                    <div class="float-right">
                        <button type="button" @click="editing=false" class="btn btn-secondary btn-sm">Cancel</button>
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>

                </form>

            </div>

            <div v-else v-html="body"></div>

        </div>


        <div class="card-footer level" v-if="authorize('owns',reply) || authorize('owns',reply.thread)">
           <div v-if="authorize('owns',reply)">
               <button @click="editing=true" class="btn btn-secondary btn-sm mr-2">Edit</button>
               <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
           </div>


            <button  @click="markBestReply" v-if="!isBest && authorize('owns',reply.thread)"  class="btn btn-outline-secondary btn-sm ml-auto">Best Reply?</button>
        </div>

    </div>
</template>
<script>

    import Favorite from "./Favorite.vue";
    import moment from "moment";

    export default {
        props: ['reply'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                body: this.reply.body,
                id: this.reply.id,
                isBest : this.reply.isBest,
            }
        },
        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '...'
            },
        },
        created(){
            window.events.$on('best-reply-selected',(id)=>{
                this.isBest = (id === this.id)
            })
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                }).then(() => {
                    flash('Updated!')
                }).catch(error => {
                    flash(error.response.data, 'danger')
                })

                this.editing = false;
            },
            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);


                // $(this.$el).fadeOut(300,()=>{
                //     flash('Your reply has benn deleted!')
                // })
            },
            markBestReply() {
                axios.post(`/replies/${this.id}/best`)

                window.events.$emit('best-reply-selected',this.id)
            }
        }
    }
</script>

<style>

</style>
