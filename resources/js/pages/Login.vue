<script>
import {mapActions} from "vuex";

export default {
    name: "Login",
    data() {
        return {
            credentials: {
                login: '',
                password: ''
            },
            processing: false,
            errors: {
                login: '',
                password: ''
            }
        }
    },
    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        resetValidate() {
            this.errors.login = '';
            this.errors.password = '';
        },
        setErrorsMessage(errors) {

            if (errors.login) {
                this.errors.login = errors.login[0]
            }

            if (errors.password) {
                this.errors.password = errors.password[0]
            }
        },
        submit() {
            this.resetValidate()
            this.processing = true

            axios.post('/api/auth/login', this.credentials)
                .then((response) => {
                    this.signIn(response.data.access_token)
                })
                .catch ((error) => {
                    if (error.response.status === 401 ) {
                        this.errors.login = error.response.data.message
                    }else if (error.response.status === 422) {
                        this.setErrorsMessage()
                    }
                })
                .finally(() => {
                    this.processing = false
                })
        }
    }
}
</script>

<template>
    <div class="w-full h-screen flex justify-center items-center">
        <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                    Login
                </label>
                <input
                    v-model="credentials.login"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="login"
                    type="text"
                    placeholder="Login">

                <p class="text-red-500 text-xs italic" v-if="errors.login">{{errors.login}}</p>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    v-model="credentials.password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="password"
                    type="password"
                    placeholder="******************">

                 <p class="text-red-500 text-xs italic" v-if="errors.password">{{errors.password}}</p>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    :disabled="processing"
                    type="submit">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
