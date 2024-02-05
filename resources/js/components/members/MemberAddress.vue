<template>
<div>

<div class="container">
    <h4 class="mt-5">Company Owners Information (Directors/Partners/Proprietor):</h4>
<form class="mt-5">
  <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Name:</label>
                <input type="text" class="form-control" name="name" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Designation:</label>
                <input type="text" class="form-control" name="designation" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">NID No:</label>
                <input type="text" class="form-control" name="nid_no" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Attach NID:</label>
                <input type="file" class="form-control" name="attach_nid" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Educational Qualification:</label>
                <input type="text" class="form-control" name="educational_qualification" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Attach Educational Certificate:</label>
                <input type="file" class="form-control" name="attach_educational_qualification" id="exampleInputEmail1">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Photograph:</label>
                <input type="file" class="form-control" name="attach_photograph"  id="exampleInputEmail1">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Mobile No:</label>
                <input type="text" class="form-control" name="mobile_no" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email:</label>
                <input type="text" class="form-control" name="email" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">nationality:</label>
                <select class="form-control" name="nationality_id" id="exampleFormControlSelect2">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Specific Signature:</label>
                <input type="file" class="form-control" name="attach_signature" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Experience Year:</label>
                <input type="text" class="form-control" name="experience_year" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Attach Experience Certificate:</label>
                <input type="file" class="form-control" name="attach_experience_certificate" id="exampleInputEmail1">
            </div>
        </div>

  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Designation</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td><i class="fa fa-edit"></i><i class="fa fa-trash"></i>

</td>
    </tr>
  </tbody>
</table>

</div>



<!--


    <tr class="company_owner_this">
        <th scope="row" rowspan="11">12.0</th>
        <td rowspan="11">Company Owners Information<br>(Directors/Partners/Proprietor):</td>
        <td>Name:</td>
        <td><input type="text" class="form-control" placeholder="Address"
                   :name="form.name"></td>
    </tr>
    <tr>
        <td>Designation :</td>
        <td><input type="text" class="form-control" placeholder="Designation"
                   :name="form.designation">
        </td>
    </tr>
    <tr>
        <td>NID No:</td>
        <td><input type="text" class="form-control" placeholder="Total Floor Area"
                   :name="form.nid_no">
        </td>
    </tr>
    <tr>
        <td> Attach NID:</td>
        <td><input type="file" class="form-control"
                   :name="form.attach_nid">
        </td>
    </tr>
    <tr>
        <td>Educational Qualification:</td>
        <td><input type="text" class="form-control"
                   :name="form.educational_qualification">
        </td>
    </tr>
    <tr>
        <td>Attach Educational Certificate:</td>
        <td><input type="file" class="form-control"
                   :name="form.attach_educational_qualification">
        </td>
    </tr>
    <tr>
        <td>Photograph:</td>
        <td><input type="file" class="form-control"
                   :name="form.attach_photograph">
        </td>
    </tr>
    <tr>
        <td>Mobile No:</td>
        <td><input type="text" class="form-control" placeholder="Mobile No."
                   :name="form.mobile_no">
        </td>
    </tr>
    <tr>
        <td>Email:</td>
        <td><input type="text" class="form-control" placeholder="E-mail Address"
                   :name="form.email">
        </td>
    </tr>
    <tr>
        <td>nationality:</td>
        <td>
            <select class="form-select" aria-label="Default" :name="form.nationality_id">
                <option v-for="country in countries" :selected="country.id === 50" :key="country.id" :value="country.id">{{country.name}}</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Specific Signature:</td>
        <td><input type="file" class="form-control"
                   :name="form.attach_signature">
        </td>
    </tr>
    <tr>
        <td>Experience Year:</td>
        <td><input type="text" class="form-control" placeholder="E-mail Address"
                   :name="form.experience_year">
        </td>
    </tr>
    <tr>
        <td>Attach Experience Certificate:</td>
        <td><input type="file" class="form-control"
                   :name="form.attach_experience_certificate">
        </td>
    </tr>
    <ul>
        <li v-for="company_owner in company_owners">{{company_owner}}</li>
    </ul> -->
</div>
</template>

<script>
export default {
    name: "MemberAddress",
    props:{
        firmTypes: {
            type: Number,
            default: 1,
            request: true,
            validator: function (value) {
                return value >= 1
            }
        }

    },
    data: () => ({
        date_of_today: new Date(),
        company_owner: 1,
        company_owners: [],
        countries:[],
        form:{
            name:null,
            designation:null,
            nid_no:null,
            attach_nid:null,
            educational_qualification:null,
            attach_educational_qualification:null,
            attach_photograph:null,
            mobile_no:null,
            email:null,
            nationality_id:null,
            attach_signature:null,
            experience_year:null,
            attach_experience_certificate:null
        }
    }),
    computed:{
        // firmName: function (){
        //     return 'company_owner['+this.firmTypes+'][attach_signature]'
        // }
    },
    methods: {
        getCountries() {
            axios
                .get('/api/members/'+this.$route.params.id+'/company_owners')
                .then(res => {
                    this.company_owners = res.data
                }).catch(error => {
                console.error(error.response)
            })
        },
        getCountries(){
            axios
                .get('/api/members/countries')
                .then(res => {
                    this.countries = res.data
                }).catch(error => {
                console.error(error.response.data.message)
            })
        },
    }
}
</script>

<style scoped>

</style>
