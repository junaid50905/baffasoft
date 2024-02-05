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
        <b-row>
          <b-col lg="8" class="my-1">
            <b-form-group
              label="Filter"
              label-for="filter-input"
              label-cols-sm="3"
              label-align-sm="right"
              label-size="sm"
              class="mb-0"
            >
              <b-input-group size="sm">
                <b-form-input
                  id="filter-input"
                  v-model="filter"
                  type="search"
                  placeholder="Company Name or BMN"
                  list="my-list-id"
                ></b-form-input>
                <datalist id="my-list-id">
                  <option v-for="size in organizations">
                    {{ size.organization_name }}
                  </option>
                </datalist>

                <b-input-group-append>
                  <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                </b-input-group-append>
                  <b-input-group-append>
<!--                      <b-form-group class="mb-0">
                          <b-input-group size="sm">-->
                      <b-form-input
                          id="filter-input"
                          v-model="filter"
                          type="search"
                          placeholder="Status"
                          list="status-list-id"
                          size="sm"
                      ></b-form-input>
                      <datalist id="status-list-id">
                          <option value=''>Select Status</option>
                          <option value="Pending">Pending</option>
                          <option value="Verified">Verified</option>
                          <option value="Paid">Paid</option>
                          <option value="Inspected">Inspected</option>
                          <option value="Wait For Approval">Wait For Approval</option>
                          <option value="Admin Approval">Admin Approval</option>
                          <option value="Unconfirmed">Unconfirmed</option>
                          <option value="Active">Active</option>
                          <option value="Banned">Banned</option>
                      </datalist>

<!--                          </b-input-group>
                      </b-form-group>-->
                    </b-input-group-append>
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col sm="4" md="4" class="my-1">
            <json-excel
              class="btn btn-sm btn-outline-success"
              :header="header"
              :data="members"
              :fields="json_fields"
              :before-generate="beforeExcelGenerate"
              :before-finish="() => (loading = false)"
              worksheet="BAFFA Worksheet"
              name="Members.xls"
            >
              Download Data as Excel
              <i class="fas fa-file-excel text-success" />
              <!--                                <img :src="addProjectPath('/images/download-excel.png')"  />-->
            </json-excel>
          </b-col>
        </b-row>

          <b-row>
              <b-col sm="12" md="12" class="my-1">
                  <b-form-group
                      label="Filter On"
                      description="Leave all unchecked to filter on all data"
                      label-cols-sm="3"
                      label-align-sm="right"
                      label-size="sm"
                      class="mb-0"
                      v-slot="{ ariaDescribedby }"
                  >
                      <b-form-checkbox-group
                          v-model="filterOn"
                          :aria-describedby="ariaDescribedby"
                          class="mt-1"
                      >
                          <b-form-checkbox value="username">BMN</b-form-checkbox>
                          <b-form-checkbox value="organization_name">Company</b-form-checkbox>
                          <b-form-checkbox value="status">Status</b-form-checkbox>
                      </b-form-checkbox-group>
                  </b-form-group>
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
        <br />
        <div class="table-responsive" id="users-table-wrapper">
          <validation-errors
            :errors="validationErrors"
            :success="success"
            :warning_message="warning_message"
          ></validation-errors>

          <b-table
            striped
            hover
            small
            show-empty
            id="table-transition-example"
            primary-key="id"
            :filter="filter"
            :filter-included-fields="filterOn"
            :items="members"
            :fields="fields"
            :current-page="currentPage"
            :per-page="perPage"
            :tbody-transition-props="transProps"
            :busy.sync="isBusy"
          >
            <template #cell(username)="row">
              <router-link
                :to="{ name: 'view-member', params: { id: row.item.id } }"
                class="btn btn-link"
              >
                {{ row.value }}
              </router-link>
              <span v-if="checkAccess('edit_member')">
                <b-button
                  v-b-modal.modal-member-approval
                  @click="sendActiveMemberInfo(row.item.id)"
                  variant="icon"
                  title="Modify Member Approval"
                  data-toggle="tooltip"
                  data-placement="top"
                  ><i class="fas fa-user-check text-info"></i>
                </b-button>
              </span>
              <!--                            <a :href="addProjectPath('/profile/member/'+row.item.id)">-->
              <!--                                {{ row.value }}-->
              <!--                            </a>-->
            </template>
            <template #cell(gatepass_balance)="row">
              <span>{{ row.value }}</span>
              <span v-if="row.item.status == 'Active'">
                <router-link
                  :to="{ name: 'member-collection-summary', params: { id: row.item.id } }"
                  class="btn btn-sm btn-light"
                  title="GatePass"
                  data-toggle="tooltip"
                  data-placement="top"
                  >Check
                </router-link>
              </span>
            </template>
            <template #cell(privileges)="row">
              <span
                v-for="val in row.value.map((x) => x.description)"
                class="badge badge-secondary"
                >{{ val }}</span
              >
              <span v-if="row.item.status == 'Active'">
                <b-button
                  size="sm"
                  v-b-modal.modal-member-privilege
                  @click="sendInfo(row.item.id)"
                  variant="icon"
                  title="Member Privilege"
                  data-toggle="tooltip"
                  data-placement="top"
                  >Edit
                </b-button>
              </span>
            </template>
            <template #cell(status)="row">
              <span
                v-bind:class="[
                  row.value === 'Active'
                    ? 'badge-success'
                    : row.value === 'Banned'
                    ? 'badge-danger'
                    : 'badge-warning',
                  'badge badge-lg',
                ]"
              >
                {{ row.value }}
              </span>
            </template>
            <template #cell(actions)="row">
              <router-link
                :to="{ name: 'company_owners', params: { id: row.item.id } }"
                class="btn btn-icon edit"
                title="Add Owners"
                data-toggle="tooltip"
                data-placement="top"
                ><i class="fas fa-user-plus"></i>
              </router-link>
              <span v-if="checkAccess('edit_member')"
                ><router-link
                  v-if="row.item.status == 'Pending'"
                  :to="{
                    name: 'edit-member',
                    params: { id: row.item.id },
                    query: { only_edit: 'No' },
                  }"
                  class="btn btn-icon edit"
                  title="Edit Member"
                  data-toggle="tooltip"
                  data-placement="top"
                  ><i class="fas fa-edit"></i> </router-link
              ></span>
              <span v-if="checkAccess('inspection_member')"
                ><b-button
                  v-if="row.item.status == 'Verified' || row.item.status == 'Inspected'"
                  v-b-modal.modal-member-approval
                  @click="sendInfo(row.item.id)"
                  variant="icon"
                  title="Member Approval"
                  data-toggle="tooltip"
                  data-placement="top"
                  ><i class="fas fa-user-check text-success"></i> </b-button
              ></span>
              <span v-if="checkAccess('approve_member')">
                <button
                  v-if="row.item.status == 'Wait For Approval'"
                  class="btn btn-success btn-sm"
                  @click="approveMember(row.item.id)"
                >
                  Approved
                </button>
              </span>
              <span v-if="checkAccess('payment_member')">
                <span v-if="row.item.status == 'Admin Approval'">
                  <router-link
                    v-if="!row.item.is_payment"
                    :to="{
                      name: 'new-collection',
                      params: { member_id: row.item.id },
                      query: {
                        props_id: row.item.member_detail.id,
                        props_receipt_type: 'new_membership',
                        props_receipt_year: row.item.member_detail.board_of_directors_meeting_year,
                      },
                    }"
                    class="btn btn-success btn-sm"
                    >Payment</router-link
                  >
                </span>
              </span>
              <span v-if="checkAccess('active_member')">
                <button
                  v-if="row.item.status == 'Paid' || row.item.status == 'Banned'"
                  class="btn btn-success btn-sm"
                  @click="activeMember(row.item.id)"
                >
                  Active
                </button>
              </span>
              <span v-if="row.item.status == 'Active'">
<!--                <router-link
                  :to="{ name: 'renew-member', params: { id: row.item.id } }"
                  class="btn btn-icon edit"
                  title="Renew Member"
                  data-toggle="tooltip"
                  data-placement="top"
                  ><i class="fas fa-user-plus"></i>
                </router-link>-->
                <span v-if="checkAccess('inactive_member')"
                  ><button class="btn btn-icon" @click="inactiveMember(row.item.id)">
                    <i class="fas fa-toggle-on"></i></button
                ></span>
              </span>
                <span v-if="row.item.status == 'Pending' || row.item.status == 'Inspected' ">
                <span v-if="checkAccess('inactive_member')"
                ><button class="btn btn-icon" @click="deleteMember(row.item.id)">
                    <i class="fas fa-trash"></i></button
                ></span></span>

              <!--                            <span v-if="role == 1 || username == 'tulshidas.baffa' || username == 'kamrul.baffa'">-->
              <!--                            <span v-if="checkAccess('inspection_member')">
                                                            <router-link v-if="row.item.status == 'Inspected'"
                                                                         :to="{name: 'member_inspection',params: { id: row.item.id }}"
                                                                         class="btn btn-success btn-sm">Inspection</router-link>
                                                        </span>-->

              <!--                            <a href=""-->
              <!--                               class="btn btn-icon edit"-->
              <!--                               title="Edit User"-->
              <!--                               data-toggle="tooltip" data-placement="top">-->
              <!--                                <i class="fas fa-edit"></i>-->
              <!--                            </a>-->
              <!--                            <button class="btn btn-icon" @click="deleteMember(row.item.id)"><i-->
              <!--                                class="fas fa-trash text-danger"></i></button>-->
            </template>
          </b-table>
        </div>
      </div>
    </div>
      <MemberInspection
          :hideField=true
          :memberId="memberId"
          :send_to_admin="send_to_admin"
          @reset="reset" @getMembers="getMembers" />
<!--    <b-modal
      id="modal-member-approval"
      ref="modal"
      title="Submit Member Inspection Copy"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      hide-footer
    >
      <form
        ref="form"
        @submit.stop.prevent="handleSubmit"
        role="form"
        id="inspection-form"
        autocomplete="off"
        enctype="multipart/form-data"
      >
        <b-form-group label="Inspection Paper" label-for="name-file">
          <b-form-file
            v-model="formData.attach_inspection_report"
            id="name-file"
            name="attach_inspection_report"
            placeholder="Choose a file or drop it here..."
            drop-placeholder="Drop file here..."
          ></b-form-file>
        </b-form-group>
        <div class="form-group">
          <label for="attach_checklist">Attach Checklist:</label>
          <ImageTag
            alt="attach_checklist"
            name="attach_checklist"
            :src="formData.attach_checklist"
            @saveImage="saveImage"
          />
        </div>
        <div class="form-group">
          <label for="sub_committee_meeting_date">Sub Committee Meeting Date</label>
          <b-form-datepicker
            id="sub_committee_meeting_date"
            name="sub_committee_meeting_date"
            v-model="formData.sub_committee_meeting_date"
            class="mb-2"
          ></b-form-datepicker>
        </div>
        <b-form-group label="Board of Director Meeting No." label-for="name-input">
          <b-form-input
            id="name-input"
            type="number"
            name="board_of_directors_meeting_no"
            v-model="formData.board_of_directors_meeting_no"
          ></b-form-input>
        </b-form-group>
        <div class="form-group">
          <label for="board_of_directors_meeting_date"
            >Board Of Directors Meeting Date</label
          >
          <b-form-datepicker
            id="board_of_directors_meeting_date"
            name="board_of_directors_meeting_date"
            v-model="formData.board_of_directors_meeting_date"
            class="mb-2"
          ></b-form-datepicker>
        </div>
        &lt;!&ndash;                <div class="mt-3">Selected file: {{ formData.attach_inspection_report ? formData.attach_inspection_report.name : '' }}</div>&ndash;&gt;
      </form>
      <b-button class="mt-3" variant="outline-success" block @click="handleOk"
        >Update</b-button
      >
      <b-button
        v-if="send_to_admin"
        class="mt-2"
        variant="outline-secondary"
        block
        @click="handleOkSubmit"
        >Send to Admin</b-button
      >
    </b-modal>-->
    <b-modal
      id="modal-member-privilege"
      ref="modal"
      title="Submit Member Privilege"
      @show="resetPrivilegeModal"
      @hidden="resetModal"
      @ok="updatePrivilege"
    >
      <form
        ref="form"
        @submit.stop.prevent="updatePrivilege"
        role="form"
        id="privilege"
        autocomplete="off"
        enctype="multipart/form-data"
      >
        <b-form-group
          label="File"
          label-for="name-file"
          invalid-feedback="File is required"
        >
          <b-form-select
            v-model="selected"
            :options="options"
            multiple
            :select-size="4"
          ></b-form-select>
        </b-form-group>
        <div class="mt-3">
          Selected: <strong>{{ selected }}</strong>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import ImageTag from "../ImageTag";
import moment from "moment/moment";
import JsonExcel from "vue-json-excel";
import MemberInspection from "./../MemberInspection.vue";

export default {
  name: "Members",
  components: {MemberInspection, ValidationErrors, ImageTag, JsonExcel },
  data: () => ({
    header: [""],
    loading: false,
    memberId: null,
    members: [],
    errors: [],
    validationErrors: null,
    success: "",
    warning_message: "",
    send_to_admin: null,
   formData: {
      send_to_admin: false,
/*      attach_inspection_report: null,
      attach_checklist: null,
      sub_committee_meeting_date: null,
      board_of_directors_meeting_no: null,
      board_of_directors_meeting_date: null,*/
    },
    nameState: null,
    selected: [],
    filter: null,
    filterOn: [],
    set_selected: null,
    organizations: [],
    isBusy: false,
    totalRows: 1,
    currentPage: 1,
    perPage: 15,
    pageOptions: [15, { value: 100, text: "Show a lot" }],
    transProps: {
      // Transition name
      name: "flip-list",
    },
    fields: [
      { key: "username", label: "BMN", sortable: true },
      { key: "organization_name", label: "Company", variant: "danger" , thStyle: { 'width': '20%' }},
      {
        key: "member_detail.board_of_directors_meeting_date",
        label: "Admission Date",
      },
      "status",
      "gatepass_balance",
      "privileges",
      "actions",
    ],
    json_fields: {
      Date: "member_detail.form_submit_date",
      Name: "organization_name",
      BMN: {
        field: "username",
        callback: (value) => {
          return "'" + value.toString();
        },
      },
      Enlistment: "member_detail.place_of_enlistment",
      Type: "member_detail.firm_type",
      "LC/JV/FRG": "member_detail.type_local",
      "Reg./Inco. No.": "member_detail.particulars_of_certificate_number",
      "Reg./Inco. Date": "member_detail.particulars_of_certificate_date",
      Establishment: "member_detail.date_of_establishment",
      "TL No.": "member_detail.trade_license_number",
      "TL Validity": "member_detail.trade_license_date",
      TIN: "member_detail.tin_number",
      VAT: "member_detail.vat_registration_number",
      FFL: "member_detail.ff_license_no",
      Bank: "member_detail.name_of_banker",
      "Bank Address": "member_detail.address_of_banker",
      "Other Trade org.": "member_detail.membership_of_other_trade_organization",
      "Auth. Person": "member_detail.name_of_authorized_person",
      "Applicant Name": "signatory.name",
      Designation: "signatory.designation",
      NID: "signatory.nid_no",
      "Mobile No.": "signatory.mobile_no",
      Email: "signatory.email",
      Voter: "voter_name",
      Staffs: "member_detail.no_of_appointed_staff",
      "Office Address": "head_office.address",
      Telephone: "head_office.telephone_no",
      "Head Office Mobile No.": "head_office.mobile_no",
      "Head Office E-mail": "head_office.email_address",
      "Sub-committee": "member_detail.sub_committee_meeting_date",
      "BOD Meeting": "member_detail.board_of_directors_meeting_no",
      "Meeting Date": "member_detail.board_of_directors_meeting_date",
    },
    options: [
      { value: "login", text: "Login Access", disabled: true },
      { value: "1", text: "Gate Pass" },
      { value: "2", text: "ID Card" },
    ],
  }),
  created() {
    this.getMembers();
    this.getOrganizations();
  },
  methods: {
    beforeExcelGenerate() {
      this.loading = true;
    },
    saveImage: function (event) {
      this.formData[event.target.name] = event.target.files[0];
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
    sendActiveMemberInfo(id) {
      this.send_to_admin = false;
      this.memberId = id;
      console.log("Member ID", id);
    },
    sendInfo(id) {
      this.send_to_admin = true;
      this.memberId = id;
      console.log("Member ID", id);
    },
    checkFormValidity() {
      const valid = this.$refs.form.checkValidity();
      this.nameState = valid;
      return valid;
    },
    resetModal() {
      this.nameState = null;
      this.selected = [];
    },
    resetPrivilegeModal() {
      const mem = this.members.find((member) => member.id === this.memberId);
      if (mem.privileges) {
        const pri = mem.privileges.map((x) => x.id);
        this.selected = pri;
      }
    },
    /*handleOk(bvModalEvt) {
      bvModalEvt.preventDefault();
      this.handleSubmit();
    },
    handleOkSubmit(bvModalEvt) {
      this.formData["send_to_admin"] = true;
      bvModalEvt.preventDefault();
      this.handleSubmit();
    },
    handleSubmit() {
      if (!this.checkFormValidity()) {
        return;
      }
      this.updateMember();
    },*/
    updatePrivilege() {
      if (!this.checkFormValidity()) {
        return;
      }
      if (!this.selected.length) return;
      axios
        .post("/api/members/assign_privilege/" + this.memberId, {
          privileges: this.selected,
        })
        .then((res) => {
          this.getMembers();
          this.success = "Update Privileges Successfully";
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.validationErrors = error.response.data.errors;
          } else {
            this.warning_message = error.response.data.message;
          }
        })
        .finally(() => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-member-privilege");
          });
        });
    },
    /*updateMember() {
      let myForm = document.getElementById("inspection-form");
      let data = new FormData(myForm);
      if (this.formData.send_to_admin) data.set("status", "Wait For Approval");
      if (this.formData.sub_committee_meeting_date)
        data.set(
          "sub_committee_meeting_date",
          moment(String(this.formData.sub_committee_meeting_date)).format("YYYY-MM-DD")
        );
      if (this.formData.board_of_directors_meeting_date)
        data.set(
          "board_of_directors_meeting_date",
          moment(String(this.formData.board_of_directors_meeting_date)).format(
            "YYYY-MM-DD"
          )
        );

      // let formData = new FormData();
      // let imageFile = document.querySelector('#attach_inspection_report');
      // formData.append("attach_inspection_report", imageFile.files[0]);
      axios
        .post("/api/members/approval/" + this.memberId, data, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          // console.log(res.data)
          this.reset();
          this.getMembers();
          // this.$router.push({ name: "registration", query: { success: this.success } });
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.validationErrors = error.response.data.errors;
          } else {
            this.warning_message = error.response.data.message;
          }
        })
        .finally(() => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-member-approval");
          });
        });
    },*/
    getMembers() {
      this.loading = true;
      axios
        .get("/api/members")
        .then((res) => {
          this.members = res.data.data;
          this.totalRows = this.members.length;
        })
        .catch((error) => {
          console.error(error.response);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    approveMember(id) {
      if (confirm("Do you really want to Approve Member?")) {
        axios
          .get("/api/members/approveMember/" + id)
          .then((res) => {
            // this.showMessage = true;
            this.success = res.data;
            this.getMembers();
          })
          .catch((error) => {
            console.error(error.response.data.message);
          });
      }
    },
      inactiveMember(id) {
      if (confirm("Banned Member?")) {
        axios
          .get("/api/members/bannedMember/" + id)
          .then((res) => {
            // this.showMessage = true;
            this.success = res.data;
            this.getMembers();
          })
          .catch((error) => {
            console.error(error.response.data.message);
          });
      }
    },    deleteMember(id) {
      if (confirm("Delete Member?")) {
      if (confirm("All information will permanently deleted. So, Are you Sure?")) {
        axios
          .delete("/api/members/" + id)
          .then((res) => {
            // this.showMessage = true;
            this.success = res.data;
            this.getMembers();
          })
          .catch((error) => {
            console.error(error.response.data.message);
          });
        }
      }
    },
    activeMember(id) {
      if (confirm("Active Member?")) {
        axios
          .get("/api/members/activeMember/" + id)
          .then((res) => {
            // this.showMessage = true;
            this.success = res.data;
            this.getMembers();
          })
          .catch((error) => {
            console.error(error.response.data.message);
          });
      }
    },
    reset: function () {
      this.formData.send_to_admin = false;
      this.validationErrors = null;
      this.success = "Member Validation Successfully";
      // this.form = Object.assign({}, initFormData)
      // for(let field in this.formData){
      //     this.formData[field] = null;
      // }
    },
  },
};
</script>

<style scoped>
table#table-transition-example .flip-list-move {
  transition: transform 1s;
}

.card-body {
  /* Components Root Element ID */
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
