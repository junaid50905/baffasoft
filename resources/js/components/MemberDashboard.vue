<template>
  <div class="row all_b_size">
    <!-- <link
      type="text/css"
      rel="stylesheet"
      :href="addProjectPath('/front/assets/css/dashboard-style.css')"
    /> -->





  <h3 class="text-center" style=" color: #5b392b;">BAFFA Member’s Dashboard</h3>
  <div class="right-hiden-but"> <a style="background: #fdd251;" class="btn btn-default btn-sm" v-on:click="notifiation = !notifiation"><i class="fa fa-bell"></i><div>{{count_notifications}}</div></a></div>
  <div class="col-sm-12">
      <transition name="slide-fade">
          <div class="p1 mb-5 notification_part" v-if="notifiation">
              <a style="float: right; color: #fff; background: #FF5722;" class="btn btn-default btn-sm" v-on:click="notifiation = !notifiation">{{ notifiation ? 'x' : 'Open' }}</a>
              <h3 class="text-center">Notification for recent activities</h3>
              <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover tab_notific">
                      <tr>
                          <th>Date-Time</th>
                          <th>Notice Type</th>
                          <th>Notice Details</th>
                      </tr>
                      <tr v-for="notification in notifications">
                          <td>{{ notification.created_at | date_time_format }}</td>
                          <td>{{ notification.message_title }}</td>
                          <td>{{ notification.message_description }}</td>
                      </tr>
                  </table>
              </div>
          </div>
      </transition>
</div>



    <div class="col-sm-12">
            <div class="round_box table-responsive">
                <table class="table table-borderless table-sm table-condensed">
                    <tbody>
                    <tr>
                        <td class="w-200">Name of Organization</td>
                        <td class="w-10">:</td>
                        <td>{{ member.organization_name }}</td>
                    </tr>
                    <tr>
                        <td>Membership Number</td>
                        <td>:</td>
                        <td>{{ member.username }}</td>
                    </tr>
                    <tr>
                        <td>Date of Admission </td>
                        <td>:</td>
                        <td>{{ member.member_detail.board_of_directors_meeting_date }}</td>
                    </tr>
                    <tr>
                        <td>Place of Enlistment </td>
                        <td>:</td>
                        <td>{{ member.member_detail.place_of_enlistment }}</td>
                    </tr>
                    <tr>
                        <td>Type of the Organization</td>
                        <td>:</td>
                        <td>{{ firmTypeLabel }} - {{member.member_detail.type_local}}</td>
                    </tr>
                    <tr>
                        <td>Activity Status</td>
                        <td>:</td>
                        <td>{{ member.status }}</td>
                    </tr>
                    <tr>
                        <td>GatePass Balance</td>
                        <td>:</td>
                        <td>
                            <span style="font-weight: bold;" v-if="member.gatepass_balance > 0">{{ member.gatepass_balance }} TK</span>
                            <span v-else>0.00 TK</span>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12">
            <h3 class="text-center">Company Owner(s) information</h3>
            <div class="round_box table-responsive-sm" v-for="company_owner in member.company_owners">
                <table class="table table-borderless table-sm m-0 table-condensed">
                    <tbody>
                    <tr>
                        <td rowspan="11" class="w-200 pic-siz">
                            <img v-if="company_owner.attach_photograph !== null"
                                 :src="addProjectPath('/' + company_owner.attach_photograph)"
                                 alt="PHOTO" style="border: 5px solid white" width="128" height="156"/>
                            <img v-else :src="addProjectPath('/assets/img/photo-icon.png')"/>
                        </td>
                        <td class="w-300 text-right">Name</td>
                        <td class="w-10">:</td>
                        <td>{{ company_owner.name }}</td>
                    </tr>
                    <tr>
                        <td class="w-300 text-right">Designation</td>
                        <td>:</td>
                        <td>{{ company_owner.designation }}</td>
                    </tr>
                    <tr>
                        <td class="w-300 text-right">Nationality</td>
                        <td>:</td>
                        <td>{{ company_owner.nationality_name }}</td>
                    </tr>
                    <tr>
                        <td class="w-300 text-right">Mobile No</td>
                        <td>:</td>
                        <td>{{ company_owner.mobile_no }}</td>
                    </tr>
                    <tr>
                        <td class="w-300 text-right">Email</td>
                        <td>:</td>
                        <td>{{ company_owner.email }}</td>
                    </tr>
                    <tr v-if="company_owner.signatory == 1">
                        <td class="w-300 text-right">Signatory</td>
                        <td>:</td>
                        <td>{{ company_owner.signatory == 1 ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr v-if="company_owner.authorized_person == 1">
                        <td class="w-200 text-right">Authorized Person</td>
                        <td>:</td>
                        <td>{{ company_owner.authorized_person  == 1 ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr v-if="company_owner.nominate_for_vote == 1">
                        <td class="w-200 text-right">Nominate For Vote</td>
                        <td>:</td>
                        <td>{{ company_owner.nominate_for_vote  == 1 ? 'Yes' : 'No' }}</td>
                    </tr>


                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-sm-6 addres_box">
            <h5>Register Address</h5>
            <ul class="list-inline ">
                <li>{{ member.head_office_address }}</li>
                <li><b>Floor Area:</b> {{ member.head_office_floor_area }}</li>
                <li><b>Telephone No:</b> {{ member.head_office_telephone_no }}</li>
                <li><b>Fax No:</b> {{ member.head_office_fax_no }}</li>
                <li><b>Mobile No:</b> {{ member.head_office_mobile_no }}</li>

                <li><b>E-mail Address:</b> {{ member.head_office_email_address }}</li>

            </ul>

        </div>

        <div class="col-sm-6 addres_box">
            <h5>Branch Office Address</h5>
            <ul class="list-inline ">
                <li>{{ member.branch_office_address }}</li>
                <li><b>Total Floor Area:</b> {{ member.branch_office_floor_area }}</li>
                <li><b>Telephone No:</b> {{ member.branch_office_telephone_no }}</li>
                <li><b>Fax No:</b> {{ member.branch_office_fax_no }}</li>
                <li><b>Mobile No:</b> {{ member.branch_office_mobile_no }}</li>

                <li><b>E-mail Address:</b> {{ member.branch_office_email_address }}</li>
            </ul>

        </div>


  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "MemberDashboard",
  data: () => ({
    notifiation:false,
    header: ["CARGO ENTRY GATE PASS REPORT"],
    start_date: new Date().toISOString().slice(0, 10),
    end_date: new Date().toISOString().slice(0, 10),
    notifications: [],
      count_notifications: 0,
      firmType: "Proprietor",
      firmTypeLabel: null,
    member: {
      company_owners: {},
      gatepass_balance: 0,
      member_address: {},
      member_detail: {},
      privileges: {},
    },
    form: {
      company_owners: {},
      gatepass_balance: 0,
      member_address: {},
      member_detail: {},
      privileges: {},
    },
    isLoggedIn: false,
    user: null,
  }),
  filters: {
    date_time_format(value) {
      return moment(String(value)).format("DD-MM-YYYY HH:mm:ss");
    },
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true;
      this.user = window.Laravel.user;
      this.getMemberDetails(this.user.id);
      this.getMemberNotification(this.user.id);
      // this.member_name = window.Laravel.user.email
    } else {
      console.log("Member Not Log In");
    }
  },
  methods: {
    getMemberDetails(id) {
      this.loading = true;
      axios
        .get("/api/members/" + id + "/edit")
        .then((res) => {
          this.member = res.data.data;
            this.firmType = res.data.data["member_detail"]["firm_type"];
            if (this.firmType == 'Proprietor')
                this.firmTypeLabel = 'Proprietorship';
            else if (this.firmType == 'Partners')
                this.firmTypeLabel = 'Partnership';
            else if (this.firmType == 'Limited')
                this.firmTypeLabel = 'Limited';
            if (res.data.data["member_address"]) {
                this.tempForm = res.data.data["member_address"];
                this.tempForm.forEach((value, index) => {
                    // arr.push(value);
                    if (value["member_address_type"] == "register") {
                        this.member.head_office_address = value["address"];
                        this.member.head_office_floor_area = value["floor_area"];
                        this.member.head_office_telephone_no = value["telephone_no"];
                        this.member.head_office_fax_no = value["fax_no"];
                        this.member.head_office_mobile_no = value["mobile_no"];
                        this.member.head_office_email_address = value["email_address"];
                        this.member.head_office_website = value["website"];
                        this.member.head_office_attach_office_tenancy_agreement =
                            value["attach_office_tenancy_agreement"];
                    } else if (value["member_address_type"] == "branch") {
                        this.member.branch_office_address = value["address"];
                        this.member.branch_office_floor_area = value["floor_area"];
                        this.member.branch_office_telephone_no = value["telephone_no"];
                        this.member.branch_office_fax_no = value["fax_no"];
                        this.member.branch_office_mobile_no = value["mobile_no"];
                        this.member.branch_office_email_address = value["email_address"];
                        this.member.branch_office_website = value["website"];
                        this.member.branch_office_attach_office_tenancy_agreement =
                            value["attach_office_tenancy_agreement"];
                    }
                });
            }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getMemberNotification(id) {
      this.loading = true;
      axios
        .get("/api/members/" + id + "/notifications")
        .then((res) => {
          this.notifications = res.data.all_notifications;
          this.count_notifications = res.data.count_notifications;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>



<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
    transition: all .3s ease;
}
.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}

table{
    font-size: 15px;
    color: #000;
}

.right-hiden-but{
    position: absolute;
    text-align: right;
    right: 6%;
    width: 8%;
}

.right-hiden-but .fa{
  font-size: 20px;
    color: #f00;
    margin-left: -15px;
}
.right-hiden-but div{
    position: absolute;
    display: inline-table;
    width: 20px;
    height: 20px;
    color: #fff;
    background: #000;
    border-radius: 50px;
    line-height: 20px;
    margin-left: 4px;
}


.all_b_size{
  width: 90%;
  margin: 0 auto;
}

.w-200 {
    width: 200px;
}

.w-300 {
    width: 200px;
}

.w-10 {
    width: 10px !important;
    text-align: center;
}

.notification_part{
    border-radius: 15px;
    border: 1px solid #795548;
    background: #fff8ef;
    padding: 19px;
    position: absolute;
    top: 30px;
    display: block;
    width: 88.5%;
    height: 72vh;
    overflow-y: scroll;
    box-shadow: 2px 0px 27px 0px rgba(0,0,0,0.75);
    -webkit-box-shadow: 2px 0px 27px 0px rgba(0,0,0,0.75);
    -moz-box-shadow: 2px 0px 27px 0px rgba(0,0,0,0.75);
}

.notification_part table tr:hover td {
        background-color: rgb(253 208 146);
        border: 0;
      }

.notification_part table tr:nth-child(3)
{
  background-color: rgb(233 233 233);

}
.tab_notific .tb_colar{
    border:1px solid rgb(97, 97, 97);
    color:rgb(0, 0, 0);
    padding: 5px 10px;
  }
  .tab_notific th{
    background-color: #ffd78c;
    border-bottom: 1px solid #000;
    color: #000;
    padding: 10px 10px;
  }

  .tab_notific tr{
    border-bottom: 1px solid #919191;
    color: #000;
  }
.pic-siz img {
    width: 150px;
}
.text-right{
  text-align: right;
}
.txt_left{
  text-align: left;
}
.round_box {
    border: 1px solid #ccc;
    padding: 30px;
    margin: 44px 0;
    border-radius: 13px;
    background: #fdfdfd;
}

.round_box th, td {
    padding: 1px;
}

.pic-siz .sig {
    width: 77%;
    text-align: center;
    padding-top: 20px;
}

.pic-siz .sig img {
    width: 70%;
}

.addres_box {
    border: 1px solid #ccc;
    padding: 20px;
    vertical-align: top;
}
.addres_box h5{
  font-size: 18px;
}



.list-inline li {
    display: block;
    list-style-type: none;
    font-size: 15px;
}

.last_tab_set {
    background: #ededed;
    padding: 5px;
    margin-top: 20px;
}

.star_1 tr td {
    border: 1px solid #ccc;
    padding: 10px;
    background: #fff;
}


.star_1 caption {
    color: #000000;
    text-align: left;
    caption-side: top;
    background: #fff3ce;
    padding: 10px 10px;
    font-weight: 800;
}

.fooot {
    margin-top: 13px;
    width: 100%;
    padding: 20px;
    border: 1px solid #ccc;
}

/* responsiv */


</style>
