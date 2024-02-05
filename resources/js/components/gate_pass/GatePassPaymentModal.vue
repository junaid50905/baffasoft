<template>
    <b-modal
        id="modal-make-payment"
        ref="modal"
        title="MONEY RECEIPT"
        @ok="handleOK"
        @hidden="resetModal"
        @cancel="handleCancel"
        @show="beforeShow"
        cancel-title="No"
        ok-variant="success"
        cancel-variant="danger"
        ok-title="Yes"
        button-size="lg"
        hide-header-close
        no-close-on-backdrop
        no-close-on-esc
        :busy="busy"
    >
        <b-alert v-if="alertMessage" show variant="danger">{{ alertMessage }}</b-alert>
        <b-row>
            <b-col>
                <form ref="form" @submit.stop.prevent="handleSubmit" role="form" id="privilege"
                      autocomplete="off">
                    <b-form-group
                        label="Amount"
                        label-for="name-input"
                        invalid-feedback="Name is required"
                        :state="nameState"
                    >
                        <b-form-input
                            id="name-input"
                            placeholder="Enter Amount"
                            type="number"
                            v-model="deposit"
                            :state="nameState"
                            min="50"
                            max="100000"
                            no-wheel
                            number
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="Description"
                        label-for="name-input"
                    >
                        <b-form-input
                            id="name-input"
                            placeholder="Description"
                            type="text"
                            v-model="description"
                        ></b-form-input>
                    </b-form-group>
                    <template v-if="is_new_payment">
                        <b-form-checkbox disabled class="mb-2 mr-sm-2 mb-sm-0" v-model="new_payment" value="100">New
                        </b-form-checkbox>
                        <b-form-checkbox v-if="hasUpdatelListener" disabled class="mb-2 mr-sm-2 mb-sm-0" v-model="amend" value="50">Amend
                        </b-form-checkbox>
                    </template>
                    <b-form-checkbox v-if="!is_new_payment" disabled class="mb-2 mr-sm-2 mb-sm-0" v-model="amend" value="50">Amend
                    </b-form-checkbox>
                </form>
            </b-col>
            <b-col>
                <p>Transaction Summary</p>
                <table class="table" id="trnsaction_table">
                    <tbody>
                    <tr>
                        <th>Balance(+)</th>
                        <td>{{ openingBalance | parseFloat }}</td>
                    </tr>
                    <tr>
                        <th>Deposit(+)</th>
                        <td>{{ deposit | parseFloat }}</td>
                    </tr>
                    <tr>
                        <th>Withdraw(-)</th>
                        <td>
                            {{ withdraw }}
                        </td>
                    </tr>
                    <tr>
                        <th>Summary</th>
                        <td><b>
                            {{ currentBalance }}
                        </b></td>
                    </tr>
                    </tbody>
                </table>
            </b-col>
        </b-row>


        <!--                    <input type="number" name="amount" v-model="amount">-->
    </b-modal>
</template>

<script>
export default {
    name: "GatePassPaymentModal",
    data: () => ({
        new_payment: 100,
        amend: 50,
        alertMessage: '',
        deposit:0,
        description: 'Gate Pass / Amend',
        nameState: null,
        busy:false
    }),
    props: {
        openingBalance:{
            type: Number,
            default: 0
        },
        is_new_payment: {
            type: Boolean,
            default: true
        },
        payment_from_list: {
            type: Boolean,
            default: false
        },
        user_id: {
            type: Number,
            required: true
        },
        selected_member_id: {
            type: Number
        },
        selected_id_no:{
            type: Number
        }
    },
    filters: {
        parseFloat: function (amount) {
            if (!amount) return 0.00
            return parseFloat(amount).toFixed(2)
        }
    },
    computed: {
        hasUpdatelListener(){
            // return this.$listeners && this.$listeners.saveGatePass
            if(this.$listeners && this.$listeners.updateGatePass)
                return true
            else
                return false
        },
        // amend: function (){
        //     return this.is_new_payment ? 0 : 50
        // },
        withdraw: function () {
            if(this.is_new_payment){
                if(!this.hasUpdatelListener)
                    this.amend = 0
            }else{
                this.new_payment = 0
            }
            let new_payment = this.new_payment ? this.new_payment : 0
            let amend = this.amend ? this.amend : 0
            return (parseFloat(new_payment) + parseFloat(amend)).toFixed(2)
        },
        currentBalance: function () {
            let openingBalance = this.openingBalance
            let deposit = this.deposit ? this.deposit : 0
            let withdraw = this.withdraw ? this.withdraw : 0
            return (parseFloat(openingBalance) + parseFloat(deposit) - parseFloat(withdraw)).toFixed(2)
        }
    },
    methods:{
        beforeShow(){
          console.log('show');
        },
        handleOK(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.handleSubmit()
        },
        resetModal() {
            this.deposit = null
            this.description = 'Gate Pass / Amend'
            this.nameState = null
            this.alertMessage = ''
            this.busy = false
        },
        handleCancel() {
            console.log('Cancel')
            this.$nextTick(() => {
                this.$bvModal.hide('modal-make-payment')
                this.$emit('loading')                   // Stop Loading in Edit and New GatePass
            })
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        handleSubmit() {
            // if (!this.openingBalance) {
            //     if (!this.checkFormValidity()) {
            //         return
            //     }else{
            //         continue;
            //     }
            // }else{
                if (this.withdraw <= 0) {
                    this.alertMessage = 'Select New or Amend'
                    return
                }else if (this.currentBalance < 0) {
                    this.alertMessage = 'Summary must be greater than 0'
                    return
                }else if (this.currentBalance >= 0 && this.withdraw > 0) {
                    this.busy = true
                    if(this.is_new_payment)                             // Call From New GatePass Page
                        this.$emit('saveGatePass',this.doWithdraw)
                    if(this.payment_from_list)                          // Call From GatePass List Page
                        this.doWithdraw()
                    else                                                // Call From EDIT GatePass Page
                        this.$emit('updateGatePass',this.doWithdraw)
                }
            // }

            // console.log('OK',this.gatePassId)

        },
        doWithdraw() {
            axios.put('/api/gate_pass/' + this.selected_id_no, {
                // axios.post('/api/money_collection', {
                amount: this.withdraw,
                created_user_id: this.user_id
            })
                .then(resp => {
                    console.log('Withdraw', resp.data)
                    if (this.deposit > 0 && resp.data != 0) {
                        this.doDeposit();
                    } else {
                        if(this.payment_from_list)
                            this.$emit('allGatePass');
                        else
                            this.$router.push({name: "all-gate-pass", query: {success: this.success}});
                        // this.getGatePass();
                    }
                    // this.artists.data.splice(index, 1);
                })
                .catch(error => {
                    console.error(error);
                }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-make-payment')
                })
            })
        },
        doDeposit() {
            // axios.put('/api/gate_pass/'+id,{created_user_id:this.user.id})
            axios.post('/api/money_collection', {
                member_id: this.selected_member_id,
                amount: this.deposit,
                receipt_type: 'gate_pass',
                description: this.description,
                created_user_id: this.user_id
            })
                .then(resp => {
                    console.log('Deposit', resp.data)
                    this.$router.push({name: "invoice", params: {id: resp.data.id}});
                    // this.artists.data.splice(index, 1);
                })
                .catch(error => {
                    console.error(error);
                })
        },
        // adjustBalance(){
        //     axios.put('/api/members/update_balance/'+this.selected_member_id, {amount: this.currentBalance})
        //         .then(resp => {
        //             console.log('Now Balance: ', this.currentBalance)
        //             this.doWithdraw()
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         })
        // },
        // getGatePass() {
        //     this.loading = true;
        //     axios
        //         // .get('/api/gate_pass?year=' + this.$route.query.year)
        //         .get('/api/gate_pass')
        //         .then(res => {
        //             this.members = res.data.data
        //             this.totalRows = this.members.length
        //         }).catch(error => {
        //         console.error(error)
        //     }).finally(() => {
        //         this.loading = false
        //     });
        // },
    }
}
</script>

<style scoped>

</style>
