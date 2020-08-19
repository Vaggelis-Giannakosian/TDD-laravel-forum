import Component from "./Component";

let Plugin = {
    install: function (Vue, options = {}) {
        Vue.component('modal', Component)


        Vue.prototype.$modal = {
            show(name) {
                location.hash = name
            },
            hide() {
                location.hash = '#'
            }
        }
    }

}

export default Plugin;
