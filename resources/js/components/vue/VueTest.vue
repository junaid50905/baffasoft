<template>
    <div>
        <h2 class="hello">Hello {{name}} {{ $attrs }}</h2>
        <router-link :to="to" class="child-link">{{ to.params.email }}</router-link>
        <div v-if="$route.params.email" class="log">
            id: {{ $route.params.id }}, type: {{ $route.params.email }}<br>
            Full Path: {{ $route.fullPath }}
        </div>
    </div>

</template>

<script>
export default {
    name: "VueTest",
    props: {
        name: {
            type: String,
            default: 'Vue!'
        }
    },
    data(){
        return{
            to: {
                name: 'send-mail',
                params: { id:2, email: 'sanaulla.ict@gmail.com' }
            }
        }
    }
}
</script>

<style scoped>

</style>
