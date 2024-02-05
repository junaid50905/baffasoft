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
                    <form class="needs-validation" @submit.prevent="submitForm" role="form" id="id-card-form"
                          novalidate>
                        <div class="container" id="printInvoice">
                            <div class="form-field">


                                <!-- new form  -->
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="check1">Date: {{ created_at }}
<!--                                        <span v-if="$route.params.panel == 'new'">
                                            <input style="width: 120px;" type="date" name="submit_date" v-model="submit_date" id="datee"
                                                   class="form-check-input"/>
                                        </span><span v-else> {{ submit_date }} </span>-->
                                    </label>
                                </div>
                                <p>To<br/>
                                    The Director<br/>
                                    Port & Customs<br/>
                                    Bangladesh Freight Forwarders Association<br/>
                                    Hosue-10 (Level- 2 & 3), House-17A, Block-E<br/>
                                    Banani, Dhaka-1213</p>
                                <div class="form-check-inline">
                                    <label v-if="$route.params.panel == 'new'" class="form-check-label font-weight-bold"
                                           for="check1">
                                        Subject: Request for reissue BAFFA ID card for
                                        <select name="reissue_reason" id="reissue_reason" v-model="reissue_reason">
                                            <option v-for="reason in reissue_reasons" :value="reason">{{ reason }}
                                            </option>
                                        </select>
                                    </label>
                                    <label v-else class="form-check-label font-weight-bold" for="check1">
                                        Subject: Request for reissue BAFFA ID card for
                                        <span>{{ reissue_reason }}</span>
                                    </label>
                                </div>
                                <p class="mt-5">Dear Sir,</p>
                                <div class="form-check-inline">
                                    <label class="form-check-label font-weight-bold" for="check1">
                                        I would request you to re-issue the following BAFFA ID Card(s) due to
                                        <span>{{ reissue_reason }}</span>
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
                                <p>Thanks for all of your continuous cooperation in this respect.</p>
                                <p style="height: 10px;"></p>
                                <p>Sincerely Yours</p>
                                <div class="signature">
                                    <div class="d-flex">
                                        <p>Name</p>
                                        <p>: {{ form.company_owner }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <p>Designation</p>
                                        <p>: {{ form.designation }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <p>Company Name</p>
                                        <p>: {{ form.members.toString() }}</p>
                                    </div>
                                </div>
                                <p style="padding-top: 10px;">Note: </p>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">If lost, please attached General Diary (GD)</li>
                                    <li class="list-group-item">If damaged the ID card, please provide the damaged ID
                                        card to BAFFA Dhaka Office when received the new one.
                                    </li>
                                    <li class="list-group-item" id="attachment_file">
                                        <span v-if="$route.params.panel == 'new'">
                                            <b>Please, Attached General Diary (GD):
                                                <input type="file" name="attachment_file" v-on:change="saveImage">
                                            </b>
                                        </span>
                                        <span v-else>
                                        <span v-if="attachment_file">
                                            <a style="padding-left: 50px" :href="assetPath('/'+attachment_file)"
                                               target="_blank">
                                            See the Attachment
                                            </a>
                                        </span>
                                        <span v-else><b>No Attachment Available.</b></span>

                                        </span>
                                    </li>
                                </ul>
                                <br/><br/>
                                <!-- new form end   -->
                            </div>
                        </div>
                        <div class="box12 mt-5">
                            <div class="d-grid gap-2 col-12 mx-auto">
                                <button v-if="$route.params.panel == 'new'" type="submit"
                                        v-bind:class="[loading ? 'disabled btn-success' : 'btn-success','btn']"
                                        id="loader-btn" style="width:100%;font-size:20px;">
                                    <span>Create Reissue ID Card</span>
                                    <div id="loader" v-if="loading"
                                         v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                                </button>
                                <button v-else type="button" class="btn btn-secondary btn-lg btn-block"
                                        @click="printDoc">Print
                                </button>
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
    name: "ReissueIdCard",
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
        reissue_reasons: ['lost the ID Card', 'damaged the ID Card'],
        reissue_reason: 'lost the ID Card',
        attachment_file: null,
        form: {
            members: [],
        },
        printLoading: false,
        printObj: {
            id: "printInvoice",
            preview: true,
            previewTitle: 'Reissue - Id Card',
            previewPrintBtnLabel: 'Print',
            popTitle: 'Reissue - Id Card',
            beforeOpenCallback(vue) {
                this.printLoading = true
            },
            openCallback(vue) {
                this.printLoading = false
            }
            // closeCallback (vue) {
            //     console.log('closeCallback')
            // }
        }
    }),
    created() {
        if (this.$route.params.panel == 'new')
            this.getGatePass()
        else
            this.getIdCardCancel()
    },
    methods: {
        saveImage: function (event) {
            // console.log(event.target.files[0])
            this.attachment_file = event.target.files[0];
        },
        getIdCardCancel() {
            axios.get('/api/id_cards/reissue/' + this.$route.params.id)
                .then(res => {
                    this.created_at = res.data.data.created_at
                    this.submit_date = res.data.data.submit_date
                    this.attachment_file = res.data.data.attachment_file
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
            });
        },
        submitForm: function () {
            this.saveIdCard()
        },
        saveIdCard: function () {
            this.errors = [];
            if(this.reissue_reason == 'lost the ID Card'){
                if (!this.attachment_file) {
                    this.errors.push(["attachment_file", ["Please, Attached General Diary (GD)"]]);
                }
            }
            if (this.errors.length) {
                this.validationErrors = Object.fromEntries(this.errors)
            } else {
                this.loading = true;
                let myForm = document.getElementById('id-card-form');
                let data = new FormData(myForm);
                data.set('id_card_id', this.form.id);
                data.set('reissue_reason', this.reissue_reason);
                // data.set('submit_date', moment(String(this.submit_date)).format('YYYY-MM-DD'));
                axios.post("/api/id_cards/reissue/" + this.$route.params.id, data).then(res => {
                    // this.reset();
                    // console.log(res.data.id)
                    this.success = 'ID Card Reissue Form Saved Successfully';
                    this.$router.push({name: "reissue-id-card-panel-member", query: {success: this.success}});
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                }).finally(() => {
                    this.loading = false
                });
            }
        },
        printDoc() {
            window.print();
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
    #attachment_file,.card-header {
        display: none;
    }

    #printInvoice, #printInvoice * {
        visibility: visible;
        padding: 0px;
        font-size: 15px;
    }
    #printInvoice {
        padding-left: 0px !important;
    }
    .form-field, .card-body{
        padding: 0px !important;
    }

    .font-weight-bold {
        font-weight: 0px !important;
    }

    ol {
        margin-left: 15px !important;
    }
    th, td{
        padding: 10px !important;
    }
}

.table {
    border: 1px solid #59595a;
}

.table thead th {
    border: 1px solid #59595a;
}

.table td, .table th {
    padding: .75rem;
    border-right: 1px solid #59595a;
}

.lower_border {
    border: none;
    /*border-bottom: 1px solid black;*/
    padding: 5px 10px;
    outline: none;
}

.vs__search {
    width: 100% !important;
    margin: 0px -40px -30px 3px !important;
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


</style>
