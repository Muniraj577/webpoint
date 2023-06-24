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
            <tr v-for="(user, index) in all" :key="index">
                <td>{{ user.id }}</td>
                <td>{{ user.full_name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.phone }}</td>
                <td>
                    <div class="d-inline-flex">
                        <a href="javascript:void(0);" @click="showModal(user.id)"
                           class="btn blue btn-sm" title="Edit Contact">
                            <i class="fa fa-edit iCheck"></i>
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
            <ContactForm ref="contactModal" :contact="contact" :closeModal="closeModal" :bModal="myModal"/>
        </div>
    </div>
</template>
<script>
import {commonMixin} from "../../CommonMixin.js";
import ContactForm from "./ContactForm.vue";
import {mapGetters} from "vuex";

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
        this.getContactDetail(1)
    },

    methods: {
        closeModal() {
            this.myModal.hide();
            this.resetContact();
        },

        showModal(id = null) {
            if (id !== null) {
                this.fetchDetail(id);
                this.contact = {
                    id: this.detail.id,
                    full_name: this.detail.full_name,
                    email: this.detail.email,
                    phone: this.detail.phone,
                    dial_code: this.detail.dial_code,
                    country_code: this.detail.country_code,
                };
            }
            this.modalInstance = true;
            this.myModal = new bootstrap.Modal(document.getElementById('contactModal'));
            this.myModal.show();
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
