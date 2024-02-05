<template>
    <table class="table table-borderless table-striped" v-if="false">
        <thead>
        <tr>
            <th class="min-width-80">Master Airway bill No.</th>
            <th class="min-width-80">Registration Date</th>
            <th class="text-center min-width-150">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="member in members">
            <td class="align-middle">
                <a href="">
                    {{ member.master_airway_bill_no }}
                </a>
            </td>
            <td class="align-middle">{{ member.created_at }}</td>
            <td class="text-center align-middle">
                <div class="dropdown show d-inline-block">
                    <a class="btn btn-icon"
                       href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a href="" class="dropdown-item text-gray-500">
                            <i class="fas fa-eye mr-2"></i>
                            View User
                        </a>
                    </div>
                </div>
                <a href=""
                   class="btn btn-icon edit"
                   title="Edit User"
                   data-toggle="tooltip" data-placement="top">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-icon" @click="deleteMember(member.id)"
                        data-toggle="tooltip" data-placement="top"
                        title="Delete"
                ><i class="fas fa-trash"></i></button>
                <b-button v-if="!member.payment"
                          v-b-modal.modal-make-payment
                          @click="sendInfo(member.bmn)"
                          variant="icon"
                          title="Create payment"
                          data-toggle="tooltip" data-placement="top"
                ><i class="fas fa-money-bill-alt text-success"></i>
                </b-button>
                <router-link v-if="member.payment"
                             :to="{name: 'gate-pass-invoice',params: { id: member.id }}"
                             class="btn btn-icon"
                             title="Invoice" target="_blank"
                             data-toggle="tooltip" data-placement="top"
                ><i class="fas fa-download"></i>
                </router-link>
                <router-link v-if="member.payment" :disabled="!member.print_times"
                             :to="{name: 'gate-pass-print',params: { id: member.id }}" target="_blank"
                             class="btn btn-icon"
                             title="Print"
                             data-toggle="tooltip" data-placement="top"
                ><i class="fas fa-eye" v-bind:class="{ 'text-danger': !member.print_times }"></i>
                </router-link>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "Temp"
}
</script>
