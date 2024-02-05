<script>
import moment from "moment";

export default {
    name: "MemberInspection",
    components: {ValidationErrors, ImageTag },
    props: ['memberId','send_to_admin','hideField'],
    watch: {
/*        errors(){
            if(this.errors){
                this.showErrors = true
            }else{
                this.showErrors = false
            }
        },
        success(){
            if(this.success){
                this.showSuccess = true
            }
        },
        warning_message(){
            if(this.warning_message){
                this.showMessage = true
            }
        }*/
    },
    data: () => ({
        // message:this.warning_message,
        showSuccess: false,
        showErrors: false,
        showMessage: false,
        nameState: null,
        selected: null,
        validationErrors: null,
        success: "",
        warning_message: "",
        formData:{
            send_to_admin: false,
            attach_inspection_report: null,
            attach_checklist: null,
            sub_committee_meeting_date: null,
            board_of_directors_meeting_no: null,
            board_of_directors_meeting_date: null,
        }
    }),
    methods: {
        saveImage: function (event) {
            this.formData[event.target.name] = event.target.files[0];
        },
        resetModal() {
            // this.file1 = null
            this.nameState = null;
            // this.send_to_admin = null
            this.selected = [];
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        checkFormValidity() {
            const valid = this.$refs.form.checkValidity();
            this.nameState = valid;
            return valid;
        },
        handleOkSubmit(bvModalEvt) {
            this.formData["send_to_admin"] = true;
            bvModalEvt.preventDefault();
            this.handleSubmit();
        },
        handleSubmit() {
            // Exit when the form isn't valid
            if (!this.checkFormValidity()) {
                return;
            }
            // Push the name to submitted names
            // this.submittedNames.push(this.name)
            this.updateMember();
        },
        updateMember() {
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
                    this.$emit('reset')
                    this.$emit('getMembers')
                    // this.reset();
                    // this.getMembers();
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
        },
    },
    created: function (){

    },
    computed: {
        // validationErrors() {
        //     let errors = Object.values(this.errors);
        //     errors = errors.flat();
        //     return errors;
        // }
    }
}

import ImageTag from "./ImageTag.vue";
import ValidationErrors from "./ValidationErrors.vue";
</script>

<template>
    <b-modal
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
            <b-form-group label="Inspection Paper" label-for="name-file" v-if="hideField">
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
            <div class="form-group" v-if="hideField">
                <label for="sub_committee_meeting_date">Sub Committee Meeting Date</label>
                <b-form-datepicker
                    id="sub_committee_meeting_date"
                    name="sub_committee_meeting_date"
                    v-model="formData.sub_committee_meeting_date"
                    class="mb-2"
                ></b-form-datepicker>
            </div>
            <b-form-group label="Board of Director Meeting No." label-for="name-input" v-if="hideField">
                <b-form-input
                    id="name-input"
                    type="number"
                    name="board_of_directors_meeting_no"
                    v-model="formData.board_of_directors_meeting_no"
                ></b-form-input>
            </b-form-group>
            <div class="form-group" v-if="hideField">
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
            <!--                <div class="mt-3">Selected file: {{ formData.attach_inspection_report ? formData.attach_inspection_report.name : '' }}</div>-->
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
    </b-modal>
</template>

<style scoped>

</style>
