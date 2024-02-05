<template>
    <div class="container">
        <h4 class="mt-5 text-center">{{form.organization_name}}</h4>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Admission Date</th>
                <th scope="col">BMN</th>
                <th scope="col">Enlistment</th>
                <th scope="col">Type</th>
                <th scope="col">TC/JV/FRG</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{form.member_detail.board_of_directors_meeting_date}}</td>
                <td>{{form.username}}</td>
                <td>{{form.member_detail.place_of_enlistment}}</td>
                <td>{{form.member_detail.firm_type}}</td>
                <td>{{form.member_detail.type_local}}</td>
            </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-light bg-secondary bg-gradient text-center">Membership Renewal</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="d-flex justify-content-between mt-2 font-weight-bold">
                                    <span>Application Submission Date</span>
                                    <span>{{currentData}}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2 font-weight-bold">
                                    <span>Last Membership Renewal Year</span>
                                    <span>{{form.member_detail.last_renew_year}}</span>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Yearly Fee {{ year_difference_label }}</span>
                                    <span>{{yearly_fee}}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Late Fee {{month_difference_label}}</span>
                                    <span>{{late_fee}}</span>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Re-Admission Fee</span>
                                    <span>{{re_admission_fee}}</span>
                                </div>
                                <hr>
                                <div class="d-flex bd-highlight justify-content-between mt-2">
                                    <span>Total Amount</span>
                                    <span class="text-success">{{total_amount}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment/moment";

export default {
    name: "MemberDuePayment",
    props: ['is_member'],
    data: () => ({
        form: {
            organization_name:null,
            member_detail: {
                form_submit_date:null,
                last_renew_year:null
            }
        },
        member_detail: null,
        currentData: moment().format("DD-MM-YYYY"),
        currentMonth: moment().format("MM"),
        currentYear: moment().format("YYYY"),
        yearly_fee: 0,
        late_fee: 0,
        re_admission_fee: 0,
        total_amount: 0,
        request_url: null,
        year_difference_label: '',
        month_difference_label: ''
    }),
    created: function () {
            if(this.is_member){
                this.user = window.Laravel.user;
                this.getMember(this.user)
            }
            else{
                this.getMember();
            }


        // this.getCountries()
        // if(this.member.email){
        //     console.log(this.member)
        // }else {
        //     console.log('sorry')
        // }
    },
    filters: {
        date_format: function (value) {
            if (value) {
                return moment(String(value)).format("DD-MM-YYYY");
            }
        },
    },
    methods: {
        yearDifference: function () {
            let year_difference = this.currentYear - this.form.member_detail.last_renew_year;
            if(year_difference >= 1) {
                this.yearly_fee = 5000
                if (year_difference  == 1) {
                    this.year_difference_label = '( ' + this.currentYear + ' )';
                    if (this.currentMonth - 3 > 1){
                        this.month_difference_label = '( Jan - ' + moment().format("MMM") + ' )'
                        this.late_fee = this.currentMonth * 200;
                        this.total_amount = this.yearly_fee + this.late_fee;
                    }else
                        this.total_amount = this.yearly_fee;
                } else{
                    this.year_difference_label = '( ' + (this.form.member_detail.last_renew_year + 1) + ' - ' + this.currentYear + ' )';
                    this.re_admission_fee = 6000
                    this.yearly_fee = year_difference * this.yearly_fee
                    this.total_amount = this.yearly_fee + this.re_admission_fee;
                }
            }
            return this.total_amount;
        },
        getMember: function (value) {
            if(value)
                this.request_url = "/api/members/" + value.id + "/edit";
            else
                this.request_url = "/api/members/" + this.$route.params.id + "/edit";
            axios
                .get(this.request_url)
                .then((res) => {
                    this.form = res.data.data;
                    this.yearDifference();
                })
                .catch((error) => {
                    console.error("Error", error.response);
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
        size: A4;
    }
}
</style>
