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
          <b-col lg="4" class="my-1">
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
                  placeholder="Type to Search"
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
              </b-input-group>
            </b-form-group>
          </b-col>
          <b-col lg="4" class="my-1">
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
                :to="{ name: 'member_due_payment', params: { id: row.item.id } }"
                class="btn btn-link"
              >
                {{ row.value }}
              </router-link>
            </template>
          </b-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ValidationErrors from "../ValidationErrors";
import ImageTag from "../ImageTag";
import moment from "moment/moment";
import JsonExcel from "vue-json-excel";

export default {
  name: "DueMembers",
  components: { ValidationErrors, ImageTag, JsonExcel },
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
      attach_inspection_report: null,
      attach_checklist: null,
      sub_committee_meeting_date: null,
      board_of_directors_meeting_no: null,
      board_of_directors_meeting_date: null,
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
      { key: "organization_name", label: "Company"}
    ]
  }),
  // watch: {
  //     file1() {
  //         this.nameState = !!this.file1; // if File, then return false
  //     }
  // },
  created() {
    this.getMembers();
    this.getOrganizations();
  },
  methods: {
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
    getMembers() {
      this.loading = true;
      axios
        .get("/api/members/due_members")
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
    }
  }
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
