<template>
    <div :id="'reply-'+id" class="card mb-4" :class="isBest ? 'shadow border-success': ''">
        <div class="card-header ">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name">
                    </a>
                    said <span v-text="ago"></span>
                </h6>

                <div v-if="signedIn">
                    <div>
                        <favorite :reply="data"></favorite>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div v-if="editing">

                <form @submit="update" action="">

                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>

                    <div class="float-right">
                        <button type="button" @click="editing=false" class="btn btn-secondary btn-sm">Cancel</button>
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>

                </form>

            </div>

            <div v-else v-html="body"></div>

        </div>


        <div class="card-footer level">
           <div v-if="authorize('updateReply',reply)">
               <button @click="editing=true" class="btn btn-secondary btn-sm mr-2">Edit</button>
               <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
           </div>


            <button v-if="!isBest" @click="markBestReply" class="btn btn-outline-secondary btn-sm ml-auto">Best Reply?</button>
        </div>

    </div>
</template>
<script>

    import Favorite from "./Favorite.vue";
    import moment from "moment";

    export default {
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                body: this.data.body,
                id: this.data.id,
                isBest : this.data.isBest,
                reply:this.data
            }
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...'
            },
        },
        created(){
            window.events.$on('best-reply-selected',(id)=>{
                this.isBest = (id === this.id)
            })
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(() => {
                    flash('Updated!')
                }).catch(error => {
                    flash(error.response.data, 'danger')
                })

                this.editing = false;
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);


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
