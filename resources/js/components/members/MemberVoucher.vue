<template>
    <div>

        <div class="card">
            <div class="card-header">
                <b-table stacked="md" :items="members" :fields="member_fields"></b-table>
            </div>
            <div class="card-body">
                <div id="loader" v-if="loading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                <b-row>
                    <b-col sm="5" md="6" class="my-1">
                        <div class="table-responsive" id="users-table-wrapper">
                            <b-row>
                                <b-col sm="12" md="6"><h3>Deposit - {{total_deposit}}</h3></b-col>
                                <b-col sm="12" md="6" class="my-1">
                                    <json-excel
                                        class="btn btn-sm btn-outline-success"
                                        header="Deposit"
                                        :data="deposit"
                                        :fields="deposit_json_fields"
                                        :before-generate="beforeExcelGenerate"
                                        :before-finish="() => loading = false"
                                        worksheet="Deposit"
                                        name="DepositReport.xls"
                                    >
                                        Download
                                        <i class="fas fa-file-excel text-success"/>
                                        <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                                    </json-excel>
                                </b-col>
                            </b-row>
                            <b-table sticky-header head-variant="light"
                                     striped hover small show-empty
                                     id="table-transition-example"
                                     primary-key="id"
                                     :items="deposit"
                                     :fields="deposit_fields"
                                     :tbody-transition-props="transProps"
                                     :busy.sync="isBusy"
                            >
                            </b-table>
                        </div>
                    </b-col>
                    <b-col sm="5" md="6" class="my-1">
                        <div class="table-responsive" id="users-table-wrapper">
                            <b-row>
                                <b-col sm="12" md="6"><h3>Withdraw - {{total_withdraw}}</h3></b-col>
                                <b-col sm="12" md="6" class="my-1">
                                    <json-excel
                                        class="btn btn-sm btn-outline-success"
                                        header="Withdraw"
                                        :data="withdraw"
                                        :fields="withdraw_json_fields"
                                        :before-generate="beforeExcelGenerate"
                                        :before-finish="() => loading = false"
                                        worksheet="Withdraw"
                                        name="WithdrawReport.xls"
                                    >
                                        Download
                                        <i class="fas fa-file-excel text-success"/>
                                        <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
                                    </json-excel>
                                </b-col>
                            </b-row>

                            <b-table sticky-header head-variant="light"
                                     striped hover small show-empty
                                     id="table-transition-example"
                                     primary-key="id"
                                     :items="withdraw"
                                     :fields="withdraw_fields"
                                     :tbody-transition-props="transProps"
                                     :busy.sync="isBusy"
                            >
                            </b-table>
                        </div>
                    </b-col>
                </b-row>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import JsonExcel from "vue-json-excel";
export default {
    name: "MemberVoucher",
    components: {moment,JsonExcel},
    data: () => ({
        loading:false,
        members: [],
        member: null,
        total_deposit: 0,
        total_withdraw: 0,
        deposit: [],
        withdraw: [],
        isBusy: false,
        transProps: {
            // Transition name
            name: 'flip-list'
        },
        member_fields:['organization_name','username','gatepass_balance'],
        deposit_json_fields:{
            "Transaction Date": {
                field: "created_at",
                callback: (value) => {
                    return moment(new Date(value).toLocaleString()).format('DD-MM-YY');
                },
            },
            "Description": {
                field: "receipt_type",
                callback: (value) => {
                    return value.toString().toUpperCase().replaceAll('_', ' ');
                },
            },
            'Receipt No' : 'voucher_no',
            'Amount' : 'amount'},
        deposit_fields: [
            {
                key:'created_at',
                label:'Date',
                formatter: (value) => {
                    return moment(new Date(value).toLocaleString()).format('DD-MM-YY hh:mm a');
                }
            },'voucher_no','amount'
        ],
        withdraw_json_fields:{
            "Transaction Date": {
                field: "created_at",
                callback: (value) => {
                    return moment(new Date(value).toLocaleString()).format('DD-MM-YY');
                },
            },
            'Description' : 'purpose',
            'Amount' : 'amount'},
        withdraw_fields: [
            {
                key:'created_at',
                label:'Created Date',
                formatter: (value) => {
                    return moment(new Date(value).toLocaleString()).format('DD-MM-YY hh:mm a');
                }
            },
            {key:'paymentable.master_airway_bill_no',label:'MAWB'},
            {key:'amount',label:'Amount'},
            {key:'created_user.username',label:'User'}
        ]
    }),
    created() {
        this.getMembers()
    },
    methods: {
        getMembers() {
            this.loading =  true
            axios
                .get('/api/members/voucher/'+ this.$route.params.id)
                .then(res => {
                    this.deposit = res.data.deposit
                    this.withdraw = res.data.withdraw
                    this.total_deposit = res.data.total_deposit
                    this.total_withdraw = res.data.total_withdraw
                    this.member = res.data.member
                    this.members.push(res.data.member)
                    // this.totalRows = this.members.length
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(()=>{
                this.loading =  false
            });
        },
        beforeExcelGenerate() {
            this.loading = true
        }
    }
}
</script>

<style scoped>
</style>
