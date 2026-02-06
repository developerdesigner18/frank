@if(!request()->is('admin') && !request()->is('admin/*'))
    <div id="ios-install-prompt" class="hidden fixed bottom-[calc(1.5rem+env(safe-area-inset-bottom))] left-4 right-4 md:left-1/2 md:right-auto md:w-[340px] md:-translate-x-1/2 z-[9999] font-sans" style="display: none;">

        <!-- Bubble Container -->
        <div class="relative bg-[#e5e7eb] border border-gray-300 p-4 rounded-xl shadow-xl">
            
            <!-- Close Button -->
            <button onclick="dismissInstallPrompt()" class="absolute -top-2 -right-2 bg-gray-400 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-sm hover:bg-gray-500 transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>

            <!-- Content -->
            <div class="flex flex-col items-start">
                <p class="text-[15px] text-gray-800 leading-snug font-medium">
                    Install this web app on your iPhone: tap 
                    <span class="inline-flex items-center mx-0.5 align-bottom">
                         <!-- Standard iOS Share Icon -->
                        <svg class="w-5 h-5 text-[#007aff]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4V15M12 4L8 8M12 4L16 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 15V15C2 18.866 5.13401 22 9 22H15C18.866 22 22 18.866 22 15V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    and then <br>
                    <span class="font-bold text-gray-900">Add to Home Screen</span>.
                </p>

                <button onclick="dismissInstallPrompt()" class="mt-3 text-xs text-gray-500 hover:text-gray-700 font-medium underline decoration-gray-400/50 underline-offset-2 self-center">
                    Maybe later
                </button>
            </div>

            <!-- Arrow pointing down -->
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-5 h-5 bg-[#e5e7eb] rotate-45 border-r border-b border-gray-300"></div>
        </div>

    </div>

    <script>
        function isIos() {
            const ua = navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test(ua);
        }

        function isSafari() {
            return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        }

        function isInStandaloneMode() {
            return ('standalone' in window.navigator) && window.navigator.standalone;
        }

        function shouldShowInstallPrompt() {
            if (localStorage.getItem('ios_install_prompt_dismissed')) {
                return false;
            }
            return isIos() && isSafari() && !isInStandaloneMode();
        }

        function dismissInstallPrompt() {
            localStorage.setItem('ios_install_prompt_dismissed', 'true');
            const prompt = document.getElementById('ios-install-prompt');
            prompt.classList.remove('animate-slide-up');
            prompt.classList.add('animate-fade-out');
            setTimeout(() => {
                prompt.style.display = 'none';
            }, 300);
        }
        
        // Force hide other PWA prompts on iOS
        function hideGenericPwaBanner() {
            const genericBanner = document.getElementById('pwa-install-banner');
            if (genericBanner) {
                genericBanner.style.setProperty('display', 'none', 'important');
                genericBanner.classList.add('hidden');
                genericBanner.innerHTML = ''; // Nuke content to be sure
            }
             // Helper to hide all modals if possible
             const potentialModals = document.querySelectorAll('.fixed.inset-0.z-\\[9999\\]');
             potentialModals.forEach(el => {
                 if (el.id !== 'ios-install-prompt' && el.innerHTML.includes('Install')) {
                      el.style.display = 'none';
                 }
             });
        }

        document.addEventListener('DOMContentLoaded', function () {
            
            if (isIos()) {
                hideGenericPwaBanner();
                // Watch for changes to ensure it stays hidden
                const observer = new MutationObserver(() => hideGenericPwaBanner());
                observer.observe(document.body, { childList: true, subtree: true });
                
                if (shouldShowInstallPrompt()) {
                    const prompt = document.getElementById('ios-install-prompt');
                    // Delay showing slightly for better UX
                    setTimeout(() => {
                        prompt.classList.remove('hidden');
                        prompt.style.display = 'block';
                        prompt.classList.add('animate-slide-up');
                    }, 1000);
                }
            }
        });
    </script>

    <style>
        .animate-slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        .animate-fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translate(0, 20px);
            }
            to {
                opacity: 1;
                transform: translate(0, 0);
            }
        }
        @media (min-width: 768px) {
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translate(-50%, 20px);
                }
                to {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(10px);
            }
        }
    </style>
@endif
