<template>
    <div class="d-flex flex-wrap justify-content-between w-100">
        <h1 v-text="user.name">
            <small>Since {{ user.created_at }}</small>
        </h1>

        <div class="form-group ">
            <label for="avatar" class="font-weight-bold">Avatar:</label>
            <image-upload id="avatar" name="avatar" accept="image/*" placeholder="Avatar" class="form-control w-auto"
                          v-show="canUpdate" @loaded="onLoad"></image-upload>
        </div>


        <img class="ml-2" :src="avatar" alt="" width="200">

    </div>
</template>

<script>
    import ImageUpload from "./ImageUpload";

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
