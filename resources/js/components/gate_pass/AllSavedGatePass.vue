<template>
  <div>
    <div class="card">
      <div class="card-header bg-danger text-center">
          <h3>Only Saved List</h3>
      </div>
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
            <b-col sm="5" md="6" class="my-1">
              <b-input-group>
                <b-form-input
                  v-model="filter"
                  name="filter"
                  list="my-list-id"
                  type="search"
                  placeholder="MAWB NO ..."
                ></b-form-input>
                <datalist id="my-list-id">
                  <option v-for="size in storedSearches">{{ size }}</option>
                </datalist>
                <b-input-group-append>
                  <b-button :disabled="!filter" @click="doFilter">Search</b-button>
                </b-input-group-append>
              </b-input-group>
            </b-col>
            <b-col sm="5" md="6" class="my-1">
              <v-select
                v-model="selected_bmn_no"
                :options="organizations"
                :reduce="(organizations) => organizations.username"
                label="organization_name"
              ></v-select>
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
                <b-button size="sm" :disabled="!end_date" @click="doFilterByDate"
                  >Generate Report
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
          <br />
          <b-table
            striped
            hover
            small
            show-empty
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
                v-bind:class="[
                  row.value === 'Active' ? 'badge-success' : 'badge-warning',
                  'badge badge-lg',
                ]"
              >
                {{ row.value }}
              </span>
            </template>
            <template #cell(payments)="row">
              <span v-if="row.value">
                <button
                  v-for="(val, bmn) in row.value"
                  type="button"
                  class="btn btn-secondary btn-sm"
                >
                  {{ bmn }}
                  <span v-for="{ amount } in val" class="badge badge-light">{{
                    amount
                  }}</span>
                </button>
              </span>
            </template>
            <template #cell(actions)="row">
                  <button
                    v-if="user.role_id == 1"
                    class="btn btn-icon"
                    @click="deleteMember(row.item.id)"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Delete"
                  >
                    <i class="fas fa-trash text-danger"></i>
                  </button>
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
import GatePassPaymentModal from "./GatePassPaymentModal";
import Datepicker from "vuejs-datepicker";

export default {
  name: "AllGatePass",
  components: { GatePassPaymentModal, ValidationErrors, JsonExcel, vSelect, Datepicker },
  props: ["warning_message", "success"],
  data: () => ({
    header: ["CARGO ENTRY GATE PASS REPORT"],
    start_date: new Date().toISOString().slice(0, 10),
    end_date: new Date().toISOString().slice(0, 10),
    organizations: [],
    openingBalance: 0.0,
    gatePassId: null,
    selected_member_id: null,
    selected_bmn_no: null,
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
    mawb_no: null,
    validation: false,
    pageOptions: [10, 15, { value: 100, text: "Show a lot" }],
    json_fields: {
      "MAWB NO": "master_airway_bill_no",
      "FLIGHT NO": "flight_no",
      "SHIPPER/EXPORTER": "name_of_shipper",
      BMN: "bmn",
      "INVOICE NO": "shipper_invoice_no",
      "INVOICE DATE": "date",
      "WEIGHT(APPROX)": "weight",
      CONTENTS: "contents",
      DESTINATION: "destination",
      ROUTING: "routing",
      "ON BEHAVE OF": "on_behalf_of_member_name",
      "ON BEHAVE OF NAME": "agent_name",
      "ID NO": "agent_id_no",
      "NO. OF PCS": "no_of_piece",
      "GROSS WEIGHT": "gross_weight",
      CBM: "cbm",
      VWT: "vwt",
      "CHARGABLE WEIGHT": "chargeable_weight",
      "DIMENSION(i)": "dimensioni",
      "DIMENSION(ii)": "dimensionii",
      "DIMENSION(iii)": "dimensioniii",
      "DIMENSION(iv)": "dimensioniv",
      "DIMENSION(v)": "dimensionv",
      "DIMENSION(vi)": "dimensionvi",
      "CREATED DATE": "created_at",
      "CREATED BY": "created_by",
      "LAST UPDATED DATE": "updated_at",
      "LAST UPDATED BY": "updated_by",
    },
    fields: [
      {
        key: "master_airway_bill_no",
        label: "MAWB NO",
        sortable: true,
      },
      "flight_no",
      {
        key: "name_of_shipper",
        label: "Shipper",
      },
      "bmn",
      "destination",
      "weight",
      {
        key: "created_at",
        label: "Created",
      },
      {
        key: "balance_amount",
        label: "Balance",
        variant: "danger",
      },
      "payments",
      "actions",
    ],
  }),
  created() {
    this.getGatePass();
    this.getOrganizations();
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true;
      this.user = window.Laravel.user;
      // this.member_name = window.Laravel.user.email
    } else {
      console.log("Member Not Log In");
    }
  },
  computed: {
    storedSearches: function () {
      return localStorage.storedSearches === undefined
        ? []
        : [...JSON.parse(localStorage.storedSearches)];
    },
  },
  methods: {
    addStoredSearches() {
      let storedSearches = this.storedSearches;
      if (!storedSearches.includes(this.filter)) {
        storedSearches.unshift(this.filter);
        localStorage.storedSearches = JSON.stringify(storedSearches);
      }
    },
    doFilter() {
      this.addStoredSearches();
      this.loading = true;

      // alert(this.filter);
      axios
        .get("/api/saved_gatepass?mawb_no=" + this.filter)
        .then((res) => {
          this.members = res.data.data;
          this.totalRows = this.members.length;
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    doFilterByDate() {
      let start_date = this.customFormatter(this.start_date);
      let end_date = this.customFormatter(this.end_date);
      console.log(start_date, end_date, this.selected_bmn_no);
      if (end_date >= start_date) {
        this.loading = true;
        axios
          .get(
            "/api/saved_gatepass?" +
              "start_date=" +
              start_date +
              "&end_date=" +
              end_date +
              "&bmn_no=" +
              this.selected_bmn_no
          )
          .then((res) => {
            this.members = res.data.data;
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
    fetchOptions(search, loading) {
      loading(true);
    },
    sendInfo({ id, member_id, balance_amount }) {
      this.selected_id_no = id;
      this.selected_member_id = member_id;
      this.openingBalance = balance_amount;
      console.log("Member BMN No.", id);
      // this.selectedUser = item;
    },
    getGatePass() {
      this.loading = true;
      axios
        // .get('/api/saved_gatepass?year=' + this.$route.query.year)
        .get("/api/saved_gatepass")
        .then((res) => {
          this.members = res.data.data;
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
    deleteMember(id) {
      if (confirm("Do you really want to delete gate pass?")) {
        axios
          .delete("/api/saved_gatepass/" + id)
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

#trnsaction_table td,
#trnsaction_table th {
  padding: 0;
}
</style>
