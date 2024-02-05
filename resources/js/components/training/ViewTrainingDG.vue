<template>
    <div class="container">
        <div class="row">


          <link
            type="text/css"
            rel="stylesheet"
            :href="addProjectPath('/front/assets/css/dg_tranning.css')"
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
                <h4> APPLICATION FORM FOR TRAINING</h4>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="date">
                <p>Date : <input type="text" :value="formData.applicantion_date" readonly="readonly" /></p>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12">
                <div class="title">
                  <h5>Name of the Training: Dangerous Goods Regulations</h5>
                </div>
              </div>
            </div>
<!--              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group checkbox">
                          <label>Title: </label>
                          <div class="form-check form-check-inline">
                            <b-form-radio-group id="radio-group-2" v-model="formData.title" name="title">
                                <b-form-radio value="Mr." disabled>Mr.</b-form-radio>
                                <b-form-radio value="Ms." disabled>Ms.</b-form-radio>
                                <b-form-radio value="Mrs." disabled>Mrs.</b-form-radio>
                                <b-form-radio value="Dr." disabled>Dr.</b-form-radio>
                                <b-form-radio value="Prof." disabled>Prof.</b-form-radio>
                            </b-form-radio-group>
                  </div>
              </div>
              </div>
              </div>-->
              <div class="row">
                <div class="col-sm-12">
                  <div class="box2">
                    <label>Category Name: </label>
                    <input type="text" :value="formData.category_name" readonly="readonly" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="box3">
                    <label>Name of the Participant: </label>
                    <input type="text" :value="formData.title + ' ' +formData.participant_name" readonly="readonly" />
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
                    <span v-if="formData.organization_address !== 'null'"> {{ formData.organization_address }}</span>
                    <!-- <input type="text" :value="formData.organization_address" readonly="readonly" /> -->
                    <!-- <input type="text" id="address" value="" readonly="readonly" /> -->
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-sm-12">
                  <div class="sec-title">
                    <h5>Participant’s Personal Information:</h5>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box6">
                    <label>Date of Birth: </label>&nbsp;&nbsp;
                    <input type="text" id="start" name="trip-start" :value="formData.participant_dob" readonly="readonly">
                    <label for="date">Academic Qualification:</label>
                    <input type="text" id="academic" :value="formData.participant_qualification" readonly="readonly" />
                  </div>
                </div>
              </div>


              <div class="row">
                <div class="col-sm-12">
                  <div class="box7">
                    <label> Mobile: </label>
                    <input type="text" :value="formData.participant_mobile" readonly="readonly" />
                    <label for="date">E-mail:</label>
                    <input type="text" :value="formData.participant_email" readonly="readonly" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="box8">
                    <label>Brief Experience: </label>
                    <span> {{ formData.participant_experience }}</span>
                    <!-- <input type="text" :value="formData.organization_address" readonly="readonly" /> -->
                    <!-- <input type="text" id="address" value="" readonly="readonly" /> -->
                  </div>
                </div>
              </div>


            <!-- <div class="container">
              <div class="row">
                <div class="col-sm-12 col-lg-12 col-md-12">
                  <div class="box8">
                    <table>
                        <td>
                          <label>Brief Experience: </label>
                          <span> {{ formData.participant_experience }}</span>
                          <p> {{ value=formData.participant_experience }} </p>
                          <input type="text" :value="formData.participant_experience" readonly="readonly" />
                          <input type="text" id="address" value="" readonly="readonly" />
                          <input type="text" id="address" value="" readonly="readonly" />
                          <input type="text" id="address" value="" readonly="readonly" />
                          <input type="text" id="address" value="" readonly="readonly" />
                        </td>
                    </table>
                  </div>
                </div>
              </div>
            </div> -->

<br>

              <div class="row">
                <div class="col-sm-6">
                  <div class="box9">
                    <p>
                      <img
                        v-if="formData.director_signature"
                        :src="addProjectPath('/' + formData.director_signature)"
                        alt="" />
                      <img v-else
                        :src="addProjectPath('/images/no-image.jpg')"
                        alt="" />
                      <br>
                      <span style="text-decoration: overline">Seal & Signature of Chairman/MD/ Director </span><br>
                      <span style="margin-left:8%">Managing Partner/Proprietor</span>
                    </p>

                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="box10">
                    <p>
                      <img
                        v-if="formData.applicant_signature"
                        :src="addProjectPath('/' + formData.applicant_signature)"
                        alt="" />
                      <img v-else
                        :src="addProjectPath('/images/no-image.jpg')"
                        alt="" />
                      <br/>
                    </p>
                    <p style="text-decoration: overline">Signature of the Applicant’s</p>
                  </div>
                </div>
            </div>


            <div class="location">
              <table>
                  <td style="font-size:14px">
                    <span class="a">Dhaka Office <i class="fas fa-map-marker-alt"></i></span> House No.
                    10(Level-2 & 3),Road No.17A Block-E,Banani,Dhaka-1213,Tel.+88028836324-25,Fax:+88
                    02222281664,Email:info@baffa-bd.org
                  </td>
              </table>
            </div>
            <div>
              <table>
                <td>
                  <span class="a">Chattagram Office <i class="fas fa-map-marker-alt"></i></span> Anwara Trade Center (Level-10),1728,Agrabad
                  C/A Chattagroam, Tel: +8802 333323453,333323505,Email:admin.ctg@baffa-bd.org
                </td>
              </table>
            </div>


            <div class="footer">
              <p>www.baffa-bd.org</p>
            </div>


            </div>





          </div>
        </div>

</template>

<script>
export default {
  name: "ViewTrainingDG",
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



};




</script>
<style scoped>
</style>
