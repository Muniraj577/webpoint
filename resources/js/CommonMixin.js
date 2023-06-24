export const commonMixin = {
    data() {
        return {
            stateName: 'common',
            hideModal: false,
        }
    },
    computed: {
        all: {
            get() {
                return this.$store.state[this.stateName].all;
            }
        },

        dataLength: {
          get(){
              return this.$store.state[this.stateName].dataLength;
          }
        },

        page:{
          get(){
              return this.$store.state[this.stateName].page;
          }
        },

        detail: {
            get() {
                return this.$store.state[this.stateName].detail;
            },
            set(value) {
                this.$store.commit(`${this.stateName}/setDetail`, value);
            }
        },

        model: {
            get() {
                return this.$store.state[this.stateName].model;
            }
        },

        query: {
            get() {
                return this.$store.state[this.stateName].query;
            }
        },
        modelData: {
            get() {
                return {};
            },
            set(value) {
                this.$store.commit(`${this.stateName}/setModalData`, value);
            }
        }
    },

    methods: {
        fetchData() {
            this.$store.dispatch(`${this.stateName}/fetchData`);
        },

        fetchDetail(id) {
            this.$store.dispatch(`${this.stateName}/fetchDetail`, id);
        },

        saveFormData(formdata, modal = null, formRef = null) {
            this.modelData = formdata;
            let url = `${this.stateName}/store`;
            if (formdata.id !== undefined && formdata.id !== null){
                url = `${this.stateName}/update`;
            }
            this.$store.dispatch(url, formdata.id)
                .then(res => {
                    toastr.success(res.data.message);
                    if (modal !== null && modal instanceof bootstrap.Modal) {
                        modal.hide();
                    }
                    if (formRef !== null) {
                        formRef();
                    }
                    this.fetchData();
                })
                .catch(err => {
                    if (err.response) {
                        console.log(err.response)
                        const response = err.response.data;
                        if (Object.keys(response.errors).length > 0) {
                            $(".require").css('display', 'none');
                            Object.entries(response.errors).forEach(([key, value]) => {
                                this.$nextTick(() => {
                                    if (this.$refs[key] !== undefined) {
                                        let inputElement = this.$refs[key][0];
                                        if (this.$refs[key][0] === undefined) {
                                            inputElement = this.$refs[key];
                                        }
                                        inputElement.innerHTML = value;
                                        inputElement.style.display = 'block';
                                    }
                                });
                            });
                        }
                    }
                })
        }
    }
}
