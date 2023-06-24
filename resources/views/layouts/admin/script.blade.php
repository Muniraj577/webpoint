<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets/admin/dist/js/adminlte.js') }}"></script>
<script src="{{ asset('assets/admin/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/admin/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/nepali.datepicker.min.js') }}"></script>

@vite(['resources/js/app.js'])

<script>
    var update = function () {
        document.getElementById("display_time")
            .innerHTML = moment().format('YYYY-MM-DD h:mm a');
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function neptoeng(nep_class, id_name) {
        var mainInput = document.getElementsByClassName(nep_class);
        mainInput.nepaliDatePicker({
            language: "english",
            onChange: function() {
                let nepalidate = $("." + nep_class).val();
                let dateObj = NepaliFunctions.ParseDate(nepalidate);
                let engDate = NepaliFunctions.BS2AD(dateObj.parsedDate);
                let year = engDate.year;
                let month = NepaliFunctions.Get2DigitNo(engDate.month);
                let day = NepaliFunctions.Get2DigitNo(engDate.day);
                let engValue = year + '-' + month + '-' + day;
                $("#" + id_name).val(engValue);
            },
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });
    }

    function engtonep(this_date, idName) {
        console.log('heu', idName)
        let dateTime = $(this_date).val();
        // console.log(dateTime);
        // newDateTime = getFormattedDate(dateTime);
        if (dateTime) {
            let dateObj = new Date(dateTime);
            // let dateObj = getFormattedDate(dateTime);
            // console.log(dateObj);
            let year = dateObj.getUTCFullYear();
            let month = dateObj.getUTCMonth() + 1;
            let day = dateObj.getUTCDate(); // + 1 for 'dd-mm-yyyy'
            let nepaliDate = NepaliFunctions.AD2BS({
                year: year,
                month: month,
                day: day
            });
            let nepaliYear = nepaliDate.year;
            let nepaliMonth = ("0" + nepaliDate.month).slice(-2);
            let nepaliDay = ("0" + nepaliDate.day).slice(-2);
            let nepaliValue = nepaliYear + '-' + nepaliMonth + '-' + nepaliDay;
            $("#" + idName).val(nepaliValue);
        } else {
            $("#" + idName).val('');
        }

    }

    function showImg(img, previewId) {
        readInputURL(img, previewId);
    }

    function readInputURL(input, idName) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#" + idName).attr('src', e.target.result).width(100).height(100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function dataTablePosition() {
        $('.buttons-collection').detach().appendTo('.dataTables_filter');
    }


    var today = new Date();
    var today_date = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today
        .getDate()).slice(-2);
    $(document).ready(function () {
        setInterval(update, 1000);
        $(".alert-warning").css('display', 'none');
        $(".select2").select2();
    });


    function deleteData($_id, $_action) {
        $.ajax({
            url: $_action,
            type: 'POST',
            data: {'id': $_id, '_method': 'DELETE'},
            success: function (data) {
                if (data.error) {
                    toastr.warning(data.error);
                } else if (data.db_error) {
                    toastr.warning(data.db_error);
                } else if (!data.error && !data.db_error) {
                    toastr.success(data.msg);
                    if (data.redirectRoute) {
                        location.href = data.redirectRoute;
                    }
                }

            },
            error: function (xhr) {
                console.log(xhr.responseJSON);
            }
        });
    }

    function onlynumbers(event) {

        let key = window.event ? event.keyCode : event.which;
        // event.keyCode == 39 (is for single quote)
        // event.keyCode == 37 for decimal
        if (event.keyCode == 8 || event.keyCode == 46 ||
            event.keyCode == 37) {
            return true;
        } else if (key < 48 || key > 57) {
            return false;
        } else return true;

    }

    function onpasteString(event) {
        if (event.clipboardData.getData('Text').match(/[^\d]/)) {
            event.preventDefault();
            $.alert({
                title: 'Alert !',
                content: 'Only numbers can be pasted',
                icon: 'fa fa-exclamation-triangle',
                theme: 'modern',
            });
        }
    }

    function datepicker(idName) {
        console.log('elo');
        $("#" + idName).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            clearBtn: true
        });
    }

</script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-container",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if (Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@yield('scripts')
