<template>
    <div :id="'reply-'+id" class="card mb-4">
        <div class="card-header">
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


        <div class="card-footer level" v-if="canUpdate">
            <button @click="editing=true" class="btn btn-secondary btn-sm mr-2">Edit</button>
            <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
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
                id: this.data.id
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id === user.id)
            },
            ago() {
                return moment(this.data.created_at).fromNow() + '...'
            },
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
            }
        }
    }
</script>

<style>

</style>
