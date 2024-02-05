<template>
    <aside
        class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-trans-white"
        id="sidenav-main"
    >
        <div class="sidenav-header">
            <i
                class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true"
                id="iconSidenav"
            ></i>
            <a class="navbar-brand m-0" href="">
                <img
                    :src="addProjectPath('/front/assets/img/logo.png')"
                    alt=""
                    class="navbar-brand-img h-200"
                />
            </a>
        </div>
        <hr class="horizontal dark mt-0" />
        <div
            class="collapse navbar-collapse w-auto max-height-vh-100 h-100 overflow-Controller"
            id="sidenav-collapse-main"
        >
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link
                        exact-active-class="active"
                        to="/member/home"
                        class="nav-link"
                    >
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                        >
                            <i class="fab fa-dashcube"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </router-link>
                </li>
                <template v-if="role === 'Active'">
                    <li
                        class="nav-item d-flex align-items-center nav-menu-style"
                        @click="openPassDropDown"
                    >
                        <span class="pass">
                            <i
                                class="fab fa-app-store icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                            </i>
                        </span>
                        <span class="nav-items ms-1 mt-1 nav-menu-text"
                        >Gate Pass
                            <i
                                :class="{
                                    'fa fa-caret-down': !isNavVisiblePass,
                                    'fa fa-caret-up': isNavVisiblePass,
                                }"
                            ></i>
                        </span>
                    </li>
                    <transition name="slide-fade">
                        <li class="nav-sub-item" v-if="isNavVisiblePass">
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{ name: 'member-new-gate-pass' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1">Gate Pass Form</span>
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{ name: 'member-all-gate-pass' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >Gate Pass List</span
                                    >
                                </router-link>
                            </div>
                        </li>
                    </transition>

                    <!-- -------------------------------- -->

                    <li
                        class="nav-item d-flex align-items-center nav-menu-style"
                        @click="openTrainingDropDown"
                    >
                        <span class="tranning">
                            <i
                                class="fa fa-solid fa-clipboard-list icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                            </i>
                        </span>
                        <span class="nav-items ms-1 nav-menu-text"
                        >Tranning
                            <i
                                :class="{
                                    'fa fa-caret-down': !isNavVisibleTraining,
                                    'fa fa-caret-up': isNavVisibleTraining,
                                }"
                            ></i>
                        </span>
                    </li>
                    <transition name="slide-fade">
                        <li class="nav-sub-item" v-if="isNavVisibleTraining">
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{
                                    name: 'new_training_csa_for_member',
                                }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text"
                                    >New CSA Training</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    active-class="active"
                                    :to="{ name: 'all-csa-training_member' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All CSA Training</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{ name: 'new_training_dg_for_member' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >New DG Training</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    active-class="active"
                                    :to="{ name: 'all-dg-training_member' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All DG Training</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{
                                    name: 'new_training_other_for_member',
                                }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >New Other Training</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    active-class="active"
                                    :to="{ name: 'all-other-training_member' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All Other Training</span
                                    >
                                </router-link>
                            </div>
                        </li>
                    </transition>
                    <!-- -------------------------------- -->
                    <li
                        class="nav-item d-flex align-items-center nav-menu-style"
                        @click="openIdCardDropDown"
                    >
                        <span class="idcard">
                            <i
                                class="fa fa-solid fa-clipboard-list icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                            </i
                            ></span>
                        <span class="nav-items ms-1 mt-1 nav-menu-text"
                        >ID Card
                            <i
                                :class="{
                                    'fa fa-caret-down': !isNavVisibleIdCard,
                                    'fa fa-caret-up': isNavVisibleIdCard,
                                }"
                            ></i>
                        </span>
                    </li>
                    <transition name="slide-fade">
                        <li class="nav-sub-item" v-if="isNavVisibleIdCard">
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{ name: 'member-new-id-card' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >New ID Card</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{ name: 'member-all-id-card' }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All ID Card</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{
                                    name: 'cancel-id-card-panel-member',
                                }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All Cancelled ID Card</span
                                    >
                                </router-link>
                            </div>
                            <div>
                                <router-link
                                    exact-active-class="active"
                                    :to="{
                                    name: 'reissue-id-card-panel-member',
                                }"
                                    class="nav-link nav-links-color"
                                    style="
                                    color: #fff;
                                    justify-content: center;
                                    margin-bottom: 1px;
                                "
                                >
                                    <div class="icon icon-shape icon-sm shadow border-radius-xl bg-white text-center me-2 d-flex align-items-center justify-content-center"
                                    ><i class="fas fa-ellipsis-h"></i></div>
                                    <span class="nav-link-text ms-1"
                                    >All Reissued ID Card</span
                                    >
                                </router-link>
                            </div>
                        </li>
                    </transition>

                    <!-- -------------------------- -->

                    <li class="nav-item" v-if="false">
                        <router-link
                            exact-active-class="active"
                            :to="{ name: 'renew-member-for-member' }"
                            class="nav-link"
                        >
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                                <i class="fa fa-light fa-user"></i>
                            </div>
                            <span class="nav-link-text ms-1"
                            >Renew Membership</span
                            >
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            exact-active-class="active"
                            :to="{ name: 'all-renew-members-for-member' }"
                            class="nav-link"
                        >
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                                <i class="far fa-id-badge"></i>
                            </div>
                            <span class="nav-link-text ms-1"
                            >Renewal Status</span
                            >
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            exact-active-class="active"
                            :to="{ name: 'member_due_payment_for_member' }"
                            class="nav-link"
                        >
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <span class="nav-link-text ms-1">Due Payments</span>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link
                            exact-active-class="active"
                            :to="{ name: 'member-receipts' }"
                            class="nav-link"
                        >
                            <div
                                class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center"
                            >
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <span class="nav-link-text ms-1"
                            >Payment Receipt</span
                            >
                        </router-link>
                    </li>
                </template>
            </ul>
        </div>
    </aside>
</template>

<script>
export default {
    name: "Sidebar",
    data: () => ({
        role: "Pending",
        username: "",
        user: "",
        isNavVisiblePass: false,
        isNavVisibleTraining: false,
        isNavVisibleIdCard: false,
    }),
    created() {
        this.role = window.Laravel.user.status;
        this.user = window.Laravel.user;
        this.username = this.user.username;
        this.$emit("setUsername", { role: this.role, username: this.username });
        console.log("Saalam");
    },
    methods: {
        openPassDropDown() {
            this.isNavVisiblePass = !this.isNavVisiblePass;
            this.isNavVisibleTraining = false;
            this.isNavVisibleIdCard = false;
        },
        openTrainingDropDown() {
            this.isNavVisibleTraining = !this.isNavVisibleTraining;
            this.isNavVisibleIdCard = false;
            this.isNavVisiblePass = false;
        },
        openIdCardDropDown() {
            this.isNavVisibleIdCard = !this.isNavVisibleIdCard;
            this.isNavVisibleTraining = false;
            this.isNavVisiblePass = false;
        },
    },
};
</script>

<style scoped>
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
    //height: 110px;
    transition: all 0.25s ease;
}
.slide-fade-leave-active {
    //height: 110px;
    transition: all 0.25s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
    /*transform: translateY(0px);*/
    transform: scaleY(0);
    opacity: 0;
    //height: 0;
}
@media (min-width: 1200px) {
    .d-xl-none {
        background-color: red;
    }
}

.bg-trans-white {
    background-color: rgba(231, 233, 235, 0.9);
}

.navbar-vertical.navbar-expand-xs {
    top: 83px !important;
}

/* Drop Down Styles  ================================ */
.btn {
    margin-bottom: 1rem;
    letter-spacing: -0.025rem;
    text-transform: uppercase;
    background-position-x: 25%;
    background-size: 150%;
}

.dropdown {
    height: 70px;
    width: 80px;
    margin-left: 6%;
    margin-top: -21%;
}

.dropdown-item {
    margin-left: -10%;
}

.b-dropdown-item .nav-link-text {
    margin-left: -9%;
}

.id-dropdown {
    height: 70px;
    width: 120px;
    margin-left: 5%;
    margin-top: -19%;
}

.pass-dropdown {
    height: 70px;
    width: 120px;
    margin-left: 6%;
    margin-top: -18%;
}

.pass i {
    margin-left: 13%;
    margin-top: 6%;
    flex-direction: row;
}

.tranning i {
    margin-left: 13%;
    margin-top: -2%;
    flex-direction: row;
}

.idcard i {
    margin-left: 13%;
    margin-top: -2%;
    flex-direction: row;
}
.navShow {
    display: block;
}
.navHide {
    display: none;
}
.nav-menu-style {
    padding: 10px;
    padding-left: 28px;
    cursor: pointer;
}
.nav-menu-text {
    padding-left: 6px;
}
.nav-links-color {
    color:#68758F !important;
    background-color: #E8EAED; /* #F6F6F6; /* #a65a2a; */
    justify-content: left !important;
    //margin: 0 0 0 3rem !important;
}
.navbar-vertical .navbar-nav .nav-link.active {
    color: #344767;
    background-color: #fff;
}
.overflow-Controller {
    overflow: scroll;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* Internet Explorer/Edge */
}
.overflow-Controller::-webkit-scrollbar {
    display: none;
}
.navbar-vertical .navbar-nav>.nav-item .nav-link.active .icon {
    background-image: linear-gradient(310deg, #8392AB 0%, #8392AB 100%) !important;
}
.navbar-vertical .navbar-nav>.nav-sub-item .nav-link.active .icon {
    background-image: linear-gradient(310deg, #8392AB 0%, #8392AB 100%);
}
@media (min-width: 1200px)
.navbar-vertical .navbar-nav .nav-sub-item .nav-link .icon {
    padding: 10px;
}
.nav-sub-item{
    border: 1px dotted gray;
}
.nav-sub-item .icon i {
    font-size: 15px;
    color: #000;
}
.nav-sub-item .active .icon i {
    color: #fff;
}
</style>
