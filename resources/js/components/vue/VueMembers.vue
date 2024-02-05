<template>
    <div>
        <router-link :to="{name: 'vue-new-member'}" class="btn btn-primary mt-2 row">New Members</router-link>
        All Members<br>
        <input type="text" name="search" id="search" v-model="searchName">
        <button @click="doSearch"></button>
        <div v-if="showMessage">
            <div class="alert alert-success">{{ message }}</div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="member in members">
                <th scope="row">{{ member.id }}</th>
                <td>{{ member.username }}</td>
                <td>{{ member.email }}</td>
                <td>
                    <router-link :to="{name: 'vue-edit-member',params: { id: member.id }}" class="btn btn-link">EDIT
                    </router-link>
                    <button class="btn btn-danger" @click="deleteMember(member.id)">Delete</button>
                </td>
            </tr>
            </tbody>
            <table>
                <tr>
                    <td><input type="number" class="firstNumber" v-model="firstNumber"></td>
                    <td><input type="text" class="secondNumber" v-model="secondNumber"></td>
                    <td>Total: {{total}}</td>
                </tr>
            </table>
        </table>


    </div>
</template>

<script>
export default {
    name: "VueMembers",
    data() {
        return {
            members: [],
            showMessage: false,
            message:'',
            searchName:null,
            firstNumber:0,
            secondNumber:0
        }
    },
    created() {
        this.getMembers()
    },
    computed: {
        filterMember(){
            return this.members.filter(word => word.username === this.searchName )
        },
            total: function () {
                // must parse because Vue turns empty value to string
                return Number(this.firstNumber) +
                    Number(this.secondNumber);
            }
    },
    watch: {
        searchName(){
            this.members = this.members.filter(word => word.username === this.searchName );
        }
    },
    methods: {
        doSearch(){
            if(this.searchName){
                this.members = this.members.filter(word => word.username === this.searchName );
            }
        },
        getMembers() {
            axios
                .get('/api/members')
                .then(res => {
                    this.members = res.data.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
        deleteMember(id) {
            axios
                .delete('/api/members/'+id)
                .then(res => {
                    this.showMessage = true;
                    this.message = res.data;
                    this.getMembers();
                }).catch(error => {
                console.error(error.response.data.message)
            })
        }
    }
}
</script>

<style scoped>

</style>
