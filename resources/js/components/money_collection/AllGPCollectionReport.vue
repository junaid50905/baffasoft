<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div
                    id="loader"
                    v-if="loading"
                    v-bind:style="{
            backgroundImage: 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')',
          }"
                ></div>
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors
                        :errors="validationErrors"
                        :success="success"
                        :warning_message="warning_message"
                    ></validation-errors>
                    <b-row>
                        <b-col sm="9" md="9"></b-col>
                        <b-col sm="3" md="3" class="my-1">
                            <json-excel
                                class="btn btn-sm btn-outline-success"
                                :header="header"
                                :data="members"
                                :fields="json_fields"
                                :before-generate="beforeExcelGenerate"
                                :before-finish="() => (loading = false)"
                                worksheet="BAFFA Worksheet"
                                name="MoneyCollection.xls"
                            >
                                Download Data as Excel
                                <i class="fas fa-file-excel text-success"/>
                                <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                            </json-excel>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="5" md="6" class="my-1">
                            <v-select
                                placeholder="Select User"
                                v-model="selected_user"
                                :options="users"
                                label="username"
                            ></v-select>
                            <!--                            @input="setUser"-->
                            <!--                            :reduce="users => users.id"-->
                        </b-col>
                        <b-col sm="5" md="6" class="my-1">
                            <v-select
                                placeholder="Select Member Name"
                                v-model="selected_bmn_no"
                                :options="organizations"
                                :reduce="(organizations) => organizations.username"
                                label="organization_name"
                            ></v-select>
                            <!--                            <v-select v-model="selected" @input="setSelected" :options="options" @search="fetchOptions"></v-select>-->
                            <!--                            @input="setSelected"-->
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="5" md="5" class="my-1">
                            <datepicker
                                input-class="form-control form-control-sm"
                                name="seconded_by_date"
                                v-model="start_date"
                            />
                        </b-col>
                        <b-col sm="5" md="5" class="my-1">
                            <datepicker
                                input-class="form-control form-control-sm"
                                name="seconded_by_date"
                                v-model="end_date"
                            />
                        </b-col>
                        <b-col sm="2" md="2" class="my-1">
                            <div class="d-grid gap-2">
                                <b-button size="sm" :disabled="!end_date" @click="doFilter"
                                >Generate Report
                                </b-button
                                >
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
                    <br/>
                    <b-table
                        striped
                        hover
                        small
                        show-empty
                        id="table-transition-example"
                        primary-key="receipt_no"
                        :items="members"
                        :fields="fields"
                        :current-page="currentPage"
                        :per-page="perPage"
                        :busy.sync="isBusy"
                    >
                        <!--                        <template #cell(sl_no)="data">-->
                        <!--                            {{ data.index + 1 }}-->
                        <!--                        </template>-->
                        <template #cell(actions)="row">
              <span v-if="row.item.is_active">
                <!--                                <router-link
                                    :to="{name: 'invoice',params: { id: row.item.id }}"
                                    class="btn btn-icon"
                                    title="Invoice" target="_blank"
                                    data-toggle="tooltip" data-placement="top"
                                ><i class="fas fa-download"></i>
                                </router-link>-->
                <a
                    class="btn btn-icon"
                    target="_blank"
                    :href="addProjectPath('/print_money_receipt/' + row.item.id)"
                >
                  <i class="fas fa-download"></i>
                </a>
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
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";

export default {
    name: "AllGPCollectionReport",
    components: {ValidationErrors, JsonExcel, vSelect, Datepicker},
    props: ["warning_message", "success"],
    data: () => ({
        start_date: new Date().toISOString().slice(0, 10),
        end_date: new Date().toISOString().slice(0, 10),
        organizations: [],
        users: [],
        header: ["MONEY COLLECTION REPORT"],
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
        json_fields: {
            "SL.NO": "sl_no",
            CREATED: "transaction_date",
            "RECEIPT NO": "receipt_no",
            "RECEIPT Type": "receipt_type",
            YEAR: "receipt_year",
            MONTH: "receipt_month",
            "MEMBER NAME": "member_name",
            "MEMBER NO": "member_no",
            AMOUNT: "amount",
            "MODE OF RECEIPT": "payment_type",
            "CHEQUE/PAY ORDER NO.": "payment_chq_no",
            DATE: "payment_chq_date",
            BANK: "payment_bank",
            "RECEIVED BY": "received_by",
        },
        fields: [
            "sl_no",
            "receipt_no",
            {
                key: "receipt_type",
                label: "Type",
                sortable: true,
                // Variant applies to the whole column, including the header and footer
                variant: "danger",
            },
            {
                key: "receipt_year",
                label: "Year",
            },
            {
                key: "transaction_date",
                label: "Date",
            },
            // "Year",
            "member_name",
            "member_no",
            "amount",
            "received_by",
            "actions",
        ],
    }),
    created() {
        this.getGatePass();
        this.getUsers();
        this.getOrganizations();
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true;
            this.user = window.Laravel.user;
            // this.member_name = window.Laravel.user.email
        } else {
            console.log("Member Not Log In");
        }
    },
    methods: {
        // onSearch(search, loading) {
        //     console.log('V:',search,loading)
        //     if(search.length) {
        //         // loading(true);
        //         this.options = this.a_options;
        //         // this.search(loading, search, this);
        //     }
        // },
        // search: _.debounce((loading, search, vm) => {
        //     fetch(
        //         `https://api.github.com/search/repositories?q=${escape(search)}`
        //     ).then(res => {
        //         res.json().then(json => (vm.options = json.items));
        //         loading(false);
        //     });
        // }, 350),
        //
        fetchOptions(search, loading) {
            loading(true);
        },
        customFormatter(date) {
            return moment(date).format("YYYY-MM-DD");
        },
        beforeExcelGenerate() {
            this.loading = true;
            this.header[1] =
                "DATE RANGE : " +
                moment(this.start_date).format("DD/MM/YYYY") +
                " - " +
                moment(this.end_date).format("DD/MM/YYYY");
        },
        // setSelected(value)
        // {
        //     this.loading = true;
        //     console.log('Value: ',value)
        //     if(value){
        //         axios
        //             .get('/api/money_collection?bmn_no='+ value)
        //             .then(res => {
        //                 this.members = res.data.data
        //                 this.members.map((e, i) => e.sl_no = i + 1);
        //                 this.totalRows = this.members.length
        //             }).catch(error => {
        //             console.error(error)
        //         }).finally(()=>{
        //             this.loading =  false
        //         });
        //     }else{
        //         this.getGatePass()
        //     }
        // },
        // setUser(value)
        // {
        //     console.log(value)
        // this.loading = true;
        // console.log('Value: ',value)
        // if(value){
        //     axios
        //         .get('/api/money_collection?user_id='+ value)
        //         .then(res => {
        //             this.members = res.data.data
        //             this.members.map((e, i) => e.sl_no = i + 1);
        //             this.totalRows = this.members.length
        //         }).catch(error => {
        //         console.error(error)
        //     }).finally(()=>{
        //         this.loading =  false
        //     });
        // }else{
        //     this.getGatePass()
        // }
        // },
        doFilter() {
            let start_date = this.customFormatter(this.start_date);
            let end_date = this.customFormatter(this.end_date);
            if (this.selected_user) {
                this.request_url =
                    "/api/money_collection?" +
                    "start_date=" +
                    start_date +
                    "&end_date=" +
                    end_date +
                    "&user_id=" +
                    this.selected_user.id +
                    "&user_name=" +
                    this.selected_user.username +
                    "&bmn_no=" +
                    this.selected_bmn_no;
            } else {
                this.request_url =
                    "/api/money_collection?" +
                    "start_date=" +
                    start_date +
                    "&end_date=" +
                    end_date +
                    "&user_id=" +
                    null +
                    "&user_name=" +
                    null +
                    "&bmn_no=" +
                    this.selected_bmn_no;
            }
            console.log(start_date, end_date, this.selected_bmn_no, this.request_url);
            if (end_date >= start_date) {
                this.loading = true;
                axios
                    .get(this.request_url)
                    .then((res) => {
                        this.members = res.data.data;
                        this.members.map((e, i) => (e.sl_no = i + 1));
                        this.totalRows = this.members.length;
                    })
                    .catch((error) => {
                        console.error(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            } else {
                alert("End Date is greater than start date");
            }
        },
        sendInfo(id) {
            this.gatePassId = id;
            console.log("Member", id);
            // this.selectedUser = item;
        },
        handleOK() {
            console.log("OK", this.gatePassId);
            this.createPayment(this.gatePassId);
            this.$nextTick(() => {
                this.$bvModal.hide("modal-make-payment");
            });
        },
        handleCancel() {
            console.log("Cancel");
            this.$nextTick(() => {
                this.$bvModal.hide("modal-make-payment");
            });
        },
        createPayment(id) {
            axios
                .put("/api/gate_pass/" + id, {created_user_id: this.user.id})
                .then((resp) => {
                    console.log("Success", resp.data);
                    // this.getGatePass();
                    this.$router.push({name: "gate-pass-invoice", params: {id: id}});

                    // this.artists.data.splice(index, 1);
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
        getGatePass() {
            this.loading = true;
            axios
                .get("/api/money_collection")
                .then((res) => {
                    this.members = res.data.data;
                    this.members.map((e, i) => (e.sl_no = i + 1));
                    this.totalRows = this.members.length;
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        getOrganizations() {
            axios
                .get("/api/members/organizations")
                .then((res) => {
                    this.organizations = res.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        getUsers() {
            axios
                .get("/api/all_users")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        deleteMember(id) {
            if (confirm("Do you really want to delete gate pass?")) {
                axios
                    .delete("/api/money-collection/" + id)
                    .then((res) => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getGatePass();
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
    },
};
</script>

<style>
.modal-backdrop {
    opacity: 0.1 !important;
}

.card-body {
    /* Components Root Element ID */
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
