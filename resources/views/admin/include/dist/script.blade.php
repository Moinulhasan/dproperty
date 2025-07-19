
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>


<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>

<!-- Main JS -->

<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<!-- Page JS -->
{{--<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>--}}
<script src="{{asset('assets/js/main.js')}}"></script>


<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/js/form-layouts.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

<!-- Page JS -->
<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
<script src="{{asset('assets/vendor/libs/pickr/pickr.js')}}"></script>
<script src="{{asset('assets/js/forms-pickers.js')}}"></script>
<!-- Main JS -->
<script src="{{asset('assets/custom/method.js')}}"></script>
<!-- Page JS -->
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

<script>
    function SwalLoader() {
        var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';
        Swal.fire({
            html: '<h5>Loading...</h5>',
            showConfirmButton: false,
            onRender: function() {
                // there will only ever be one sweet alert open.
                $('.swal2-content').prepend(sweet_loader);
            }
        });
    }

    function SwalSuccess() {
        Swal.fire({
            icon: 'success',
            title: 'Company Added Successfully',
            timer: 2000,
            showConfirmButton: false,
        });
    }

    function SwalFail($msg = 'Something went wrong') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: $msg,
        });
    }

    function SwalWarning($msg = 'warning') {
        Swal.fire({
            icon: 'warning',
            title: $msg,
            showConfirmButton: false,
            timer: 3000,
        });
    }

    setInterval(function() {
        $('.alert').hide(); // show next div
    }, 7000);
</script>

