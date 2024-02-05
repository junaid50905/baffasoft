<template>
    <div class="container">
        <h4 class="m-4 text-center">All {{pageHeader}} Voter List</h4>
        <validation-errors :errors="validationErrors" :success="success"
                           :warning_message="warning_message"></validation-errors>
        <b-row>
            <b-col sm="6" class="my-1"></b-col>
            <b-col sm="3" class="my-1" v-if="checkAccess('make_list')">
                <button v-if="election.status == 'Verified'" class="btn btn-secondary btn-sm" @click="makeList('preliminary_list')">Make Preliminary List</button>
                <button v-else-if="election.status == 'Inspected'" class="btn btn-success btn-sm" @click="makeList('final_list')">Make Final List</button>
                <button v-else-if="election.status == 'Active'" class="btn btn-success btn-sm" @click="makeList('archived')">Make Archived List</button>
            </b-col>
            <b-col sm="3" class="my-1" v-if="election.status == 'Active'">
                <json-excel
                    v-if="totalRows >= 1"
                    class="btn btn-sm btn-outline-success"
                    :header="header"
                    :data="voters"
                    :fields="json_fields"
                    :before-generate="beforeExcelGenerate"
                    :before-finish="() => loading = false"
                    worksheet="BAFFA Worksheet"
                    name="Voters.xls"
                >
                    Download {{pageHeader}} Voter List
                    <i class="fas fa-file-excel text-success"/>
                    <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                </json-excel>
            </b-col>
        </b-row>
        <b-row>
            <b-col lg="4" class="my-1">
                <b-form-group
                    label="Filter"
                    label-for="filter-input"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-input-group size="sm">
                        <b-form-input
                            id="filter-input"
                            v-model="filter"
                            type="search"
                            placeholder="Type to Search"
                            list="my-list-id"
                        ></b-form-input>
                        <datalist id="my-list-id">
                            <option v-for="size in organizations">{{ size.organization_name }}</option>
                        </datalist>
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col lg="6" class="my-1">
                <b-form-group
                    label="Location"
                    label-for="sort-by-select"
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    v-slot="{ ariaDescribedby }"
                >
                    <b-input-group size="sm">
                        <b-form-select
                            id="sort-by-select"
                            v-model="select_location"
                            :options="sortOptions"
                            :aria-describedby="ariaDescribedby"
                            class="w-75"
                        >
                            <template #first>
                                <option value="">-- All --</option>
                            </template>
                        </b-form-select>

                        <b-form-select
                            v-model="select_voter"
                            :aria-describedby="ariaDescribedby"
                            size="sm"
                            class="w-25"
                        >
                            <option value="">-- All --</option>
                            <option value="voter">Voter</option>
                            <option value="non_voter">Non-Voter</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>
            <b-col lg="2" class="my-1">
                <div class="d-grid gap-2">
                    <b-button size="sm" @click="doFilterByDate">Generate Report
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <b-row>
            <b-col sm="5" md="6" class="my-1">
                <b-form-group
                    label="Per page"
                    label-for="per-page-select"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-form-select
                        id="per-page-select"
                        v-model="perPage"
                        :options="pageOptions"
                        size="sm"
                    ></b-form-select>
                </b-form-group>
            </b-col>

            <b-col sm="7" md="6" class="my-1">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                ></b-pagination>
            </b-col>
        </b-row>
        <br>
        <b-table striped hover small show-empty
                 id="table-transition-example"
                 primary-key="id"
                 :filter="filter"
                 :filter-included-fields="filterOn"
                 :items="voters"
                 :fields="fields"
                 :current-page="currentPage"
                 :per-page="perPage"
                 :busy.sync="isBusy"
        >
            <template #cell(all_list)="row">
                <span v-if="election.status == 'Verified' || election.status == 'Inspected'">
                    <span v-if="row.item.due_list">
                    <span style="color: red">Non Voter</span>
<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'due_list','0')"
                            data-toggle="tooltip" data-placement="top"
                            title="Active"><i class="far fa-check-circle"></i></button>-->
                </span>
                <span v-else>
                    <span style="color: green">Voter</span>
<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'due_list','1')"
                            data-toggle="tooltip" data-placement="top"
                            title="Due"><i class="far fa-times-circle"></i></button>-->
                </span>
                    <span> | </span>
<!--                </span>-->
<!--                <span v-if="election.status == 'Inspected'">-->
                    <span v-if="!row.item.preliminary_list">
                    <span style="color: red">No Preliminary</span>
<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'preliminary_list','1')"
                            data-toggle="tooltip" data-placement="top"
                            title="Preliminary"><i class="far fa-check-circle"></i></button>-->
                </span>
                <span v-else>
                    <span style="color: green">Preliminary</span>
<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'preliminary_list','0')"
                            data-toggle="tooltip" data-placement="top"
                            title="Disable"><i class="far fa-times-circle"></i></button>-->
                </span>
                </span>
                <span v-if="election.status == 'Active'">
                <span v-if="!row.item.final_list">
                    <span style="color: red">Inactive</span>

<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'final_list','1')"
                            data-toggle="tooltip" data-placement="top"
                            title="Active"><i class="far fa-check-circle"></i></button>-->
                </span>
                <span v-else>
                    <span style="color: green">Activated</span>
                    <span v-if="checkAccess('print-voter')">
                        <a class="btn btn-icon" target="_blank" title="Print Voter"
                           :href="addProjectPath('/print_voter/'+ row.item.id)">Print</a>
                    </span>
<!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'final_list','0')"
                            data-toggle="tooltip" data-placement="top"
                            title="Inactive"><i class="far fa-times-circle"></i></button>-->
                </span>
                </span>

                <span v-if="election.status == 'Banned'">
                <span v-if="row.item.vote_cast == 0">
                    <span style="color: red">Not Casting</span>

                    <!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'final_list','1')"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Active"><i class="far fa-check-circle"></i></button>-->
                </span>
                <span v-else>
                    <span style="color: green">Casted</span>
                    <!--                    <button class="btn btn-icon" @click="deleteMember(row.item.id,'final_list','0')"
                                                data-toggle="tooltip" data-placement="top"
                                                title="Inactive"><i class="far fa-times-circle"></i></button>-->
                </span>
                </span>

            </template>
            <template #cell(actions)="row">
                <span v-if="checkAccess('edit-voter')">
                    <router-link v-if="election.status == 'Pending' || election.status == 'Verified' || election.status == 'Inspected'"
                        :to="{name: 'edit-voter',params: { id: row.item.id}}"
                        class="btn btn-icon edit" title="Edit Voter" target="_blank">Edit
                    </router-link>
                </span>
                <span v-if="checkAccess('view-voter')">
                    <router-link
                        :to="{name: 'view-voter',params: { id: row.item.id}}"
                        class="btn btn-icon edit" title="Show Voter" target="_blank">View
                    </router-link>
                </span>
            </template>

        </b-table>


        <div id="loader" v-if="loading"
             v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
    </div>
</template>

<script>
import JsonExcel from "vue-json-excel";
import ValidationErrors from "../ValidationErrors";

export default {
    name: "AllVoter",
    components: {JsonExcel,ValidationErrors},
    data: () => ({
        select_location:'',
        select_voter:'',
        warning_message:null,
        success:null,
        errors: [],
        validationErrors: null,
        election: {
            name: null,
            election_session: null,
            election_date: null,
            status: 'Pending'
        },
        loading: false,
        voters: [],
        // active_voters: [],
        fields: [
            {
                key: 'member',
                label: 'Organization Name',
                sortable: true,
            }, 'voter_name', 'voter_location', 'voter_number',
            {key: 'all_list', label: 'Activation', sortable: true},'actions'],
        json_fields: {
            "VOTER No": {
                field: "voter_number",
                callback: (value) => {
                    return '\''+value.toString();
                },
            },
            'NAME OF THE VOTER ORGANIZATION': "member",
            'NAME OF THE VOTER': "voter_name",
            'REGION': "voter_location",
            'ADDRESS': "voter_address",
            'TIN NUMBER': "voter_e_tin_no",
            'NID/PASSPORT NO': "voter_nid_no",
            'LOCATION':"voter_location"
        },
        currentPage: 1,
        perPage: 10,
        isBusy: false,
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        totalRows: 1,
        filter: null,
        sortOptions: ['Dhaka','Chattogram'],
        filterOn: ['member'],
        organizations: [],
        header: [''],

    }),
    computed: {
        // Pending - Verified(Due Voter List) - Inspected(Preliminary Voter List) - Active(Final Voter List)
        pageHeader() {
            // `this` points to the component instance
            return this.election.status == 'Active' ? 'FINAL' :
                this.election.status == 'Banned' ? 'Archived' :
                    this.election.status == 'Inspected' ? 'Preliminary' :
                        this.election.status == 'Verified' ? '': '';
        },
        // sortOptions() {
        //     // Create an options list from our fields
        //     return this.fields
        //         .filter(f => f.sortable)
        //         .map(f => {
        //             return { text: f.label, value: f.key }
        //         })
        // }
    },
    created: function () {
        this.getOrganizations();
        // this.getVoters();
    },

    methods: {
        doFilterByDate() {


            this.loading = true;
            axios
                .get('/api/voter?' +
                    'election_id=' + this.$route.params.election_id +
                    '&select_location=' + this.select_location +
                    '&select_voter=' + this.select_voter
                )
                .then(res => {
                    this.election = res.data.election
                    this.voters = res.data.voters
                    this.totalRows = this.voters.length
                }).catch(error => {
                console.error(error.response)
            }).finally(() => {
                this.loading = false
            });

        },
        setFilterOn(){
            alert('Alhamdulillah')
        },
        makeList(list) {
            if (confirm("Do you really want to do it?")) {
                this.loading = true;
                axios
                    .put('/api/election/' + this.election.id + '?list=' + list)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getVoters();
                    }).catch(error => {
                    console.error(error)
                }).finally(() => {
                    this.loading = false
                });
            }
        },
        deleteMember(id, activation_key, activation_value) {
            if (confirm("Do you really want to do it?")) {
                axios
                    .put('/api/voter/' + id + '?activation_key=' + activation_key + '&activation_value=' + activation_value)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getVoters();
                    }).catch(error => {
                    console.error(error)
                })
            }
        },
        beforeExcelGenerate() {
            this.loading = true
            this.header[1] = this.pageHeader + ' VOTER LIST FOR ELECTION OF THE BOARD OF DIRECTORS OF BAFFA'
        },
        getOrganizations() {
            axios
                .get('/api/members/organizations')
                .then(res => {
                    this.organizations = res.data
                }).catch(error => {
                console.error(error)
            })
        },
        getVoters() {
            this.loading = true;
            axios
                .get('/api/voter?election_id=' + this.$route.params.election_id)
                .then(res => {
                    this.election = res.data.election
                    this.voters = res.data.voters
                    // if(this.election.status == '')
                    //     this.active_voters = res.data.voters.filter(x => x.preliminary_list !== false)
                    this.totalRows = this.voters.length
                }).catch(error => {
                console.error(error.response)
            }).finally(() => {
                this.loading = false
            });
        }
    }
}
</script>

<style scoped>
#loader {
    /* Loader Div Class */
    position: fixed;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #eceaea;
    background-size: 50px;
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>
