<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <b-row>
                        <b-col sm="4" md="4"></b-col>
                        <b-col sm="8" md="8" class="my-1">
                            <json-excel
                                class="btn btn-sm btn-outline-success"
                                :header="header"
                                :data="members"
                                :fields="json_fields"
                                :before-generate="beforeExcelGenerate"
                                :before-finish="() => loading = false"
                                worksheet="BAFFA Worksheet"
                                name="CargoFormReport.xls"
                            >
                                Download Data as Excel
                                <i class="fas fa-file-excel text-success"/>
                                <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                            </json-excel>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="10" md="10" class="my-1">
                            <b-form-input
                                id="filter-input"
                                v-model="filter"
                                type="search"
                                placeholder="MAWB NO ..."
                            ></b-form-input>
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" :disabled="!filter" @click="doFilter">Search
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="5" md="5" class="my-1">
                            <datepicker input-class="form-control form-control-sm" name="seconded_by_date"
                                        v-model="start_date"/>
                        </b-col>
                        <b-col sm="5" md="5" class="my-1">
                            <datepicker input-class="form-control form-control-sm" name="seconded_by_date"
                                        v-model="end_date"/>
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" :disabled="!end_date" @click="doFilterByDate">Generate Report
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="12" md="12" class="my-1">
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
                             :items="members"
                             :fields="fields"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :busy.sync="isBusy"
                    >
                        <template #cell(is_active)="row">
                          <span
                              v-bind:class="[row.value === 'Active' ? 'badge-success' : 'badge-warning', 'badge badge-lg']">
                                    {{ row.value }}
                                </span>
                        </template>
                        <template #cell(payments)="row">
                            <span v-if="row.value">
                                <span v-for="val in row.value.map(x => x.amount)"
                                      class="badge badge-secondary">{{ val }}</span>
                            </span>
                        </template>
                        <template #cell(actions)="row">
                            <span v-if="row.item.is_active">
                                <router-link v-if="!row.item.is_submit"
                                    :to="{name: 'member-edit-gate-pass',params: { id: row.item.id }}"
                                    class=""
                                    title="Edit"
                                    data-toggle="tooltip" data-placement="top"
                                >Edit</router-link>
                                <router-link v-if="row.item.is_submit"
                                             :to="{name: 'gate-pass-view',params: { id: row.item.id }}"
                                             class=""
                                             title="View"
                                             data-toggle="tooltip" data-placement="top"
                                >View</router-link>
                                <button v-if="!row.item.is_submit" class="bg-danger"
                                        @click="deleteMember(row.item.id)"
                                        data-toggle="tooltip" data-placement="top" title="Delete">X</button>
                            </span>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import JsonExcel from "vue-json-excel";
import vSelect from 'vue-select';
import Datepicker from "vuejs-datepicker";
import moment from "moment";

export default {
    name: "AllGatePassMember",
    components: {ValidationErrors, JsonExcel, vSelect, Datepicker, moment},
    props: ['warning_message', 'success'],
    data: () => ({
        header: ['CARGO ENTRY GATE PASS REPORT'],
        start_date: new Date().toISOString().slice(0, 10),
        end_date: new Date().toISOString().slice(0, 10),
        organizations: [],
        // new_payment: 100,
        // amend: 50,
        openingBalance: 0.00,
        // deposit: 0,
        // alertMessage: '',
        // nameState: null,
        // selected: null,
        gatePassId: null,
        selected_member_id: null,
        selected_id_no: null,
        members: null,
        errors: [],
        validationErrors: null,
        isLoggedIn: false,
        user: null,
        loading: false,
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        filter: null,
        mawb_no:null,
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        json_fields: {
            'MAWB NO': "master_airway_bill_no",
            'FLIGHT NO': "flight_no",
            'SHIPPER/EXPORTER': "name_of_shipper",
            'BMN': "bmn",
            'INVOICE NO': "shipper_invoice_no",
            'INVOICE DATE': "date",
            'WEIGHT(APPROX)': "weight",
            'CONTENTS': "contents",
            'DESTINATION': "destination",
            'ROUTING': "routing",
            'ON BEHAVE OF': "on_behalf_of_member_name",
            'ON BEHAVE OF NAME': "agent_name",
            'ID NO': "agent_id_no",
            'NO. OF PCS': "no_of_piece",
            'GROSS WEIGHT': "gross_weight",
            'CBM': "cbm",
            'VWT': "vwt",
            'CHARGABLE WEIGHT': "chargeable_weight",
            'DIMENSION(i)': "dimensioni",
            'DIMENSION(ii)': "dimensionii",
            'DIMENSION(iii)': "dimensioniii",
            'DIMENSION(iv)': "dimensioniv",
            'DIMENSION(v)': "dimensionv",
            'DIMENSION(vi)': "dimensionvi",
            'CREATED DATE': "created_at",
            'CREATED BY': "created_by",
            'LAST UPDATED DATE': "updated_at",
            'LAST UPDATED BY': "updated_by",
        },
        fields: [
            {
                key: 'master_airway_bill_no',
                label: 'MAWB NO',
                // sortable: true,
            }, 'flight_no',
            {
                key: 'name_of_shipper',
                label: 'Shipper'
            },
            // {
            //     key: 'balance_amount',
            //     label: 'Balance',
            //     variant: 'danger'
            // },
            'destination', 'weight',
            {
                key: 'created_at',
                label: 'Created'
            },
            // 'payments',
            // {
            //     key: 'payment',
            //     label: 'Amount'
            // }, 'is_active',
            'actions'],
    }),
    // filters: {
    //     parseFloat: function (amount) {
    //         if (!amount) return 0.00
    //         return parseFloat(amount).toFixed(2)
    //     }
    // },
    // computed: {
    //     withdraw: function () {
    //         let new_payment = this.new_payment ? this.new_payment : 0
    //         let amend = this.amend ? this.amend : 0
    //         return (parseFloat(new_payment) + parseFloat(amend)).toFixed(2)
    //     },
    //     currentBalance: function () {
    //         let openingBalance = this.openingBalance ? this.openingBalance : 0
    //         let deposit = this.deposit ? this.deposit : 0
    //         let withdraw = this.withdraw ? this.withdraw : 0
    //         return (parseFloat(openingBalance) + parseFloat(deposit) - parseFloat(withdraw)).toFixed(2)
    //     }
    // },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.member = window.Laravel.user;
            this.getGatePass();
            this.getOrganizations()
            // this.member_name = window.Laravel.user.email
        }else{
            console.log('Member Not Log In')
        }
    },
    methods: {
        doFilterByDate() {
            let start_date = this.customFormatter(this.start_date)
            let end_date = this.customFormatter(this.end_date)
            console.log(start_date, end_date);
            if (end_date >= start_date) {
                this.loading = true;
                axios
                    .get('/api/member_gate_pass/'+this.member.id +
                        '?start_date=' + start_date +
                        '&end_date=' + end_date
                    )
                    .then(res => {
                        this.members = res.data.data
                        this.totalRows = this.members.length
                    }).catch(error => {
                    console.error(error)
                }).finally(() => {
                    this.loading = false
                });
            } else {
                alert('End Date is greater than start date')
            }
        },
        customFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        beforeExcelGenerate() {
            this.loading = true
            this.header[1] = 'DATE RANGE : '
                + moment(this.start_date).format('DD/MM/YYYY')
                + ' - '
                + moment(this.end_date).format('DD/MM/YYYY')
        },
        fetchOptions(search, loading) {
            loading(true);
        },
        doFilter() {
            this.loading = true;
            axios
                .get('/api/member_gate_pass/'+this.member.id + '?mawb_no='+this.filter)
                .then(res => {
                    this.members = res.data.data
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = false
            });
        },
        // resetModal() {
        //     this.deposit = null
        //     this.nameState = null
        // },
        sendInfo({id, member_id, balance_amount}) {
            this.selected_id_no = id
            this.selected_member_id = member_id
            this.openingBalance = balance_amount
            console.log('Member BMN No.', id)
            // this.selectedUser = item;
        },
        getGatePass() {
            this.loading = true;
            axios
                // .get('/api/gate_pass?year=' + this.$route.query.year)
                .get('/api/member_gate_pass/'+this.member.id)
                .then(res => {
                    this.members = res.data.data
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = false
            });
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
        deleteMember(id) {
            if (confirm("Do you really want to delete gate pass?")) {
                axios
                    .delete('/api/gate_pass/' + id)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getGatePass();
                    }).catch(error => {
                    console.error(error)
                })
            }
        }
    }
}
</script>

<style>
.modal-backdrop {
    opacity: 0.1 !important;
}

.card-body { /* Components Root Element ID */
    position: relative;
}

.card-body #loader {
    /* Loader Div Class */
    position: absolute;
    top: 0;
    right: 0;
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
<style scoped>
img {
    width: 60px;
    height: 50px;
}

#trnsaction_table td, #trnsaction_table th {
    padding: 0;
}
</style>
