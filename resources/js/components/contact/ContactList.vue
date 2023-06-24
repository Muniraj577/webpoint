<template>
    <div class="card-body">
        <table id="Admin" class="table table-responsive-xl">
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
            <tr v-for="(contact, index) in all" :key="index">
                <td>{{ contact.id }}</td>
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
            </tbody>
        </table>
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

export default {
    name: "ContactList",

    mixins: [
        commonMixin,
    ],

    components: {
        ContactForm
    },

    data() {
        return {
            myModal: null,
            modalInstance: false,
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
        this.fetchData();
    },

    methods: {
        closeModal() {
            this.myModal.hide();
            this.resetContact();
        },

        deleteContact(id) {
            let c = confirm('Are you sure?')
            if (c == false) {
                alert('You denied')
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
                    this.$nextTick(() => {
                        this.telOptions = {
                            ...this.telOptions,
                            defaultCountry: detail.country_code,
                        };
                    })

                    this.modalInstance = true;
                    this.myModal = new bootstrap.Modal(document.getElementById('contactModal'));
                    this.myModal.show();
                })

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
                this.myModal = new bootstrap.Modal(document.getElementById('contactModal'));
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
