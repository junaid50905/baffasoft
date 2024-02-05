<template>
    <div>
        <b-navbar toggleable="lg" variant="light" type="light">
            <!--            <b-navbar-brand href="#">NavBar</b-navbar-brand>-->
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav> <!--                    <b-nav-item href="#">Home</b-nav-item>-->
                    <!-- Navbar dropdowns -->
                    <b-nav-item-dropdown text="Member" center v-if="checkAccess('members-dropdown')">
                        <b-dropdown-item active-class="active" v-if="checkAccess('members')" exact
                                         :to="{ name: 'members' }">Member List
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('due-members')" exact
                                         :to="{ name: 'due_members' }">Due Payments
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('all-renew-members')" exact
                                         :to="{ name: 'all-renew-members' }">Renewal Status
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('all-renew-members')" exact
                                         :to="{ name: 'all-structure-members' }">Structural Changes Status
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('short-new-member')" exact
                                         :to="{ name: 'short-new-member' }">New Member
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown text="Training" center v-if="checkAccess('training-dropdown')">
                        <b-dropdown-item v-if="checkAccess('training-visibility')" active-class="active" exact :to="{ name: 'training-names' }">Training
                            Visibility
                        </b-dropdown-item>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-dg-training' }">DGR Training
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-csa-training' }">CSA Training
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-other-training' }">Other
                            Training
                        </b-dropdown-item>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item v-if="checkAccess('new-training')" active-class="active" exact :to="{ name: 'new_training_dg' }">New DGR Training
                        </b-dropdown-item>
                        <b-dropdown-item v-if="checkAccess('new-training')" active-class="active" exact :to="{ name: 'new_training_csa' }">New CSA
                            Training
                        </b-dropdown-item>
                        <b-dropdown-item v-if="checkAccess('new-training')" active-class="active" exact :to="{ name: 'new_training_other' }">New Other
                            Training
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown text="Election" center v-if="checkAccess('voter-dropdown')">
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-election' }">Elections
                        </b-dropdown-item>
                        <!--                        <b-dropdown-item active-class="active" exact :to="{ name: 'new-voter' }">New Voter</b-dropdown-item>-->
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown text="GatePass" center v-if="role == 1 || role == 3">
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-gate-pass' }">CargoForm Report
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'new-gate-pass' }">New GatePass
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'saved-gate-pass' }">Saved GatePass
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown text="ID Card" center v-if="checkAccess('id-card-dropdown')">
                        <b-dropdown-item active-class="active" v-if="checkAccess('all-id-card')" exact
                                         :to="{ name: 'all-id-card' }">ID Card Department
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('manager-id-card')" exact
                                         :to="{ name: 'manager-id-card' }">Director Panel
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('accounts-id-card')" exact
                                         :to="{ name: 'accounts-id-card' }">Account's Panel
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('new-id-card')" exact
                                         :to="{ name: 'new-id-card' }">New ID Card
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('id-card-year')" exact
                                         :to="{ name: 'id_card_year' }">ID Card Year
                        </b-dropdown-item>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item active-class="active" v-if="checkAccess('id-card-report')" exact
                                         :to="{ name: 'id-card-report' }">ID Card Report
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('cancel-id-card-panel')" exact
                                         :to="{ name: 'cancel-id-card-panel' }">Cancel ID Card Report
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" v-if="checkAccess('reissue-id-card-panel')" exact
                                         :to="{ name: 'reissue-id-card-panel' }">Re-issued ID Card Report
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                    <!--                    <b-nav-item-dropdown text="ID Card" center v-if="role == 1 || role == 2" > <b-dropdown-item active-class="active" v-if="role == 1 || username == 'saidul.baffa' || username == 'reza.baffa' " exact :to="{ name: 'all-id-card'}">ID Card Department</b-dropdown-item> <b-dropdown-item active-class="active" v-if="role == 1 || username == 'dir1.baffa' || username == 'saidul.baffa' || username == 'reza.baffa' " exact :to="{ name: 'manager-id-card'}">Director Panel</b-dropdown-item> <b-dropdown-item active-class="active" v-if="role == 1 || username == 'tulshidas.baffa' || username == 'kamrul.baffa' || username == 'shahed.baffa' || username == 'hasin.baffa'" exact :to="{ name: 'accounts-id-card'}">Account's Panel</b-dropdown-item> <b-dropdown-item active-class="active" v-if="role == 1" exact :to="{name: 'new-id-card'}">New ID Card</b-dropdown-item> <b-dropdown-divider></b-dropdown-divider> <b-dropdown-item active-class="active" exact :to="{name: 'id-card-report'}">ID Card Report</b-dropdown-item> <b-dropdown-item active-class="active" v-if="role == 1 || username == 'saidul.baffa' || username == 'reza.baffa' " exact :to="{ name: 'cancel-id-card-panel'}">Cancel ID Card Report</b-dropdown-item> <b-dropdown-item active-class="active" v-if="role == 1 || username == 'saidul.baffa' || username == 'reza.baffa' || username == 'tulshidas.baffa' || username == 'kamrul.baffa' || username == 'shahed.baffa' || username == 'hasin.baffa'" exact :to="{ name: 'reissue-id-card-panel'}">Re-issued ID Card Report</b-dropdown-item> </b-nav-item-dropdown>-->
                    <b-nav-item-dropdown text="Collection" center
                                         v-if=" role == 1 || role == 3 || username == 'tulshidas.baffa' || username == 'kamrul.baffa' || username == 'shahed.baffa' || username == 'hasin.baffa' ">
                        <b-dropdown-item active-class="active" exact :to="{ name: 'all-collection' }">Collection
                            Report
                        </b-dropdown-item>
                        <b-dropdown-item active-class="active" exact :to="{ name: 'new-collection' }">Money Receipt
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav> <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-form>
                        <b-button size="sm" class="my-2 my-sm-0 mr-2" @click="doBack"><< Back</b-button>
                        <b-button size="sm" class="my-2 my-sm-0" @click="doForward">Forward >></b-button>
                    </b-nav-form> <!--                    <b-nav-item-dropdown text="Lang" right>-->
                    <!--                        <b-dropdown-item href="#">EN</b-dropdown-item>-->
                    <!--                        <b-dropdown-item href="#">ES</b-dropdown-item>-->
                    <!--                        <b-dropdown-item href="#">RU</b-dropdown-item>-->
                    <!--                        <b-dropdown-item href="#">FA</b-dropdown-item>-->
                    <!--                    </b-nav-item-dropdown>-->
                    <!--                    <b-nav-item-dropdown right>-->
                    <!--                        <template #button-content>-->
                    <!--                            <em>User</em>--> <!--                        </template>-->
                    <!--                        <b-dropdown-item href="#">Profile</b-dropdown-item>-->
                    <!--                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>-->
                    <!--                    </b-nav-item-dropdown>--> </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>
<script>
export default {
    name: "Navbar",
    // props: ['username'],
    // props: { username: String },
    data: () => ({
        role: 3,
        username: "",
    }),
    created() {
        this.role = window.Laravel.user.role_id;
        this.username = window.Laravel.user.username;
        this.$emit("setUsername", {role: this.role, username: this.username});
        console.log("Saalam");
    },
    methods: {
        doBack() {
            console.log("Click");
            this.$router.go(-1);
        },
        doForward() {
            console.log("Click");
            this.$router.go(1);
        },
    },
};
</script>
<style scoped></style>
