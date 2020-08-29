<template>
    <div v-cloak>
        <ul class="d-flex  mb-4 border-bottom px-0" role="tablist">
            <li v-for="(tab,index) in tabs" class="list-unstyled">
                <button
                    class="btn "
                    v-text="tab.title"
                    role="tab"
                    :aria-selected="tab.isActive"
                    :class="{'btn-outline-secondary font-weight-bold': tab.isActive}"
                    @click="activeTab = tab"
                >

                </button>
            </li>
        </ul>

        <slot></slot>
    </div>
</template>

<script>
    import Tab from "./Tab";

    export default {
        name: "Tabs",
        components:{Tab},
        data(){
            return {
                tabs:[],
                activeTab:null
            }
        },
        methods:{
            setInitialActiveTab(){
                this.activeTab = this.tabs.find(tab => tab.isActive) || this.tabs[0]
            }
        },
        mounted(){

            this.tabs = this.$children

            this.setInitialActiveTab();
        },
        watch:{
            activeTab(activeTab){
                this.tabs.map(tab => tab.isActive = tab === activeTab)
            }
        }
    }
</script>

<style>
    [v-cloak]{
        display: none;
    }
</style>
