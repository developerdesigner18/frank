<script type="text/javascript">
    var url = '{{ asset('/') }}'
</script>

<script src="{{asset('assets/js/jquery-3.6.0.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.js')}}"></script>

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

<script src="{{asset('assets/admin_new/js/app.js')}}"></script>

<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
<script src="{{asset('assets/admin/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>


<!-- sortablejs -->
<script src="{{asset('assets/admin/libs/sortablejs/Sortable.min.js')}}"></script>

<!-- nestable init js -->
<script src="{{asset('assets/admin/js/pages/nestable.init.js')}}"></script>

<script src="{{asset('assets/admin/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.js"></script>

<script src="{{asset('assets/admin/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>

<script src="{{asset('assets/admin/js/pages/form-editor.init.js')}}"></script>

{{--TODO :: need to add js as we use plugins--}}

<script>
    // Force Unregister Service Worker for Admin pages to avoid PWA behaviors
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister();
                console.log('Service Worker unregistered for Admin');
            }
        });
    }
</script>
