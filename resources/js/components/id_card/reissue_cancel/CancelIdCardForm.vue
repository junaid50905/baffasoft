<template>
    <div>
        <notifications group="foo" position="bottom right"/>
        <div class="card">
            <div class="card-header">
                <div id="notification">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>
                </div>
            </div>
            <div class="card-body">
                <main>
<!--                    <div>-->
<!--                        <button class="btn btn-dark" @click="doBack"><< Back</button>-->
<!--                    </div>-->
                    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="id-card-form"
                          novalidate>
                        <div class="container" id="printInvoice">
                            <div class="form-field" >

                                <!-- new form  -->
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="check1">Date: {{ created_at }}
<!--                                        <span v-if="$route.params.panel == 'new'">
                                            <input style="width: 120px;" type="date" name="submit_date" v-model="submit_date" id="datee"
                                                   class="form-check-input"/>
                                        </span>
                                        <span v-else> {{ submit_date }} </span>-->
                                    </label>
                                </div>
                                <p class="mt-3">To<br/>
                                    The Director<br/>
                                    Port & Customs and HR<br/>
                                    Bangladesh Freight Forwarders Association<br/>
                                    Hosue-10 (Level- 2 & 3), House-17A, Block-E<br/>
                                    Banani, Dhaka-1213</p>
                                <div class="form-check-inline mt-3">
                                    <label class="form-check-label font-weight-bold" for="check1">Subject: Request for
                                        cancel BAFFA ID card.</label>
                                </div>
                                <p class="mt-3">Dear Sir,</p>
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="check1">We would like to
                                        inform you that the following personnel of our company is not continuing with
                                        our organization, and we have no objection upon him/her if s/he joins any other
                                        organization. So, we would request you to cancel the following BAFFA ID Card of
                                        our organization.
                                    </label>
                                </div>

                                <table class="table mt-3">
                                    <thead>
                                    <tr>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Designation</th>
                                        <th scope="col">BAFFA ID Card No.</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">
                                                <ol style="">
                                                    <li v-for="member in form.members">{{ member }}</li>
                                                </ol>
                                        </th>
                                        <td>{{ form.card_holder_name }}</td>
                                        <td>{{ form.card_holder_designation }}</td>
                                        <td>{{ form.id_card_number }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p class="mt-5">Thanks for all of your continuous cooperation in this respect.</p>
                                <p style="height: 50px;"></p>
                                <p>Sincerely Yours</p>
                                <div class="signature mt-3">
                                    <div class="d-flex">
                                        <p>Name</p>
                                        <p>:  {{ form.company_owner }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <p>Designation</p>
                                        <p>:  {{ form.designation }}</p>

                                    </div>
                                    <div class="d-flex">
                                        <p>Company Name</p>
                                        <p>: {{form.members.toString()}}</p>
                                    </div>
                                </div>
                                <br/><br/>
                                <!-- new form end   -->
                            </div>
                        </div>
                        <div class="box12 mt-5">
                            <div class="d-grid gap-2 col-12 mx-auto">
                                    <button v-if="$route.params.panel == 'new'" type="submit"
                                            v-bind:class="[loading ? 'disabled btn-success' : 'btn-success','btn']"
                                            id="loader-btn" style="width:100%;font-size:20px;">
                                            <span>Create Cancel ID Card</span>
                                            <div id="loader" v-if="loading"
                                                v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                    </button>
                                    <button v-else type="button" class="btn btn-secondary btn-lg btn-block" @click="printDoc">Print</button>
                            </div>
                        </div>
                    </form>
                </main>


            </div>
        </div>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/id-card-style.css')">
    </div>
</template>

<script>
import ValidationErrors from "../../ValidationErrors";
import moment from "moment";
import vSelect from "vue-select";
import print from 'vue-print-nb';
export default {
    name: "CancelIdCard",
    components: {ValidationErrors, moment, vSelect, print},
    data: () => ({
        member_id: null,
        selected_organizations: [],
        loading: false,
        errors: [],
        validationErrors: null,
        success: null,
        warning_message:null,
        isLoggedIn: false,
        user: null,
        submit_date: new Date().toISOString().slice(0, 10),
        created_at: new Date().toISOString().slice(0, 10),
        form: {
            members:[],
        },
        printLoading: false,
        printObj: {
            id: "printInvoice",
            preview: true,
            previewTitle: 'Cancel - Id Card',
            previewPrintBtnLabel: 'Print',
            popTitle: 'Cancel - Id Card',
            beforeOpenCallback (vue) {
                this.printLoading = true
            },
            openCallback (vue) {
                this.printLoading = false
            }
            // closeCallback (vue) {
            //     console.log('closeCallback')
            // }
        }
    }),
    created() {
        if(this.$route.params.panel == 'new')
            this.getGatePass()
        else
            this.getIdCardCancel()
    },
    methods: {
        getIdCardCancel(){
            axios.get('/api/id_cards/cancel/' + this.$route.params.id)
                .then(res => {
                    this.submit_date = res.data.data.submit_date
                    this.created_at = res.data.data.created_at
                    this.form = res.data.data.id_card
                    this.form.members = this.form.organizations;
                }).catch(error => {
                console.log('Error: ', error.response)
            })

        },
        getGatePass() {
            axios.get('/api/id_cards/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    this.form.members = this.form.members.map(v => v.organization_name);
                    this.form.company_owner = this.form.company_owner.name;
                }).catch(error => {
                console.log('Error: ', error.response)
            })
        },
        submitForm: function () {
            this.loading = true;
            this.saveIdCard()
        },
        saveIdCard: function () {
            // const data = new FormData();
            let myForm = document.getElementById('id-card-form');
            let data = new FormData(myForm);
            data.set('id_card_id', this.form.id);
            // data.set('submit_date', moment(String(this.submit_date)).format('YYYY-MM-DD'));
            axios.post("/api/id_cards/cancel/" + this.$route.params.id, data).then(res => {
                // this.reset();
                // console.log(res.data.id)
                this.success = 'ID Card Cancellation Form Saved Successfully';
                this.$router.push({name: "cancel-id-card-panel-member", query: {success: this.success}});
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.loading = false
            });
        },
        printDoc() {
            window.print();
        },
        doBack(){
            console.log('Click')
            this.$router.go(-1)
        }
    }

}
</script>
<style scoped>
@media print {
    body * {
        visibility: hidden;
    }
    .box12 {
        display: none;
    }
    #printInvoice, #printInvoice * {
        visibility: visible;
        padding: 0;
        font-size: 15px;
    }
    #printInvoice {
        padding-left: 0 !important;
    }
    .form-field{
        padding: 0 !important;
    }
    .font-weight-bold {
        font-weight: normal !important;
    }
    ol {
        margin-left: 15px !important;
    }
    th, td{
        padding: 10px !important;
    }
    th, td{
        border-width: 1px !important;
    }
}
.table{border: 1px solid #59595a;}
.table thead th{border: 1px solid #59595a;}
.table td, .table th {
  padding: .75rem;
  border: 1px solid #59595a;
}

.lower_border {
    width: 49%;
    border: none;
    border-bottom: 1px solid black;
    padding: 5px 10px;
    outline: none;
}

.ref7 {
    margin-top: 5px;
}

.ref7 div {
    padding-top: 3.5px;
}

.ref7 div p {
    display: inline;
}

.ref9 {
    padding-left: 68px;
}

.ref10 {
    padding-left: 40px;
}

.pd-lft {
    padding-left: 0px;
}

@media (min-width: 768px) {
    .pd-lft {
        padding-left: 260px;
    }
}

.signature p {
    margin: 0;
}

.signature .d-flex {
    display: flex;
    justify-content: left;
    padding-right: 145px;
    margin-top: 4px;
}

.signature .d-flex > p:first-child {
    width: 236px;
}

</style>

