<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label class="font-weight-bold" for="body">Post your reply here!</label>
                <wysiwyg v-model="body" placeholder="Have something to say?" name="body" ref="trix" :shouldClear="completed"></wysiwyg>
            </div>

            <div class="text-right">
                <button type="submit"
                        class="btn btn-primary"
                        @click="addReply">Post
                </button>
            </div>
        </div>

        <div v-else>
            <p class="text-center">Please <a href="/login">sign in</a> to participate in this
                discussion
            </p>
        </div>
    </div>
</template>

<script>

    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body: '',
                completed:false
            }
        },
        computed: {
            endpoint(){
                return `${location.pathname}/replies`
            }
        },

        mounted(){
            $('#body').atwho({
                at:'@',
                delay:750,
                callbacks:{
                    remoteFilter: function (query,callback) {
                        $.getJSON('/api/users',{name:query}, function(usernames){
                            callback(usernames)
                        })
                    }
                }
            })
        },
        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';
                        this.completed = !this.completed
                        flash('Your reply has been posted.')
                        this.$emit('created', data)
                    })
                    .catch(error=>{
                        this.body = '';
                        flash(error.response.data,'danger')
                    })

            }
        }
    }
</script>

<style scoped>

</style>
