<template>
    <div>

        <div class="card">
            <div class="card-body">
                <div id="loader" v-if="loading"
                     v-bind:style="{'backgroundImage': 'url(' + addProjectPath('/assets/img/ajax-loader.gif') + ')'}"></div>
                <b-row>
                    <b-col sm="2" md="2" class="my-1">
                        <b-input-group>
                            <b-form-input
                                v-model="submission_year"
                                name="submission_year"
                                type="number"
                                placeholder="Year"
                            ></b-form-input>
                        </b-input-group>
                    </b-col>
                    <b-col md="4" class="my-1">
                        <v-select
                            placeholder="Select Member Name"
                            v-model="selected_bmn_no"
                            :options="organizations"
                            :reduce="organizations => organizations.username"
                            label="organization_name"></v-select>
                        <!--                            <v-select v-model="selected" @input="setSelected" :options="options" @search="fetchOptions"></v-select>-->
                        <!--                            @input="setSelected"-->
                    </b-col>
                    <b-col md="4" class="my-1">
                        <v-select
                            placeholder="Select Status"
                            v-model="selected_status"
                            :options="all_status"
                            :reduce="all_status => all_status.id"
                            label="name"></v-select>
                    </b-col>
                    <b-col md="2" class="my-1"></b-col>
                </b-row>
                <b-row>
                    <b-col sm="5" md="5" class="my-1">
                        <b-form-input input-class="form-control form-control-sm" name="seconded_by_date" v-model="search_card_holder_name" placeholder="Search Card Holder Name"></b-form-input>
                        <!--                        <datepicker input-class="form-control form-control-sm" name="seconded_by_date"-->
                        <!--                                    v-model="start_date"/>-->
                    </b-col>
                    <b-col sm="5" md="5" class="my-1">
                        <b-form-input input-class="form-control form-control-sm" name="seconded_by_date" v-model="search_id_card_number" placeholder="Search ID Card Number"></b-form-input>
                        <!--                        <datepicker input-class="form-control form-control-sm" name="seconded_by_date"-->
                        <!--                                    v-model="end_date"/>-->
                    </b-col>
                    <b-col sm="2" md="2" class="my-1">
                        <div class="d-grid gap-2">
                            <b-button size="sm" @click="doFilter">Generate Report
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
                <div class="table-responsive" id="users-table-wrapper">
                    <validation-errors :errors="validationErrors" :success="success"
                                       :warning_message="warning_message"></validation-errors>

                    <b-table striped hover small show-empty
                             id="table-transition-example"
                             primary-key="id"
                             :items="members"
                             :fields="fields"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :tbody-transition-props="transProps"
                             :busy.sync="isBusy"
                    >
                        <template #cell(card_holder_photograph_attachment)="row">
                            <a v-if="row.value" :href="assetPath('/'+row.value)" target="_blank">
                                <img :src="assetPath('/'+row.value)" alt="" width="50" height="50">
                            </a>
                            <i v-else class="fas fa-user-alt" style="font-size:25px;padding:5px;"></i>


                            <!--                            <router-link :to="{name: 'view-id-card',params: { id: row.item.id }}" class="btn btn-link">-->
                            <!--                                {{ row.value }}-->
                            <!--                            </router-link>-->
                        </template>
                        <template #cell(organizations)="row">
                            <ul>
                                <li v-for="organization_name in row.value">
                                    {{ organization_name }}
                                </li>
                            </ul>
                        </template>
                        <template #cell(police_verification)="row">
                            <span v-if="row.item.police_verification_attachment">
                                <a :href="assetPath('/'+row.item.police_verification_attachment)" target="_blank">
                                {{ row.value }}
                                </a>
                            </span>
                            <span v-else>{{ row.value }}</span>
                        </template>
                        <template #cell(card_holder_name)="row">
                            <router-link
                                :to="{name: 'view-id-card',params: { id: row.item.id }}"
                                class="btn btn-link btn-sm text-black-50">{{ row.value }}
                            </router-link>
                        </template>
                        <template #cell(attachment_name)="row">
                            <span v-if="row.item.attachment_file">
                                <a :href="assetPath('/'+row.item.attachment_file)" target="_blank">
                                {{ row.value }} No:<br>{{ row.item.attachment_number }}
                                </a>
                            </span>
                            <span v-else>{{ row.value }} No:<br>{{ row.item.attachment_number }}</span>
                        </template>
                        <template #cell(status)="row">
                            <span class="badge bg-secondary"><strong>{{ row.value }}</strong></span>
                            <!--                            <div class="alert alert-dark"><strong>{{row.value}}</strong></div>-->
                        </template>
                        <template #cell(actions)="row">
                            <div class="dropdown"
                                 v-if="row.item.status === 'Pending' ? true : false"
                            >
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Comment
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <b-button
                                            v-b-modal.modal-member-approval
                                            @click="sendInfo(row.item.id)"
                                            class="dropdown-item">New Comment
                                        </b-button></li>
                                    <li>
                                        <b-button
                                            @click="deleteCommentIdCard(row.item.id)" class="dropdown-item">
                                            Delete Comment
                                        </b-button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <b-button
                                            @click="verifiedIdCard(row.item.id)" class="dropdown-item">
                                            Verify Card
                                        </b-button>
                                    </li>
                                    <li v-if="role == 1">
                                        <b-button
                                            @click="deleteIdCard(row.item.id)" class="dropdown-item" style="color: red;">
                                            Delete Card
                                        </b-button>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group" v-if="row.item.status_code >= 7 ? true : false">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                    Paid Action
                                </button>
                                <div class="dropdown-menu">
                                    <b-button v-b-modal.modal-id-card-numbering v-if="!row.item.id_card_number"
                                              @click="generateIdCardNumber(row.item.id)" class="btn btn-light btn-sm">
                                        Numbering ID Card
                                    </b-button>
                                    <b-button v-b-modal.modal-id-card-proximity v-if="!row.item.proximity_number"
                                              @click="sendInfo(row.item.id)" class="btn btn-light btn-sm">
                                        Input Proximity Number
                                    </b-button>
                                    <b-button v-b-modal.modal-delivered
                                              @click="sendInfo(row.item.id)" class="btn btn-light btn-sm">
                                        Delivery Date
                                    </b-button>
<!--                                    <a class="btn btn-light btn-sm" target="_blank" v-if="!row.item.delivery_date"-->
<!--                                       :href="addProjectPath('/print_membership_id_card/'+ row.item.id)">Card</a>-->

                                    <!--                                        <router-link-->
                                    <!--                                            :to="{name: 'view-id-card',params: { id: row.item.id }}" target="_blank"-->
                                    <!--                                            class="btn btn-light btn-sm" >View</router-link>-->
                                </div>
                            </div>
<!--                            <div class="btn-group" v-if="row.item.status_code > 0 ? true : false">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                    Cancel/ Reissue
                                </button>
                                <div class="dropdown-menu">
                                    <router-link v-if="row.item.id_card_cancel == null"
                                    :to="{name: 'cancel-id-card-form',params: { id: row.item.id, panel: 'new' }}"
                                    class="btn btn-light btn-sm" >Cancel</router-link>
                                    <router-link
                                    :to="{name: 'reissue-id-card-form',params: { id: row.item.id, panel: 'new' }}"
                                    class="btn btn-light btn-sm" >ReIssue</router-link>
</div>
                            </div>-->
                            <div class="btn-group" v-if="row.item.status_code >= 6 ? true : false">
                                <button type="button" class="btn btn-info btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                    Print
                                </button>
                                <div class="dropdown-menu">
                                    <a class="btn btn-light btn-sm" target="_blank"
                                       :href="addProjectPath('/print_id_card/'+ row.item.id)">Form</a>
                                    <a class="btn btn-light btn-sm" target="_blank"
                                       :href="addProjectPath('/print_membership_id_card/'+ row.item.id)">Card</a>
                                </div>
                            </div>
                        </template>
                    </b-table>
                </div>
                <b-modal
                    id="modal-member-approval"
                    ref="modal"
                    title="Comment For Member"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleCommentOK"
                >
                    <form ref="form" @submit.stop.prevent="updateComment">
                        <b-form-group
                            label="Comment"
                            label-for="name-input"
                            invalid-feedback="Comment is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="comment"
                                :state="nameState"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
                <b-modal
                    id="modal-id-card-numbering"
                    ref="modal"
                    title="Numbering ID Card"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleIdCardNumberOK"
                >
                    <form ref="form" @submit.stop.prevent="updateIdCardNumber">
                        <b-form-group
                            label="ID Card Number"
                            label-for="name-input"
                            invalid-feedback="Number is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="id_card_number"
                                :state="nameState"
                                disabled
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
                <b-modal
                    id="modal-id-card-proximity"
                    ref="modal"
                    title="Input Proximity Number"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleProximityNumberOk"
                >
                    <form ref="form" @submit.stop.prevent="updateProximityNumber">
                        <b-form-group
                            label="Input Proximity Number"
                            label-for="name-input"
                            invalid-feedback="Number is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="name-input"
                                v-model="proximity_number"
                                :state="nameState"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
                <b-modal
                    id="modal-delivered"
                    ref="modal"
                    title="Delivered"
                    @show="resetModal"
                    @hidden="resetModal"
                    @ok="handleDeliveryDateOk"
                >
                    <form ref="form" @submit.stop.prevent="updateDeliveryDate">
                        <b-form-group
                            label="Input Delivery Date"
                            label-for="date-input"
                            invalid-feedback="Date is required"
                            :state="nameState"
                        >
                            <b-form-input
                                id="date-input"
                                type="date"
                                v-model="delivery_date"
                                :state="nameState"
                                required
                            ></b-form-input>
                        </b-form-group>
                    </form>
                </b-modal>
            </div>
        </div>
    </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import vSelect from "vue-select";

export default {
    name: "AllIdCards",
    components: {ValidationErrors,vSelect},
    props: { role: Number, username: String },
    data: () => ({
        search_card_holder_name: null,
        search_id_card_number: null,
        request_url: null,
        selected_status: null,
        submission_year: null,
        selected_bmn_no: null,
        loading: false,
        idCardID: null,
        members: [],
        organizations: [],
        all_status: [],
        errors: [],
        validationErrors: null,
        success: '',
        warning_message:'',
        approval_image: null,
        comment: null,
        id_card_number: null,
        proximity_number: null,
        delivery_date: new Date().toISOString().slice(0, 10),
        nameState: null,
        selected: [],
        isBusy: false,
        totalRows: 1,
        currentPage: 1,
        perPage: 10,
        pageOptions: [10, 15, {value: 100, text: "Show a lot"}],
        transProps: {
            // Transition name
            name: 'flip-list'
        },
        fields: [
            {
                key: 'card_holder_photograph_attachment',
                label: 'Photo',
            },
            {
                key: 'card_holder_name',
                label: 'Name',
            },
            {
                key: 'card_holder_designation',
                label: 'Designation'
            }, 'organizations',{key:'card_type',label:'Type'},{key:'form_year',label:'Year'},{key:'id_card_number',label:'Number'}
            ,{key:'proximity_number',label:'Proximity'}, 'comment', 'status', 'actions'],
        options: [
            {value: 'login', text: 'Login Access', disabled: true},
            {value: '1', text: 'Gate Pass'},
            {value: '2', text: 'ID Card'}
        ]
    }),
    watch: {
        file1() {
            this.nameState = !!this.file1; // if File, then return false
        }
    },
    created() {
        this.getMembers()
        this.getOrganizations()
        this.getStatus()
    },
    methods: {
        doFilter() {
            this.request_url = '/api/id_cards?' +
                'search_panel=id_card_department' +
                "&submission_year=" + this.submission_year +
                '&search_card_holder_name=' + this.search_card_holder_name +
                '&search_id_card_number=' + this.search_id_card_number +
                '&status=' + this.selected_status +
                // '&user_name=' + this.selected_user.username +
                '&bmn_no=' + this.selected_bmn_no;
            this.loading = true
            axios.get(this.request_url)
                .then(res => {
                    this.members = res.data.data
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        },
        sendInfo(id) {
            this.idCardID = id
            console.log('ID Card ID: ', id)
            // this.selectedUser = item;
        },
        verifiedIdCard(id) {
            if (confirm("Confirm Verification ?")) {
                axios.put("/api/id_cards/verification/" + id).then(res => {
                    // console.log(res.data)
                    this.getMembers();
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
        deleteIdCard(id) {
            if (confirm("Confirm Delete ?")) {
                axios.delete("/api/id_cards/" + id).then(res => {
                    // console.log(res.data)
                    this.getMembers();
                    // this.$router.push({ name: "registration", query: { success: this.success } });
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                        this.message = error.response.data.message;
                    }
                });
            }
            // console.log('ID Card ID', id)
        },
        deleteCommentIdCard(id) {
            if (confirm("Remove Comment Permanently ?")) {
                axios.delete("/api/id_cards/comment/" + id).then(res => {
                    this.getMembers();
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.validationErrors = error.response.data.errors;
                    } else {
                       this.warning_message = error.response.data.message;
                    }
                });
            }
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity()
            this.nameState = valid
            return valid
        },
        generateIdCardNumber(id) {
            this.sendInfo(id);
            this.loading = true
            axios
                .get('/api/generate_id_card_number/' + id)
                .then(res => {
                    this.id_card_number = res.data
                }).catch(error => {
                console.error(error.response)
            }).finally(() => {
                this.loading = false
            });
            // this.sendInfo(id)
            // console.log('ID Card form_year: ', form_year)
            // this.id_card_number = form_year.toString().slice(-2) + id.toString()
        },
        resetModal() {
            this.file1 = null
            this.nameState = null
            this.id_card_number = null
            this.proximity_number = null
            this.selected = []
        },
        resetPrivilegeModal() {
            const mem = this.members.find(member => member.id === this.idCardID)
            if (mem.privileges) {
                const pri = mem.privileges.map(x => x.id)
                this.selected = pri
            }
            // console.log(mem)
        },
        handleCommentOK(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.updateComment()
        },
        updateComment() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return
            }
            let formData = new FormData();
            formData.set('comment', this.comment);
            // let imageFile = document.querySelector('#name-file');
            // formData.append("approval_image", imageFile.files[0]);
            axios.put("/api/id_cards/comment/" + this.idCardID, {'comment': this.comment}).then(res => {
                console.log(res.data)
                this.reset();
                this.getMembers();
                // this.$router.push({ name: "registration", query: { success: this.success } });
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-member-approval')
                })
            });
        },
        handleIdCardNumberOK(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.updateIdCardNumber()
        },
        updateIdCardNumber() {
            if (!this.checkFormValidity()) {
                return
            }
            axios.put("/api/id_cards/update_id_card_number/" + this.idCardID, {'id_card_number': this.id_card_number}
            ).then(res => {
                this.getMembers()
                this.success = 'Update ID Card Numbering Successfully';
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-id-card-numbering')
                })
            });

        },
        handleProximityNumberOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.updateProximityNumber()
        },
        updateProximityNumber() {
            if (!this.checkFormValidity()) {
                return
            }
            axios.put("/api/id_cards/update_proximity_number/" + this.idCardID, {'proximity_number': this.proximity_number}
            ).then(res => {
                this.getMembers()
                this.success = 'ID Card Proximity Updated Successfully';
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-id-card-proximity')
                })
            });

        },
        handleDeliveryDateOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault()
            // Trigger submit handler
            this.updateDeliveryDate()
        },
        updateDeliveryDate() {
            if (!this.checkFormValidity()) {
                return
            }
            // data.set('dob', moment(String(this.form.dob)).format('YYYY-MM-DD'));
            axios.put("/api/id_cards/update_delivered/" + this.idCardID, {'delivery_date': this.delivery_date}
            ).then(res => {
                this.getMembers()
                this.success = 'Delivery Date Updated Successfully';
            }).catch(error => {
                if (error.response.status == 422) {
                    this.validationErrors = error.response.data.errors;
                } else {
                   this.warning_message = error.response.data.message;
                }
            }).finally(() => {
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-delivered')
                })
            });

        },
        getMembers() {
            this.loading = true
            axios
                .get('/api/id_cards')
                .then(res => {
                    this.members = res.data.data
                    this.totalRows = this.members.length
                }).catch(error => {
                console.error(error.response.data.message)
            }).finally(() => {
                this.loading = false
            });
        },
        deleteMember(id) {
            if (confirm("Do you really want to delete Member?")) {
                axios
                    .delete('/api/members/' + id)
                    .then(res => {
                        // this.showMessage = true;
                        this.success = res.data;
                        this.getMembers();
                    }).catch(error => {
                    console.error(error.response.data.message)
                })
            }
        },
        reset: function () {
            this.comment = null;
            this.validationErrors = null;
            this.success = 'Member Validation Successfully';
            // this.form = Object.assign({}, initFormData)
            // for(let field in this.formData){
            //     this.formData[field] = null;
            // }
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
        getStatus() {
            axios
                .get('/api/all_id_card_status')
                .then(res => {
                    this.all_status = res.data
                }).catch(error => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>
.table-responsive {
    min-height: 400px;
}
table#table-transition-example .flip-list-move {
    transition: transform 1s;
}

.card-body { /* Components Root Element ID */
    position: relative;
}

.card-body #loader {
    /* Loader Div Class */
    position: absolute;
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
