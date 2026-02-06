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

<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.js"></script>


<!-- SweetAlert2 -->
<script src="{{ asset('assets/admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Main App Script -->
<script src="{{ asset('assets/user/js/app.js') }}"></script>

<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
<script src="{{asset('assets/admin/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- sortablejs -->
<script src="{{asset('assets/admin/libs/sortablejs/Sortable.min.js')}}"></script>

<!-- nestable init js -->
<script src="{{asset('assets/admin/js/pages/nestable.init.js')}}"></script>

<script src="{{asset('assets/admin/libs/flatpickr/flatpickr.min.js')}}"></script>

<!-- ================== End JavaScript Files ================== -->

<!-- PWA Install Banner -->
<!-- PWA Install Popup (Centered) -->
<div id="pwa-install-banner" class="fixed inset-0 z-[9999] hidden flex-col items-center justify-center bg-black/60 backdrop-blur-sm p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm text-center relative border border-gray-100">
        <div class="mx-auto bg-white shadow-md w-20 h-20 rounded-2xl flex items-center justify-center mb-5 -mt-16 border-4 border-white">
             <img src="{{ asset('assets/logo/logo.png') }}" class="w-14 h-14 object-contain" alt="App Logo">
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Install Mystery Visits</h3>
        <p class="text-gray-500 mb-6 text-sm leading-relaxed">Add this app to your home screen for a faster and better experience.</p>
        <div class="flex flex-col gap-3">
            <button id="pwa-install-btn" class="w-full py-3.5 px-4 bg-[#0073AF] hover:bg-[#005f8f] text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                Install Button
            </button>
            <button id="pwa-dismiss-btn" class="text-gray-400 hover:text-gray-600 font-medium text-sm py-2">
                Maybe later
            </button>
        </div>
    </div>
</div>

<script>
    // PWA Installation Logic
    let deferredPrompt;
    const addBtn = document.getElementById('pwa-install-btn');
    const dismissBtn = document.getElementById('pwa-dismiss-btn');
    const pwaBanner = document.getElementById('pwa-install-banner');

    console.log('PWA Script loaded');

    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('beforeinstallprompt fired');
        e.preventDefault();
        deferredPrompt = e;
        
        // Prevent PWA on Admin routes
        const currentUrl = window.location.href;
        if(currentUrl.includes('/admin') || currentUrl.includes('127.0.0.1')) {
             console.log('PWA disabled for admin or localhost loopback');
             return;
        }

        // Check if user has dismissed the popup
        if(localStorage.getItem('pwa_popup_dismissed') === 'true'){
             console.log('PWA popup previously dismissed');
             return;
        }

        pwaBanner.classList.remove('hidden');
        pwaBanner.style.display = 'flex';
    });

    if(addBtn){
        addBtn.addEventListener('click', (e) => {
            pwaBanner.style.display = 'none';
            if(deferredPrompt){
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    console.log('User choice:', choiceResult.outcome);
                    deferredPrompt = null;
                });
            }
        });
    }

    if(dismissBtn){
        dismissBtn.addEventListener('click', (e) => {
            pwaBanner.style.display = 'none';
            localStorage.setItem('pwa_popup_dismissed', 'true');
        });
    }

    // Only register Service Worker if NOT on localhost/127.0.0.1 and NOT on Admin paths
    if ('serviceWorker' in navigator) {
        const isLocalhost = window.location.hostname === '127.0.0.1' || window.location.hostname === 'localhost';
        const isAdminIdx = window.location.href.indexOf('/admin');
        
        if (!isLocalhost && isAdminIdx === -1) {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function(reg) {
                    console.log('Service Worker registered', reg);
                })
                .catch(function(err) {
                     console.error('Service Worker error', err);
                });
        } else {
             // If we are on localhost or admin, try to unregister to clean up
             navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for(let registration of registrations) {
                    registration.unregister();
                }
             });
             console.log('PWA Service Worker restricted on Localhost/Admin');
        }
    }
</script>
