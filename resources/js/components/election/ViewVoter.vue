<template>
  <div class="container">
    <div class="row">
      <link
        type="text/css"
        rel="stylesheet"
        :href="addProjectPath('/front/assets/css/view_voter_form.css')"
      />

      <div class="col-sm-12">
        <!-- dash -->

        <div class="col-12">
          <button
            type="button"
            id="printPDF"
            class="btn btn-secondary btn-lg btn-block"
            onclick="window.print()"
          >
            Print
          </button>
        </div>

        <div class="boxNew">
          <div class="logoNew">
            <img
              :src="addProjectPath('/front/assets/img/id_card/baffa-logo.png')"
              alt=""
              width="179"
            />
          </div>

          <div class="form-new">
            <img
              v-if="form.voter_image"
              :src="addProjectPath('/' + form.voter_image)"
              alt=""
            />
            <img v-else :src="addProjectPath('/images/no-image.jpg')" alt="" />
            <!-- <img :src="addProjectPath('/front/assets/img/bruce-mars.jpg')" alt="" /> -->
            <p>
              Date : <span class="c">{{ form.created_at }}</span>
            </p>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="headline">
            <h3>VOTER NOMINATION FORM</h3>
            <span>FOR ENLISTMENT AS VOTER FOR ELECTION TO THE BOARD OF DIRECTORS OF</span
            ><br />
            <span>BANGLADESH FREIGHT FORWARDERS ASSOCIATION FOR THE TERM {{form.election.election_session}}</span>
          </div>
        </div>

        <div class="renewal-form">
          <div class="row">
            <div class="col-sm-12">
              <div class="box1">
                <div>
                  Name of the Member (Company/Firm): &nbsp;<span class="a">
                    {{ form.member }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box2">
                <div>
                  Name of the Nominated Representative (Voter):&nbsp;<span class="b">
                    {{ form.voter_name }} </span
                  ><br />
                  <span class="voter-sectitle"
                    >(S/He must be Proprietor/Partner/Shareholder Director)
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box3">
                <div>
                  Designation: &nbsp;<span class="c"> {{ form.voter_designation }} </span>
                  e-TIN No: &nbsp;<span class="c">
                    {{ skipNullvalue(form.voter_e_tin_no) }}
                  <a
                    style="padding-left: 50px"
                    id="printPDF"
                    :href="assetPath('/' + form.voter_e_tin_attachment)"
                    target="_blank"
                >See the Attachment
                </a></span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box4">
                <div>
                  <!-- <label>Address of the Member:&nbsp; </label> -->
                  Address of the Member:&nbsp;
                  <span> {{ form.voter_address }}</span>
                  <!-- <span class="d"> {{ form.voter_address }}</span> -->
                  <!-- <br></br> -->
                  <!-- <span class="address"></span> -->
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box5">
                <div>
                  Tel: &nbsp;<span class="e"> {{ skipNullvalue(form.voter_tel) }} </span>
                  Mob: &nbsp;<span class="e">{{ skipNullvalue(form.voter_mob) }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box6">
                <div>
                  Fax: &nbsp;<span class="f"> {{ skipNullvalue(form.voter_fax) }} </span>
                  Email: &nbsp;<span class="f">{{
                    skipNullvalue(form.voter_email)
                  }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <div class="voter-sign">
          <p>
            Specimen Signature of the <br />
            Nominated Representative (Voter)
          </p>
          <p class="sign">
            <img
              v-if="form.manager_signature"
              :src="addProjectPath('/' + form.voter_signature)"
            />
            <img v-else :src="addProjectPath('/images/no-image.jpg')" />
            <span>…………………………………………………</span>
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="sign-managing">
          <p>The above particulars are hereby attested by</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="sign-managing">
          <img
            v-if="form.manager_signature"
            :src="addProjectPath('/' + form.manager_signature)"
          />
          <img v-else :src="addProjectPath('/images/no-image.jpg')" />
          <!--          <img :src="addProjectPath('/front/assets/id-card-print/img/prer-sg.png')">-->
          <p>
            ……………………………………………………………………………………<br />Signature of Managing Director/
            Director/ Chairman/<br />
            Managing Partner/Partner/Proprietor with seal
          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="box7">
          <div>
            Name : &nbsp;<span class="g">
              {{ form.manager_name }}
            </span>
          </div>
          <!-- <label>Name: </label>
                    <input type="text" :value="manager_name" /> -->
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="box8">
          <div>
            Designation : &nbsp;<span class="h">
              {{ form.manager_designation }}
            </span>
          </div>
          <!-- <label>Designation: </label>
                    <input type="text" :value="manager_designation" /> -->
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="box9">
          <div>
            <span class="i"> Date : &nbsp;{{ form.manager_date }}</span>
            <!-- <span class="seal">(Company/Firm Seal)</span> -->
          </div>
          <!-- <div>(Company/Firm Seal)</div> -->
        </div>
      </div>
      <div class="col-sm-6">
        <div class="box9">
          <div>
            <!-- <span class="i"> Date : &nbsp;{{ form.manager_date }}</span> -->
            <p>(Company/Firm Seal)</p>
          </div>
          <!-- <div>(Company/Firm Seal)</div> -->
        </div>
      </div>
    </div>

    <!-- <div class="row">
      <div class="col-sm-6">
        <div class="box10">
          <div>
          <span class="i"> Date : &nbsp;{{ form.manager_date }}</span>
          <p>(Company/Firm Seal)</p>
          </div>
          <div>(Company/Firm Seal)</div>
        </div>
      </div>
    </div> -->

    <br /><br />
    <div class="nbrequired">
      <span>N.B: Please submit the following documents with this form </span>
    </div>
    <div class="box9">
      <div>
        <b>(i) </b>Duly attested copy of payment receipt of Income Tax/Income Tax
        Certificate/ e-TIN certificate as may be applicable
      </div>
      <div>
        <b>(ii) </b>Photocopy of Updated Trade License and Freight Forwarders License.
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ViewElection",
  data() {
    return {
      form: {
        voter_name: "",
      },
    };
  },
  created() {
    this.getVoter();
  },
  methods: {
    skipNullvalue(v) {
      return v == "null" ? "" : v;
    },
    getVoter() {
      axios
        .get("/api/voter/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data.data;
          // this.form.members = this.form.members.map((v) => v.organization_name);
        })
        .catch((error) => {
          console.log("Error: ", error.response);
        })
        .finally(() => {
          setTimeout(function () {
            // window.print()
          }, 1000);
        });
    },
  },
};
</script>

<style scoped>
@media print {
  #edit,
  #edit * {
    visibility: hidden;
  }

  #printPDF {
    visibility: hidden;
    margin: 0;
    size: A4;
    margin: -7.5%;
  }
}
</style>
