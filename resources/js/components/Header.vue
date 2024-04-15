<script>

import {mapActions} from "vuex";

export default {
    name: "Header",
    methods: {
        ...mapActions({
            logout:'auth/logout'
        }),
        submit() {
            axios.post('/api/auth/logout').then((res) => {
                this.logout()
            })
        }
    }
}
</script>

<template>
    <div class="w-full h-10 border-b-2 border-black flex justify-end p-2">
        <form @submit.prevent="submit">
            <button type="submit">Logout</button>
        </form>
    </div>
</template>

<style scoped>

</style>
