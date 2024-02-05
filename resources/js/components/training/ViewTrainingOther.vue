<template>
  <div class="container">
    <div class="row">

      <link
        type="text/css"
        rel="stylesheet"
        :href="addProjectPath('/front/assets/css/others_tranning.css')"
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
        </div>

        <div class="col-sm-12">
          <div class="headline">
            <h3>BANGLADESH FREIGHT FORWARDERS ASSOCIATION</h3>
            <h4> TRAINING APPLICATION FORM</h4>
          </div>
        </div>

        <div class="col-sm-12">
          <div class="date">
            <p>Date : <input type="text" :value="formData.applicantion_date" readonly="readonly" /></p>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-12">
            <div class="box1">
              <label>Other Training Name:  </label>
              <input type="text" :value="formData.other_training_name" readonly="readonly" />
            </div>
          </div>
        </div>


          <div class="row">
            <div class="col-sm-12">
              <div class="box2">
                <label>Name of the Participant: </label>
                <input type="text" :value="formData.participant_name" readonly="readonly" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box3">
                <label>Designation:</label>
                <input type="text" :value="formData.participant_designation" readonly="readonly" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box4">
                <label>Name of the Organization: </label>
                <input type="text" :value="formData.member" readonly="readonly" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box5">
                <label>Organization Address: </label>
                <span> {{ formData.organization_address }}</span>
                <!-- <input type="text" :value="formData.organization_address" readonly="readonly" /> -->
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="box6">
                <label>Tel: </label>
                <input type="text" :value="formData.participant_tel" readonly="readonly" />
                <label for="date">Mobile:</label>
                <input type="text" :value="formData.participant_mobile" readonly="readonly" />
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-sm-12">
              <div class="box7">
                <label>Email: </label>
                <input type="text" :value="formData.participant_email" readonly="readonly" />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="box8">
                <img
                        v-if="formData.director_signature"
                        :src="addProjectPath('/' + formData.director_signature)"
                        alt="" />
                      <img v-else
                        :src="addProjectPath('/images/no-image.jpg')"
                        alt="" />
                      <br>
                <p style="text-decoration: overline">
                  Seal & Signature of Chairman/MD/ Director <br>
                  <span style="margin-left:8%">Managing Partner/Proprietor</span>
                </p>

              </div>
            </div>

            <div class="col-sm-6">
              <div class="box9">
                  <img
                        v-if="formData.applicant_signature"
                        :src="addProjectPath('/' + formData.applicant_signature)"
                        alt="" />
                      <img v-else
                        :src="addProjectPath('/images/no-image.jpg')"
                        alt="" />
                      <br>
                <p style="text-decoration: overline">Signature of the Applicant’s</p>
              </div>
            </div>
        </div>


        </div>
      </div>
    </div>

</template>

<script>
export default {
    name: "ViewTrainingOther",
    data: () => ({
        validation: true,
        formData: {
            member_id: null,
            master_airway_bill_no: null,
            date: new Date().toISOString().slice(0, 10),
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
