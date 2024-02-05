<template>
    <div>
        <notifications group="max_print" position="bottom right" />
          <div class="card" style="min-height: 400px;">
            <div class="card-body">
                <main id="printInvoice" style="display: none;">

                    <div class="receipt">
                        <div class="box1">
                            <img :src="addProjectPath('/front/assets/img/logo.png')" alt="BAFFA">
                            <div>
                                <h2 class="upper-p">BANGLADESH FREIGHT FORWARDERS ASSOCIATION</h2>
                                <p class="upper-p">Ataturk Tower(8th Floor), 22 Kemal Ataturk Avenue, Banani, Dhaka-1213, Bangladesh</p>
                                <p class="upper-p">Tel: 9881663, 8836325, Fax: 880-2-9881664, Email: info@baffa-bd.org, www.baffa-bd.org</p>
                            </div>
                        </div>
                        <h2 class="text-center">MONEY RECEIPT</h2>
                        <div class="main-box">
                            <div class="box2">
                                <p><b>Receipt No:</b> {{formData.receipt_no}} </p>
                                <p><b>Date :</b> {{formData.transaction_date}}</p>
                            </div>
                            <div class="box3">
                                <p><b>Member Name:</b> {{formData.member_name}}</p>
                                <p><b>Member No:</b> {{formData.member_no}}</p>
                            </div>
                            <p>Received With Thanks Tk.<b>{{formData.amount}}</b> <span style="padding-left: 15px;">from (company)
                                <b> {{formData.member_name}}</b></span></p>
                            <p><b>Taka(In Words):</b> {{ formData.amount | toWords }} TAKA</p>

                        </div>

                        <p><i><b>Note : This is a system generated document hence need no signature</b></i></p>
                    </div>
                </main>
                <div class="box12">
<!--                    <div class="d-grid gap-2 col-6 mx-auto pt-3">-->
<!--                        <button v-print="printObj" type="submit" v-bind:class="[printLoading ? 'disabled btn-secondary' : 'btn-secondary','btn']" id="loader-btn">
                            <span>Print Preview</span>
                            <div id="loader" v-if="printLoading" v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}" ></div>
                        </button>-->
<!--                        <button class="btn btn-secondary" @click="printDoc">Print Old</button>-->
<!--                        <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>-->
                        <a class="btn btn-success btn-lg btn-block" target="_blank" :href="addProjectPath('/print_money_receipt/'+ $route.params.id)">Print Money Receipt</a>
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import converter from "number-to-words";
import {publicPath} from "../../../../vue.config";
import print from 'vue-print-nb'
export default {
    name: "Invoice",
    components: {moment,print,converter},
    data(){
        return{
            formData: {
                date: null,
                receipt_no: null,
                member_no: null,
                member_name: null,
                amount: null,
                // company:null
            },
            printLoading: false,
            printObj: {
                id: "printInvoice",
                preview: true,
                previewTitle: 'MONEY RECEIPT',
                previewPrintBtnLabel: 'Print',
                popTitle: 'MONEY-RECEIPT',
                beforeOpenCallback (vue) {
                    this.printLoading = true
                    console.log('beforeOpenCallback')
                },
                openCallback (vue) {
                    this.printLoading = false
                    console.log('openCallback')
                }
                // closeCallback (vue) {
                //     console.log('closeCallback')
                // }
            }

        }
    },
    filters: {
        toWords: function (value) {
            if (!value) return ''
            return converter.toWords(value).toUpperCase();
        }
    },
    // data: () => ({
    //     form: {
    //         master_airway_bill_no: 'ssss',
    //         date: new Date().toISOString().slice(0, 10),
    //         vehicle_date_of_entry: new Date().toISOString().slice(0, 10),
    //         vehicle_time_of_entry: new Date().toISOString().slice(11, 16),
    //         weight_taken_date_time: new Date(),
    //     }
    //
    // }),
    created() {
        // this.getGatePass()
    },
    methods: {
        getGatePass() {
            axios.get('/api/money_collection/' + this.$route.params.id)
                .then(res => {
                    this.formData = res.data.data
                    console.log(res.data)
                    this.formData.date = moment(String(res.data.data.transaction_date)).format('YYYY-MM-DD HH:mm:ss');
                    //     this.formData.receipt_no = res.data.receipt_no;
                    //     this.formData.member_no = res.data.member_no;
                    //     this.formData.member_name = res.data.member_name;
                    //     this.formData.amount = res.data.amount;
                        // this.formData.company = res.data.member_detail.firm_name;
                    // this.form['nationality_id'] = 50
                    // this.form['birth_date'] = '2021-10-18 04:58:34'
                }).catch(error => {
                console.log('Error: ',error)
            })
        },
        printDoc() {
          window.print();
        }
    }
}
</script>
<style scoped>
#loader-btn{
    position: relative;
}
#loader-btn #loader{
    /* Loader Div Class */
    position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
@media print {
    body * {
        visibility: hidden;
    }
    #printInvoice, #printInvoice * {
        visibility: visible;
    }
}
h2 {
    text-align: center;
    /*font-size: 1.6rem;*/
}
h2.text-center{
    padding-top: 25px;
}
.box1 {
    display: flex;
}
.box1 > img{
    flex: 10%;
}
.box1 > div{
    flex: 90%;
}
.box1 p {
    text-align: center;
}

.main-box {
    border: 1px solid black;
    padding: 0 12px;
}

.box2 {
    display: flex;
    justify-content: space-between;
}

.box3 {
    display: flex;
    justify-content: space-between;
}

.receipt {
    margin: auto;
    min-width: 635px;
}

.receipt p {
    font-size: 15px;
    color: black;
}

.receipt .upper-p {
    margin-bottom: 0;
}
</style>
