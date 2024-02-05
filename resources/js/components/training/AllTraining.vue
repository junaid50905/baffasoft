<template>
  <div class="container">
    <div class="row">
      <link
        type="text/css"
        rel="stylesheet"
        :href="addProjectPath('/front/assets/css/voter-form.css')"
      />

      <div class="col-sm-12">
        <!-- dash -->
        <div class="voter-form">
          <form class="needs-validation" role="form" id="voter-form">
            <div class="form-group row">
              <label for="Member" class="col-sm-3 col-form-label">Member name</label>
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Member"
                  placeholder="Member name"
                />
              </div>
            </div>
            <div class="form-group row">
              <label for="Participant" class="col-sm-3 col-form-label"
                >Participant name</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="inputPassword"
                  placeholder="Participant Name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Director" class="col-sm-3 col-form-label">Director name</label>
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Director"
                  placeholder="Director name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="lastUpdated" class="col-sm-3 col-form-label"
                >last Updated</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="lastUpdated"
                  placeholder="last Updated"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="voter" class="col-sm-3 col-form-label">Training Name</label>
              <div class="col-sm-9">
                <select class="custom-select" id="inputGroupSelect01">
                  <option selected>Choose...</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label for="Other" class="col-sm-3 col-form-label"
                >Other Training Name</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="OtherTrainingName"
                  placeholder="Other Training Name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Participant" class="col-sm-3 col-form-label"
                >Participant Name</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Participant"
                  placeholder="Participant Name"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Designation" class="col-sm-3 col-form-label"
                >Participant Designation</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Designation"
                  placeholder="Participant Designation"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="ParticipantTel" class="col-sm-3 col-form-label"
                >Participant Tel No.</label
              >
              <div class="col-sm-3">
                <input
                  type="number"
                  class="form-control"
                  id="ParticipantTel"
                  placeholder="Participant Tel No"
                />
              </div>

              <label for="ParticipantMobile" class="col-sm-2 col-form-label"
                >Participant Mobile.</label
              >
              <div class="col-sm-4">
                <input
                  type="number"
                  class="form-control"
                  id="ParticipantMobile"
                  placeholder="Participant Mobile"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label">Participant Email</label>
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  placeholder="Participant Email"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="dob" class="col-sm-3 col-form-label">Participant DOB</label>
              <div class="col-sm-9">
                <input
                  type="date"
                  class="form-control"
                  id="dob"
                  placeholder="Participant DOB"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Qualification" class="col-sm-3 col-form-label"
                >Participant Qualification</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Qualification"
                  placeholder="Participant Qualification"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Experience" class="col-sm-3 col-form-label"
                >Participant Experience</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  class="form-control"
                  id="Experience"
                  placeholder="Participant Experience"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="idcard" class="col-sm-3 col-form-label">ID Card ID</label>
              <div class="col-sm-9">
                <input
                  type="number"
                  class="form-control"
                  id="idcard"
                  placeholder="ID Card ID"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="caabid" class="col-sm-3 col-form-label"
                >Previous Caab Id No.</label
              >
              <div class="col-sm-9">
                <input
                  type="number"
                  class="form-control"
                  id="caabid"
                  placeholder="Previous Caab Id No"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="applicantsignature" class="col-sm-3 col-form-label"
                >Applicant Signature</label
              >
              <div class="col-sm-3">
                <input
                  type="file"
                  class="form-control"
                  id="applicantsignature"
                  placeholder="Applicant Signature"
                />
              </div>

              <label for="applicant" class="col-sm-2 col-form-label"
                >Applicant Image</label
              >
              <div class="col-sm-4">
                <input
                  type="file"
                  class="form-control"
                  id="applicantimage"
                  placeholder="Applicant Image"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="applicantidcard" class="col-sm-3 col-form-label"
                >Applicant Id Card</label
              >
              <div class="col-sm-3">
                <input
                  type="file"
                  class="form-control"
                  id="applicantidcard"
                  placeholder="Applicant Id Card"
                />
              </div>

              <label for="applicant" class="col-sm-3 col-form-label"
                >Applicant Police Verification</label
              >
              <div class="col-sm-3">
                <input
                  type="file"
                  class="form-control"
                  id="applicant"
                  placeholder="Applicant Police Verification"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="application" class="col-sm-3 col-form-label"
                >Application Date</label
              >
              <div class="col-sm-9">
                <input
                  type="date"
                  class="form-control"
                  id="application"
                  placeholder="application Date"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Certificate" class="col-sm-3 col-form-label"
                >Certificate Number</label
              >
              <div class="col-sm-9">
                <input
                  type="number"
                  class="form-control"
                  id="Certificate"
                  placeholder="Certificate Number"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="Certificate" class="col-sm-3 col-form-label"
                >Certificate Validity Date</label
              >
              <div class="col-sm-3">
                <input
                  type="date"
                  class="form-control"
                  id="Certificate"
                  placeholder="Certificate Date"
                />
              </div>

              <label for="delivery" class="col-sm-3 col-form-label">Delivery Date</label>
              <div class="col-sm-3">
                <input
                  type="date"
                  class="form-control"
                  id="delivery"
                  placeholder="Delivery Date"
                />
              </div>
            </div>

            <div class="form-group row">
              <label for="caab" class="col-sm-3 col-form-label">Caab Id No</label>
              <div class="col-sm-3">
                <input
                  type="number"
                  class="form-control"
                  id="caab"
                  placeholder="Caab Id No"
                />
              </div>

              <label for="file" class="col-sm-3 col-form-label">File Number</label>
              <div class="col-sm-3">
                <input
                  type="number"
                  class="form-control"
                  id="file"
                  placeholder="File Number"
                />
              </div>
            </div>

            <div class="row">
              <div class="col-sm-10 offset-sm-6 p-10">
                <button type="submit" class="btn btn-primary">Confirm</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AllTraining",
};
</script>

<style scoped></style>
