<template>
    <b-container class="bv-example-row">
        <b-row>
            <b-col>
                <div class="card">
                    <div class="card-header text-light bg-secondary bg-gradient text-center">
                        DOWNLOAD {{getHeader()}} VOTER LIST
                    </div>
                    <div class="card-body">
                        <b-row>
                            <b-col align="right"><h5>Election : {{election.name}}</h5></b-col>
                            <!--            <b-col><h2>Location : {{location}}</h2></b-col>-->
                        </b-row>
                        <b-row class="mb-2">
                            <b-col v-if="totalRows > 1">
                                <json-excel
                                    class="btn btn-sm btn-outline-success my-download"
                                    :header="header"
                                    :data="voters"
                                    :fields="json_fields"
                                    :before-generate="beforeExcelGenerate"
                                    :before-finish="() => loading = false"
                                    worksheet="BAFFA Worksheet"
                                    :name="file_name"
                                >
                                    Download
                                    <i class="fas fa-file-excel text-success"/>
                                    <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                                </json-excel>
                            </b-col>
                            <b-col v-else sm="12" md="12" class="my-1">
                                <h3 >No Voters</h3>
                            </b-col>
                        </b-row>
                        <div id="loader" v-if="loading"
                             v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                    </div>
                </div>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import JsonExcel from "vue-json-excel";
import ValidationErrors from "../ValidationErrors";

export default {
    name: "AllVoterDOwnload",
    props: ['list'],
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
        json_fields: {
            "VOTER No": {
                field: "voter_number",
                callback: (value) => {
                    return '\''+value.toString();
                },
            },
            'NAME OF THE VOTER ORGANIZATION': "member",
            'NAME OF THE VOTER': "voter_name",
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
        file_name: 'VOTERS.xls',
        pageHeader : ''

    }),
/*    computed: {
        // Pending - Verified(Due Voter List) - Inspected(Preliminary Voter List) - Active(Final Voter List)
        pageHeader() {
            // `this` points to the component instance
            /!*return this.election.status == 'Active' ? 'Final' :
                this.election.status == 'Banned' ? 'Archived' :
                    this.election.status == 'Inspected' ? 'Preliminary' :
                        this.election.status == 'Verified' ? '': '';*!/
            return this.list == 'due_list' ? 'Due' :
                this.list == 'preliminary_list' ? 'Preliminary' :
                    this.list == 'non_preliminary_list' ? 'Non Preliminary' : '';
        },
    },*/
    created: function () {
        window.scroll(0, 500)
        // this.getOrganizations();
        this.getVoters();
        this.file_name = this.getHeader() + ' VOTERS.xls'
        this.pageHeader = this.getHeader() + ' VOTER LIST FOR ELECTION OF THE BOARD OF DIRECTORS OF BAFFA';
    },

    methods: {
        getHeader() {
            // `this` points to the component instance
            /*return this.election.status == 'Active' ? 'Final' :
                this.election.status == 'Banned' ? 'Archived' :
                    this.election.status == 'Inspected' ? 'Preliminary' :
                        this.election.status == 'Verified' ? '': '';*/
            return this.list == 'due_list' ? 'NON' :
                this.list == 'preliminary_list' ? 'PRELIMINARY' :
                    this.list == 'non_preliminary_list' ? 'NON-PRELIMINARY' : '';
        },
        setFilterOn(){
            alert('Alhamdulillah')
        },
        beforeExcelGenerate() {
            this.loading = true
            this.header[1] = this.pageHeader
        },
        getVoters() {
            this.loading = true;
            axios
                .get('/api/voter?election_id=' + this.$route.params.election_id+'&list='+this.list)
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
.my-download{
    display: block;
    height: 53px;
    font-size: 20px;
    padding: 10px;
}
.bv-example-row{
    height: 300px;
}
</style>
