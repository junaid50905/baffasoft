<template>
    <div>
        <main id="printMe">
            <div class="container">
                <p class="ref1">[This is a sample format for printing in your company’s letterhead pad]</p>
                <p class="ref2">Ref#:</p>
                <p>Date:</p>
                <p>To</p>
                <p>Bangladesh Freight Forwarders Association (BAFFA)</p>
                <p>Ataturk Tower (8th Floor)</p>
                <p>22 Kemal Ataturk Avenue</p>
                <p>Banani, Dhaka-1213</p>
                <p class="ref3">DECLARATION</p>
                <p>I would like to request to provide ID Card(s) for the following regular employees/staffs of our company
                    for the year 2022, which particulars are as follows:</p>
                <dl>
                    <dd><b>Sl. No.</b></dd>
                    <dd class="ref4"><b>Card Holder’s Name</b></dd>
                    <dd class="ref5"><b>Designation</b></dd>
                </dl>
                <dl>
                    <dd>01</dd>
                    <dd><span class="lower_border lower_border_1">{{form.card_holder_name}}</span></dd>
                    <dd><span class="lower_border lower_border_2">{{form.card_holder_designation}}</span></dd>
                </dl>

                <p class="ref6">In connection with the above, I (undersigned management person) do hereby declare that,
                    above persons are
                    our regular employee and being the employer of mentioned employees, me (undersigned management person)
                    and my company will be held fully responsible and liable in case of any unlawful/fraudulent activities
                    been carried out by any of our employee by holding BAFFA ID Card at HSIA Cargo Village, and in any
                    circumstances BAFFA and any of its Staff/Directors should not be held liable or responsible for such
                    unlawful/fraudulent activities at all.</p>
                <div class="ref7">
                    <div>_________________</div>
                    <div>
                        <p>Signature & Date</p>
                        <p class="ref8">:</p>
                    </div>
                    <div>
                        <p>Name of the Signatory</p>
                        <p>:</p>
                    </div>
                    <div>
                        <p>Designation</p>
                        <p class="ref9">:</p>
                    </div>
                    <div>
                        <p>Company Name</p>
                        <p class="ref10">:</p>
                    </div>
                    <div>Official Seal of the Company</div>





                </div>

            </div>

        </main>
        <link type="text/css" rel="stylesheet" :href="addProjectPath('/front/assets/css/ref-style.css')">
    </div>
</template>

<script>
export default {
    name: "IDCardPrint2",
    data() {
        return {
            form: {
                card_holder_name: '',
                card_holder_designation: '',
                training_status: 'yes',
                attachment_name: 'National ID',
                dob: new Date().toISOString().slice(0, 10),
                training_date: new Date().toISOString().slice(0, 10)
            },
        }
    },
    created() {
        this.getGatePass()
        window.print();
        window.onmousemove = function() {
            // window.close();
        }
    },
    methods: {
        getGatePass() {
            axios.get('/api/id_card/' + this.$route.params.id)
                .then(res => {
                    this.form = res.data
                    // this.form['nationality_id'] = 50
                    // this.form['birth_date'] = '2021-10-18 04:58:34'
                }).catch(error => {
                console.log('Error: ', error.response)
            })
        }
    }
}
</script>
<style scoped>
.lower_border {
    display: inline-block;
    border: none;
    border-bottom: 1px solid black;
    padding: 5px 10px;
    outline: none;
}
.lower_border_1{
    width: 48%;
}
.lower_border_2{
    width: 24%;
}

</style>
