<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                    <b-row v-if="!is_member">
                        <b-col sm="9" md="9"></b-col>
                        <b-col sm="3" md="3" class="my-1">
                            <json-excel
                                class="btn btn-sm btn-outline-success"
                                :header="header"
                                :data="members"
                                :fields="json_fields"
                                :before-generate="beforeExcelGenerate"
                                :before-finish="() => loading = false"
                                worksheet="BAFFA Worksheet"
                                name="CancelIDCard.xls"
                            >
                                Download Data as Excel
                                <i class="fas fa-file-excel text-success"/>
                                <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                            </json-excel>
                        </b-col>
                    </b-row>
                    <b-row v-if="!is_member">
                        <b-col sm="4" md="4" class="my-1">
                            <datepicker input-class="form-control form-control-sm" name="seconded_by_date"
                                        v-model="start_date"/>
                        </b-col>
                        <b-col sm="4" md="4" class="my-1">
                            <datepicker input-class="form-control form-control-sm" name="seconded_by_date"
                                        v-model="end_date"/>
                        </b-col>
                        <b-col md="4" class="my-1">
                            <v-select
                                placeholder="Select Status"
                                v-model="selected_status"
                                :options="all_status"></v-select>
                        </b-col>
                    </b-row>
                    <b-row v-if="!is_member" style="padding-bottom: 10px;">
                        <b-col md="4" class="my-1">
                            <v-select
                                placeholder="Select Member Name"
                                v-model="selected_bmn_no"
                                :options="organizations"
                                :reduce="organizations => organizations.username"
                                label="organization_name"></v-select>
                        </b-col>
                        <b-col sm="3" md="3" class="my-1">
                            <b-form-input style="height: 34px;" input-class="form-control form-control-sm"
                                          name="seconded_by_date" v-model="search_card_holder_name"
                                          placeholder="Search Card Holder Name"></b-form-input>
                        </b-col>
                        <b-col sm="3" md="3" class="my-1">
                            <b-form-input style="height: 34px;" input-class="form-control form-control-sm"
                                          name="seconded_by_date" v-model="search_id_card_number"
                                          placeholder="Search ID Card Number"></b-form-input>
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" @click="doFilter">Generate Report</b-button>
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
                             primary-key="receipt_no"
                             :items="members"
                             :fields="fields"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :busy.sync="isBusy"
                    >
                        <!--                            <template #cell(sl_no)="data">
                                                        {{ data.index + 1 }}
                                                    </template>-->
                        <template #cell(id_card.organizations)="row">
                            <div v-html="row.value"></div>
                            <!--                            {{row.value}}-->
                        </template>
                        <template #cell(id_card.card_holder_name)="row">
                            <router-link
                                :to="{name: 'view-id-card',params: { id: row.item.id_card.id }}"
                                class="btn btn-link btn-sm text-black-50">{{ row.value }}
                            </router-link>
                        </template>
                        <template #cell(status)="row">
                            <span class="badge bg-secondary"><strong>{{ row.value }}</strong></span>
                            <!--                            <div class="alert alert-dark"><strong>{{row.value}}</strong></div>-->
                        </template>
                        <template #cell(actions)="row">
                           <span v-if="!is_member">
                               <router-link
                                   :to="{name: 'view-cancel-id-card-form',params: { id: row.item.id,panel: 'view' }}"
                                   class="btn btn-success btn-sm">View</router-link>
                               <span v-if="row.item.status == 'Pending'">
                                    <b-button @click="verifiedIdCard(row.item.id)"
                                              class="btn btn-danger btn-sm"> Cancel </b-button>
                                </span>
                           </span>
                            <span v-else>
                               <router-link
                                   :to="{name: 'cancel-id-card-form',params: { id: row.item.id,panel: 'view' }}"
                                   class="btn btn-success btn-sm">View</router-link>
                           </span>
                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../../ValidationErrors";
import JsonExcel from "vue-json-excel";
import vSelect from 'vue-select';
import Datepicker from "vuejs-datepicker";
import moment from "moment";

export default {
    name: "CancelIdCardPanel",
    components: {ValidationErrors, JsonExcel, vSelect, Datepicker},
    props: ['warning_message', 'success', 'is_member'],
    data: () => ({
        start_date: new Date().toISOString().slice(0, 10),
        end_date: new Date().toISOString().slice(0, 10),
        selected_status: null,
        search_card_holder_name: null,
        search_id_card_number: null,
        organizations: [],
        all_status: ['Pending', 'Canceled'],
        users: [],
        header: ['<h2>Cancelled ID Card list</h2>', '<p></p>'],
        selected_user: null,
        request_url: null,
        selected_bmn_no: null,
        gatePassId: null,
        members: null,
        indexMembers: null,
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
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        all_json_fields: {},
        json_fields: {
            'Date': "created_at",
            'ID Card No.': "id_card.id_card_number",
            'Proximity ID No.': "id_card.proximity_number",
            'Card Holder\'s Name': "id_card.card_holder_name",
            'Designation': "id_card.card_holder_designation",
            'Name of the Organization': "id_card.organizations",
            'Cancel Date': "submit_date",
            'Status': "status"
        },
        fields: [{
            key: 'created_at',
            label: 'Created At',
        }, {
            key: 'id_card.id_card_number',
            label: 'Card Number',
            sortable: true
        }, {
            key: 'id_card.card_holder_name',
            label: 'Card Holder Name',
            sortable: true,
            variant: 'danger'
        }, {
            key: 'id_card.organizations',
            label: 'Organization Name',
            formatter: value => {
                return value.toString().replaceAll(",", "<br/>")
            }
        }, {key: 'submit_date', label: 'Cancelation Date'}, 'status', 'actions'],
    }),
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
            this.getGatePass()
            this.getOrganizations()
        } else {
            console.log('Member Not Log In')
        }
    },
    methods: {
        fetchOptions(search, loading) {
            loading(true);
        },
        customFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },
        beforeExcelGenerate() {
            this.loading = true
            // let aJson = {}
            // let current_year = moment(this.start_date).format('YYYY')
            // this.header[2] = 'ID Card List: ' + current_year
            // aJson['BAFFA ' + current_year + ' ID Card No.'] = "id_card_number"
            // let str = JSON.stringify(this.all_json_fields);
            // str = str.replace(/current_year/g, current_year);
            // str = str.replace(/old_year/g, current_year - 1);
            // this.json_fields = JSON.parse(str);

            // this.json_fields.SSS = "id_card_number"
            // this.json_fields.unshift({first_element:"id_card_number"})
            // this.json_fields['BAFFA ' + current_year + ' ID Card No.'] = "id_card_number"
            // this.json_fields = {aJson,...this.all_json_fields};
            // this.json_fields = {aJson,...this.all_json_fields};
            // this.json_fields = JSON.parse(this.all_json_fields);
            // this.json_fields['BAFFA ID Card No.'] = this.json_fields['BAFFA ' + current_year + ' ID Card No.'];
            // delete this.json_fields['BAFFA ID Card No.'];

        },
        verifiedIdCard(id) {
            if (confirm("Confirm Cancel ?")) {
                axios.put("/api/id_cards/cancel/" + id).then(res => {
                    // console.log(res.data)
                    this.getGatePass();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                });
            }
            // console.log('ID Card ID', id)
        },
        doFilter() {
            let start_date = this.customFormatter(this.start_date)
            let end_date = this.customFormatter(this.end_date)
            this.request_url = '/api/id_cards/cancel/all?' +
                'search_panel=true' +
                '&start_date=' + start_date +
                '&end_date=' + end_date +
                '&status=' + this.selected_status +
                '&search_card_holder_name=' + this.search_card_holder_name +
                '&search_id_card_number=' + this.search_id_card_number +
                '&bmn_no=' + this.selected_bmn_no;
            this.loading = true;
            axios.get(this.request_url)
                .then(res => {
                    this.members = res.data.data
                    // this.members.map((e, i) => e.sl_no = i + 1);
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error)
            }).finally(() => {
                this.loading = false
            });
        },
        getGatePass() {
            // if(!is_member)this.user.username
            let url = '/api/id_cards/cancel/all';
            if (this.is_member && this.user)
                url = '/api/id_cards/cancel/all?member_id=' + this.user.id
            this.loading = true;
            axios
                .get(url)
                .then(res => {
                    this.members = res.data.data
                    this.members.map((e, i) => e.sl_no = i + 1);
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
</style>
