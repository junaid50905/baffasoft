<template>
  <div class="container">
      <div class="row">


        <link
          type="text/css"
          rel="stylesheet"
          :href="addProjectPath('/front/assets/css/tranning_form.css')"
        />

        <div class="col-sm-12">


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
              <!-- <span v-if="formData.applicant_photograph_attachment !==null></span> -->
              <img v-if="formData.applicant_photograph_attachment" :src="addProjectPath('/'+formData.applicant_photograph_attachment)" alt="" />
              <img v-else :src="addProjectPath('/images/no-image.jpg')" alt="" />
              <p>Date :  <input type="text" :value="formData.applicantion_date" readonly="readonly" /></p>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="headline">
              <h4>BANGLADESH FREIGHT FORWARDERS ASSOCIATION</h4>
              <h3>APPLICATION FORM FOR TRAINING</h3>
            </div>
          </div>

          <div class="renewal-form">
            <div class="row">
              <div class="col-sm-12">
                <div class="title">
                  <h5>Name of the Training: Cargo Security Awareness</h5>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box1">
                  <label>Name of the Participant: </label>
                  <input type="text" :value="formData.participant_name" readonly="readonly" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box2">
                  <label>Designation:</label>
                  <input type="text" :value="formData.participant_designation" readonly="readonly" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box3">
                  <label>Name of the Organization: </label>
                  <input type="text" :value="formData.member" readonly="readonly" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box4">
                  <label>Address of the Member: </label>
                  <span v-if="formData.organization_address !== 'null'"> {{ formData.organization_address }}</span>
                  <!-- <input type="text" :value="formData.organization_address" readonly="readonly" /> -->
                  <!-- <input type="text" id="address" readonly="readonly" /> -->
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box5">
                  <label>Participant’s Mobile: </label>
                  <input type="text" :value="formData.participant_mobile" readonly="readonly" />
                  <label for="date">E-mail (optional):</label>
                  <input type="text" :value="formData.participant_email" readonly="readonly" />
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="box6">
                  <label>BAFFA valid ID card No:</label>
                  <input type="text" :value="formData.id_card_id" readonly="readonly" />
                  <label for="date">Previous CAAB ID No (if any):</label>
                  <input type="text" :value="formData.previous_caab_id_no" readonly="readonly" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <div class="box7">
              <img v-if="formData.director_signature" :src="addProjectPath('/' + formData.director_signature)" alt="" />
              <img v-else :src="addProjectPath('/images/no-image.jpg')" alt="" />
            <p>
              <span style="text-decoration: overline">Seal & Signature of Chairman/MD/ Director </span>
                <br></br>
              <span style="margin-left:8%">Managing Partner/Proprietor</span>
            </p>

          </div>
        </div>

        <div class="col-sm-6">
          <div class="box8">
              <img v-if="formData.applicant_signature" :src="addProjectPath('/' + formData.applicant_signature)" alt="" />
              <img v-else :src="addProjectPath('/images/no-image.jpg')" alt="" />
            <p style="text-decoration: overline">Signature of the Applicant’s</p>
          </div>
        </div>
      </div>



      <br /><br />
      <div class="nbrequired">
        <span>THE FOLLOWING DOCUMENTS ARE REQUIRED FOR REGISTRATION:</span>
      </div>
      <ul class="underline">
        <li>1.  Duly filled up the form</li>
        <li>
            2.  Photocopy of participant’s National ID/Passport/Birth certificate -
            <br>
            {{formData.applicant_national_id_card}} - {{formData.applicant_national_id_card_number}}
            <br>
            <a id="printPDF" :href="assetPath('/'+formData.applicant_national_id_card_attachment)" target="_blank">Attachment</a>
        </li>
        <li>3.  Updated Police Verification/Clearance Certificate.
            <br>
            Data: {{formData.applicant_police_verification_date}}
            <br>
            <a id="printPDF" :href="assetPath('/'+formData.applicant_police_verification_attachment)" target="_blank">Attachment</a>
        </li>
        <li>4.  Participant’s recent 01 (one) copy passport size photograph</li>
      </ul>
    </div>

  </template>

  <script>
  export default {
      name: "ViewTrainingCSA",
      data: () => ({
          validation: true,
          formData: {
              member_id: null,
              master_airway_bill_no: null,
              date: new Date().toISOString().slice(0, 10),
              applicant_photograph_attachment:false,
              applicantion_date:null,
              participant_name:null,
              participant_designation:null,
              member:null,
              organization_address:null,
              participant_mobile:null,
              participant_email:null,
              id_card_id:null,
              previous_caab_id_no:null,
              attach_signature:null,
              applicant_signature:null,
              director_signature:'',
              // vehicle_date_of_entry: new Date().toISOString().slice(0, 10),
              // vehicle_time_of_entry: new Date().toISOString().slice(11,19),
              // weight_taken_date_time: new Date().toISOString().slice(0,19),
          }

      }),
      created() {
          this.getMembers()
      },
      methods: {
          getMembers() {
              axios
                  .get('/api/training/'+this.$route.params.id)
                  .then(res => {
                      this.formData = res.data.data
                  }).catch(error => {
                  console.error(error.response.data.message)
              })
          }
      }
  }
  </script>

  <style scoped>
  </style>
