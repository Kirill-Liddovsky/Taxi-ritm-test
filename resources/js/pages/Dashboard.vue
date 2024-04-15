<script>
import Header from "@/components/Header.vue";
import { TailwindPagination } from 'laravel-vue-pagination';
export default {
    name: "Dashboard",
    components: {Header,TailwindPagination},
    data() {
      return {
          users: {},
          error: '',
          showUpdateUserModal: false,
          updateUserForm: {
              id: null,
              login: '',
              email: '',
          },
          updateUserFormInit: {
              login: '',
              email: '',
          },
          updateUserFormError: {
              login: '',
              email: ''
          }
      }
    },
    watch: {
      error() {
          setTimeout(() => {
              this.error = ''
          }, 2000)
      }
    },
    methods: {
        list(page = 1) {
            axios.get(`/api/users?page=${page}`).then((res) => {
                this.users = res.data
                this.$router.push({ query: {page} });
            })
        },
        deleteUser(id) {
            axios.delete(`/api/users/${id}`).then(() => {
                this.list(this.$route.query.page)
            }).catch((error) => {
                if (error.response.status) {
                    this.error = error.response.data.message
                }
            })
        },
        openUpdateUserModal(id) {
            axios.get(`/api/users/${id}/edit`).then((res) => {
                this.updateUserForm.id = id
                this.updateUserForm.email = res.data.email
                this.updateUserForm.login = res.data.login

                this.updateUserFormInit.email = res.data.email
                this.updateUserFormInit.login = res.data.login

                this.showUpdateUserModal = true
            })

        },
        closeUpdateUserModal() {
            this.showUpdateUserModal = false

            this.updateUserForm.id = null
            this.updateUserForm.email = ''
            this.updateUserForm.login = ''

            this.updateUserFormError.login = ''
            this.updateUserFormError.email = ''
        },
        updateUser() {
            const updateData = {}

            if (this.updateUserForm.login !== this.updateUserFormInit.login) {
                updateData.login = this.updateUserForm.login
            }

            if (this.updateUserForm.email !== this.updateUserFormInit.email) {
                updateData.email = this.updateUserForm.email
            }

            axios.patch(`/api/users/${this.updateUserForm.id}`,updateData).then(() => {
                this.closeUpdateUserModal()
                this.list(this.$route.query.page)
            }).catch((error) => {
                this.setErrorsMessage(error.response.data.errors);
            })
        },
        setErrorsMessage(errors) {
            if (errors.login) {
                this.updateUserFormError.login = errors.login[0]
            }

            if (errors.email) {
                this.updateUserFormError.email = errors.email[0]
            }
        },



    },
    beforeMount() {
        this.list()
    }
}
</script>

<template>
    <div>
        <Header/>

        <table class="table-auto w-full mt-8">
            <thead>
            <tr>
                <th class="px-4 py-2">Login</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users.data">
                <td class="border px-4 py-2">{{ user.login }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>
                <td class="border px-4 py-2 flex gap-2 justify-center">
                    <button @click="openUpdateUserModal(user.id)" class="p-2 text-white rounded-sm bg-orange-500" type="button">Edit</button>
                    <button @click="deleteUser(user.id)" class="p-2 text-white rounded-sm bg-red-500" type="button">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>

        <TailwindPagination class="w-full justify-center mt-8 shadow-none" :data="users" @pagination-change-page="list"></TailwindPagination>

        <div v-if="error" class="absolute bottom-0 p-2 w-full bg-red-500 text-white">{{ error }}</div>

        <div v-if="showUpdateUserModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="closeUpdateUserModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Update
                                </h3>
                                <div class="mt-2 w-full">
                                    <form @submit.prevent="updateUser">
                                        <div class="mb-4">
                                            <label for="login" class="block text-gray-700 font-bold mb-2">Login</label>
                                            <input type="text" v-model="updateUserForm.login" id="login" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            <p class="text-red-500 text-xs italic" v-if="updateUserFormError.login">{{updateUserFormError.login}}</p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                            <input type="email" v-model="updateUserForm.email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                            <p class="text-red-500 text-xs italic" v-if="updateUserFormError.email">{{updateUserFormError.email}}</p>
                                        </div>
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
