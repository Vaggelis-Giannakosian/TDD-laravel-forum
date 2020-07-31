<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <label class="font-weight-bold" for="body">Post your reply here!</label>
                <textarea placeholder="Have something to say?"
                          name="body" rows="3" id="body"
                          class="form-control" required
                          v-model="body"></textarea>
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
    export default {
        data() {
            return {
                body: '',
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn
            },
            endpoint(){
                return `${location.pathname}/replies`
            },
        },
        methods: {
            addReply() {
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) => {
                        this.body = '';
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
