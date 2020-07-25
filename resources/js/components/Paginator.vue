<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl" class="page-item">
            <a class="page-link" href="#" rel="prev" tabindex="-1" @click.prevent="page--">&laquo; Previous</a>
        </li>

<!--        <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--        <li class="page-item active">-->
<!--            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>-->
<!--        </li>-->
<!--        <li class="page-item"><a class="page-link" href="#">3</a></li>-->


        <li v-show="nextUrl" class="page-item">
            <a class="page-link" href="#" rel="next" @click.prevent="page++">Next &raquo;</a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: "Paginator",
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },
            page(){
                this.broadcast().updateUrl();
            }
        },
        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl
            }
        },
        methods:{
            broadcast(){
                return this.$emit('changed',this.page)
            },
            updateUrl(){
                history.pushState(null,null,`?page=${this.page}`)
            }
        },
    }
</script>

<style scoped>

</style>
