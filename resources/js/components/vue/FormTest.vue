<template>
    <div>
        <form
            id="app"
            @submit="checkForm"
            action="http://localhost/baffasoft/api/login"
            method="post"

        >

            <p v-if="errors.length">
                <b>Please correct the following error(s):</b>
            <ul>
                <li v-for="error in errors">{{ error }}</li>
            </ul>
            </p>

            <p>
                <label for="username">User Name</label>
                <input
                    id="username"
                    v-model="username"
                    type="text"
                    name="username"
                >
            </p>

            <p>
                <label for="email">Email</label>
                <input
                    id="email"
                    v-model="email"
                    type="email"
                    name="email"
                >
            </p>
            <p>
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="password"
                    type="password"
                    name="password"
                >
            </p>
            <p>
                <label for="device_name">Browser Type</label>
                <input
                    id="device_name"
                    v-model="device_name"
                    type="text"
                    name="device_name"
                >
            </p>

            <p>
                <label for="movie">Favorite Movie</label>
                <select
                    id="movie"
                    v-model="movie"
                    name="movie"
                >
                    <option>Star Wars</option>
                    <option>Vanilla Sky</option>
                    <option>Atomic Blonde</option>
                </select>
            </p>

            <p>
                <input
                    type="submit"
                    value="Submit"
                >
            </p>

        </form>

        <button type="button" @click="btnOnClick">Add</button>


        <table id="printMe">
            <tbody>
            <tr v-for="(row, k) in tableData" :key="k">
                <td>
                    <input class="form-control" readonly v-model="row.itemname">
                </td>
                <td>
                    <input
                        class="form-control text-right"
                        type="text"
                        min="0"
                        step=".01"
                        :value="row.quantity"
                    >
                </td>
                <td>
                    <input
                        class="form-control text-right"
                        type="text"
                        min="0"
                        step=".01"
                        :value="row.sellingprice"
                    >
                </td>
                <td>
                    <input
                        readonly
                        class="form-control text-right"
                        type="text"
                        min="0"
                        step=".01"
                        :value="row.amount"
                    >
                </td>
            </tr>
            </tbody>
        </table>
        <button class="btn" @click="print">Print</button>
    </div>
</template>

<script>
export default {
    name: "FormTest",
    data() {
        return {
            tableData: [],
            errors: [],
            username: 'admin',
            email: 'admin@example.com',
            password: 'admin123',
            device_name: 'VUE',
            movie: null
        }
    },
    methods: {
        btnOnClick(v) {
            this.tableData.push({
                itemname: "item",
                quantity: 1,
                sellingprice: 55,
                amount: 55
            });
        },
        checkForm: function (e) {
            this.errors = [];
            if (!this.username) this.errors.push("Name required.");
            if (!this.email) {
                this.errors.push("Email required.");
            }
            if (!this.errors.length){
                let data = new FormData();
                data.set('username', this.username);
                data.set('password', this.password);
                data.set('device_name', this.device_name);
                axios
                    .post('/api/login',data)
                    .then(res => {
                        console.log(res.data)

                    }).catch(error => {
                    console.log(error)
                });
            }
            e.preventDefault();
        },
        validEmail: function (email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        },
        print() {
            const prtHtml = document.getElementById('printMe').innerHTML;

// Get all stylesheets HTML
            let stylesHtml = '';
            for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
                stylesHtml += node.outerHTML;
            }

// Open the print window
            const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');

            WinPrint.document.write(`<!DOCTYPE html>
                                    <html>
                                      <head>
                                        ${stylesHtml}
                                      </head>
                                      <body>
                                        ${prtHtml}
                                      </body>
                                    </html>`);
            WinPrint.document.close();
            WinPrint.focus();
            WinPrint.print();
            // WinPrint.close();
        }
    }

}
</script>

<style scoped>

</style>
