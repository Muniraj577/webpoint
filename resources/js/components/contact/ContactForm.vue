<template>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="contactModalLabel">{{
                    contact.id == null ? 'Add Contact' : 'Edit Contact'
                }}</h5>
            <button type="button" class="close" @click="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form ref="contactForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Full Name</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" v-model="contact.full_name" ref="contactPhone"
                                               class="form-control"
                                               id="fullName">
                                        <span class="require full_name text-danger" ref="full_name"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Email</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" v-model="contact.email" ref="contactEmail"
                                               class="form-control"
                                               id="email">
                                        <span class="require email text-danger" ref="email"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">Phone</label>
                                    </div>
                                    <div class="col-md-8">
                                        <vue-tel-input
                                            v-model="contact.phone"
                                            ref="phoneNumber"
                                            @on-input="onNumberChange"
                                            :key="contact.country_code"
                                            :defaultCountry="contact.country_code"
                                        ></vue-tel-input>
                                        <span class="require phone text-danger"
                                              ref="phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close">Close</button>
            <button type="button" ref="saveButton" @click="save" class="btn btn-primary">
                {{ contact.id == null ? 'Save Contact' : 'Update Contact' }}
            </button>
        </div>
    </div>
</template>
<script>
import {VueTelInput} from "vue-tel-input";
import 'vue-tel-input/vue-tel-input.css';
import {commonMixin} from "../../CommonMixin.js";

export default {
    name: 'ContactForm',

    props: [
        'closeModal',
        'bModal',
        'contact',
        'telOptions'
    ],
    mixins: [
        commonMixin,
    ],
    data() {
        return {
            changeNumber: false,
        }
    },
    components: {
        VueTelInput,
    },

    created() {
        this.stateName = "contact";
    },

    mounted() {
        this.changeNumber = false;
    },

    methods: {
        close() {
            this.closeModal();
            // this.$refs.contactForm.reset();
            this.resetForm();
            document.querySelectorAll('.require').forEach(element => element.style.display = 'none');
        },

        resetForm() {
            this.$refs.contactForm.reset();
        },

        onNumberChange(number, phoneObject) {
            this.changeNumber = true;
            if (
                this.changeNumber &&
                phoneObject.nationalNumber !== undefined &&
                phoneObject.nationalNumber.length >= 10
            ) {
                if (phoneObject.valid === false) {
                    this.$refs.saveButton.setAttribute("disabled", true);
                    const alertMessage = {
                        type: "danger",
                        message: "Phone number is invalid",
                    };
                    alert(alertMessage.message);
                } else {
                    this.$refs.saveButton.removeAttribute("disabled");
                    this.contact.phone = phoneObject.nationalNumber;
                    this.contact.dial_code = phoneObject.countryCallingCode;
                    this.contact.country_code = phoneObject.countryCode;
                }
            }
        },

        save() {
            this.saveFormData(this.contact, this.bModal, this.resetForm());
        }
    }
}
</script>
