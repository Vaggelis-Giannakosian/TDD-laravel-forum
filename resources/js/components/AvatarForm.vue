<template>
    <div class="d-flex flex-wrap justify-content-between w-100">

        <img class="ml-2" :src="avatar" alt="" width="150">


        <h2 v-text="user.name">
        </h2>

        <div class="form-group mt-3"  v-show="canUpdate" >
            <label for="avatar" class="font-weight-bold">Avatar:</label>
            <image-upload id="avatar" name="avatar" accept="image/*" placeholder="Avatar" class="form-control w-auto"
                          @loaded="onLoad"></image-upload>
        </div>




    </div>
</template>

<script>
    import ImageUpload from "./ImageUpload";
    import moment from "moment";
    export default {
        name: "AvatarForm",
        components: {ImageUpload},
        props: ['user', 'endpoint'],
        data() {
            return {
                avatar: this.user.avatar_path
            }
        },
        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            },
            createdAt(){
                return moment(this.user.created_at).fromNow()
            }
        },
        methods: {
            onLoad(avatar) {

                this.avatar = avatar.src
                //persist to the server
                this.persist(avatar.file)
            },
            persist(avatar) {
                let data = new FormData()
                data.append('avatar', avatar)
                axios.post(this.endpoint, data)
                    .then(response => {
                        flash('Avatar uploaded!')
                    })
            }
        }
    }
</script>

<style scoped>

</style>
