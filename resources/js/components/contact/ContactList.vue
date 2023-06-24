<template>
    <div class="card-body">
        <div class="row card-title col-md-9 float-right">
            <div class="col-5">
                <input type="text" v-model="title" class="form-control" placeholder="Search by name">
            </div>
            <div class="col-4">
                <button class="btn btn-block btn-primary" @click="search">Search</button>
            </div>
        </div>
        <table class="table table-responsive-xl">
            <thead>
            <tr>
                <th>S.N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th class="hidden">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(contact, index) in all.data" :key="index">
                <td>{{ contact.serial_number }}</td>
                <td>{{ contact.full_name }}</td>
                <td>{{ contact.email }}</td>
                <td>{{ contact.phone }}</td>
                <td>
                    <div class="d-inline-flex">
                        <a href="javascript:void(0);" @click="showModal(contact.id)"
                           class="btn blue btn-sm" title="Edit Contact">
                            <i class="fa fa-edit iCheck"></i>
                        </a>
                        <a href="javascript:void(0);" @click="deleteContact(contact.id)"
                           class="btn red btn-sm" title="Delete Contact">
                            <i class="fa fa-trash iCheck"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <tr v-if="all.data?.length === 0">
                No results found
            </tr>
            </tbody>
        </table>
        <div class="pagination_div">
            <div class="pagination-centered">
                <Bootstrap4Pagination :data="all" :limit="2" @pagination-change-page="fetchContact"/>
            </div>
        </div>
    </div>
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog"
         aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <ContactForm ref="contactModal" :telOptions="telOptions" :contact="contact" :closeModal="closeModal"
                         :bModal="myModal"/>
        </div>
    </div>
</template>
<script>
import {commonMixin} from "../../CommonMixin.js";
import ContactForm from "./ContactForm.vue";
import {mapGetters} from "vuex";
import {apiClient} from "../../services/Api.js";
import {Bootstrap4Pagination} from "laravel-vue-pagination";

export default {
    name: "ContactList",

    mixins: [
        commonMixin,
    ],

    components: {
        ContactForm,
        Bootstrap4Pagination,
    },

    data() {
        return {
            myModal: null,
            modalInstance: false,
            title: null,
            contact: {
                id: null,
                full_name: null,
                email: null,
                phone: null,
                dial_code: null,
                country_code: null,
            },
            telOptions: {
                autoFormat: true,
                defaultCountry: "",
                dropdownOptions: {
                    showFlags: true,
                    showDialCode: true,
                    showDialCodeInList: true,
                    tabindex: 0,
                    ignoredCountries: [],
                },
                inputOptions: {
                    autocomplete: "on",
                    "aria-describedby": "",
                    id: "",
                    maxlength: 25,
                    name: "telephone",
                    placeholder: "Enter a phone number",
                    tabindex: 0,
                    type: "tel",
                },
                mode: "auto",
            },
        }
    },

    created() {
        this.stateName = 'contact';
    },

    computed: {
        ...mapGetters('contact', ['detail']),
    },

    mounted() {
        window.test = this;
        this.myModal = new bootstrap.Modal(document.getElementById('contactModal'));
        this.fetchContact();
    },

    methods: {
        fetchContact(page = 1) {
            this.$store.commit('contact/setPage', page);
            this.fetchData();
        },
        search() {
            this.$store.commit('contact/setQuery', this.title)
            this.$store.commit('contact/setPage', 1)
            this.$store.dispatch('contact/fetchData').then((res) => {
                let dataLen = res.data.data.length;
                if (dataLen === 0) {
                    alert('No results found. Add a new user.')
                }
            }).catch(err => {
                console.log(err);
            })
        },
        closeModal() {
            this.myModal.hide();
            this.resetContact();
        },

        deleteContact(id) {
            let c = confirm('Are you sure?')
            if (c == false) {
                toastr.error('You denied the delete operation.')
            } else {
                apiClient.delete(`contact/delete/${id}`).then(res => {
                    toastr.error(res.data.message);
                    this.fetchData();
                }).catch(err => {
                    toastr.error(err);
                })
            }
        },

        showModal(id = null) {
            if (id !== null) {
                apiClient.get(`contact/detail/${id}`).then(res => {
                    let detail = res.data.data;
                    this.contact = {
                        id: detail.id,
                        full_name: detail.full_name,
                        email: detail.email,
                        phone: detail.phone,
                        dial_code: detail.dial_code,
                        country_code: detail.country_code,
                    };
                })

                this.modalInstance = true;
                this.myModal.show();

                // this.fetchDetail(id);
                // this.contact = {
                //     full_name: this.detail.full_name,
                //     email: this.detail.email,
                //     phone: this.detail.phone,
                //     dial_code: this.detail.dial_code,
                //     country_code: this.detail.country_code,
                // };
            } else {
                this.modalInstance = true;
                this.myModal.show();
            }
        },

        resetContact() {
            this.contact = {
                full_name: null,
                email: null,
                dial_code: null,
                country_code: null,
            }
        },

        getContactDetail(id) {
            this.fetchDetail(id);
        }
    }

}
</script>
