<template>
        <div :id="'reply-'+id" class="card mb-4">
            <div class="card-header">
                <div class="level">
                    <h6 class="flex">
                        <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name">
                        </a>
                        said {{ data.created_at }}...
                    </h6>


<!--                    @auth-->
                    <div v-if="signedIn">
                        <div>
                            <favorite :reply="data"></favorite>
                        </div>
                    </div>

<!--                    @endauth-->
                </div>
            </div>

            <div class="card-body">

                <div v-if="editing">

                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>

                    <div class="float-right">
                        <button @click="editing=false" class="btn btn-secondary btn-sm">Cancel</button>
                        <button @click="update" class="btn btn-primary btn-sm">Update</button>
                    </div>

                </div>

                <div v-else v-text="body"></div>

            </div>


            <div class="card-footer level" v-if="canUpdate">
                <button @click="editing=true" class="btn btn-secondary btn-sm mr-2">Edit</button>
                <button @click="destroy" class="btn btn-danger btn-sm">Delete</button>
            </div>

        </div>
</template>
<script>

    import Favorite from "./Favorite.vue";

    export default {
        props: ['data'],
        components: {Favorite},
        data(){
            return {
                editing:false,
                body: this.data.body,
                id: this.data.id
            }
        },
        computed:{
            signedIn(){
                return window.App.signedIn
            },
            canUpdate(){
                return this.authorize( user => this.data.user_id === user.id)
            }
        },
        methods:{
            update(){
                axios.patch('/replies/'+this.data.id,{
                    body:this.body
                })

                this.editing = false;
                flash('Updated!')
            },
            destroy()
            {
                axios.delete('/replies/'+this.data.id);

                this.$emit('deleted',this.data.id);


                // $(this.$el).fadeOut(300,()=>{
                //     flash('Your reply has benn deleted!')
                // })
            }
        }
    }
</script>

<style>

</style>
