<!-- ================== JavaScript Files ================== -->

<!-- jQuery & Validation -->
<script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>

<!-- jQuery Validate Localization -->
<script>
    // Set jQuery Validate default messages based on current language
    if (typeof jQuery !== 'undefined' && jQuery.validator) {
        jQuery.extend(jQuery.validator.messages, {
            required: "{{ trans_message('field_required') }}",
            email: "{{ trans_message('email_valid') }}",
            url: "{{ trans_message('url_valid') }}",
            date: "{{ trans_message('date_valid') }}",
            dateISO: "{{ trans_message('date_iso_valid') }}",
            number: "{{ trans_message('number_valid') }}",
            digits: "{{ trans_message('digits_valid') }}",
            creditcard: "{{ trans_message('creditcard_valid') }}",
            equalTo: "{{ trans_message('equal_to') }}",
            maxlength: jQuery.validator.format("{{ trans_message('maxlength_valid') }}"),
            minlength: jQuery.validator.format("{{ trans_message('minlength_valid') }}"),
            rangelength: jQuery.validator.format("{{ trans_message('rangelength_valid') }}"),
            range: jQuery.validator.format("{{ trans_message('range_valid') }}"),
            max: jQuery.validator.format("{{ trans_message('max_valid') }}"),
            min: jQuery.validator.format("{{ trans_message('min_valid') }}")
        });
    }
</script>


<!-- SweetAlert2 -->
<script src="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Main App Script -->
<script src="{{ asset('assets/user/js/app.js') }}"></script>

<!-- ================== End JavaScript Files ================== -->
