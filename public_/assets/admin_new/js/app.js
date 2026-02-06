const toggleBtn = document.querySelector(".toggle-btn");
const aside = document.querySelector(".el-aside");
const closeBtn = document.querySelector(".el-aside-logo-close");

// Enhanced sidebar toggle with smooth animations
toggleBtn.addEventListener("click", function () {
  if (window.innerWidth >= 992) {
    // Desktop: toggle with smooth animation
    if (aside.style.display === "none" || getComputedStyle(aside).display === "none") {
      aside.style.display = "block";
    } else {
      setTimeout(() => {
        aside.style.display = "none";
      }, 300);
    }
  } else {
    // Mobile/Tablet: toggle offcanvas slide
    aside.classList.toggle("show");
    
    // Add backdrop for mobile
    if (aside.classList.contains("show")) {
      const backdrop = document.createElement("div");
      backdrop.className = "sidebar-backdrop fixed inset-0 bg-black/50 z-[999]";
      backdrop.addEventListener("click", () => {
        aside.classList.remove("show");
        backdrop.remove();
      });
      document.body.appendChild(backdrop);
    } else {
      const backdrop = document.querySelector(".sidebar-backdrop");
      if (backdrop) backdrop.remove();
    }
  }
})

// Enhanced close button functionality
closeBtn.addEventListener("click", function () {
  if (window.innerWidth >= 992) {
    // Desktop: animate out
    aside.style.transition = "all 0.3s cubic-bezier(0.4, 0, 0.2, 1)";
    aside.style.transform = "translateX(-100%)";
    aside.style.opacity = "0";
    
    setTimeout(() => {
      aside.style.display = "none";
    }, 300);
  } else {
    // Mobile/Tablet: remove show class
    aside.classList.remove("show");
    const backdrop = document.querySelector(".sidebar-backdrop");
    if (backdrop) backdrop.remove();
  }
})

// Tab functionality
/*document.addEventListener('DOMContentLoaded', function() {
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabPanes = document.querySelectorAll('.tab-pane');

  tabButtons.forEach(button => {
    button.addEventListener('click', function() {
      const targetTab = this.getAttribute('data-tab');
      
      // Remove active class from all buttons
      tabButtons.forEach(btn => {
        btn.classList.remove('bg-[#0073AF]', 'text-white', 'active');
        btn.classList.add('text-gray-600');
      });
      
      // Add active class to clicked button
      this.classList.add('bg-[#0073AF]', 'text-white', 'active');
      this.classList.remove('text-gray-600');
      
      // Hide all tab panes
      tabPanes.forEach(pane => {
        pane.classList.add('hidden');
      });
      
      // Show target tab pane
      const targetPane = document.getElementById(`tab-${targetTab}`);
      if (targetPane) {
        targetPane.classList.remove('hidden');
      }
    });
  });
});*/

document.addEventListener('DOMContentLoaded', function () {
    // Loop through each modern-card section
    document.querySelectorAll('.modern-card').forEach(card => {
        const tabButtons = card.querySelectorAll('.tab-btn');
        const tabPanes = card.querySelectorAll('.tab-pane');

        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');

                // Remove active class from all buttons inside this card
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-[#0073AF]', 'text-white', 'active');
                    btn.classList.add('text-gray-600');
                });

                // Add active class to clicked button
                this.classList.add('bg-[#0073AF]', 'text-white', 'active');
                this.classList.remove('text-gray-600');

                // Hide all tab panes inside this card
                tabPanes.forEach(pane => pane.classList.add('hidden'));

                // Show target tab pane (inside same card)
                const targetPane = card.querySelector(`#tab-${targetTab}`);
                if (targetPane) targetPane.classList.remove('hidden');
            });
        });
    });
});




    // Enhanced Tab functionality for notifications using Tailwind CSS
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        const unreadNotificationHandler = document.getElementById('markAllReadBtn');

        // Active tab classes for Tailwind
        const activeTabClasses = 'bg-[#0073AF] text-white shadow-sm';
        const inactiveTabClasses = 'text-gray-700 font-medium';

        // Tab switching functionality
        tabButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetTab = this.getAttribute('data-tab');

                // Remove active classes from all buttons and add inactive classes
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-[#0073AF]', 'text-white', 'shadow-sm');
                    btn.classList.add('text-gray-700', 'hover:bg-gray-200');
                });

                // Add active classes to clicked button
                this.classList.remove('text-gray-700', 'hover:bg-gray-200');
                this.classList.add('bg-[#0073AF]', 'text-white', 'shadow-sm');

                // Hide all tab contents with smooth transition
                tabContents.forEach(content => {
                    content.classList.add('hidden', 'opacity-0');
                    content.classList.remove('opacity-100');
                });

                // Show target tab content with smooth transition
                const targetContent = document.getElementById(`tab-${targetTab}`);
                if (targetContent) {
                    targetContent.classList.remove('hidden');
                    // Trigger reflow for smooth transition
                    targetContent.offsetHeight;
                    targetContent.classList.remove('opacity-0');
                    targetContent.classList.add('opacity-100');
                }
            });
        });

        // Enhanced Mark all as read functionality
        unreadNotificationHandler.addEventListener('click', function () {
            // Find all unread notifications (blue background)
            const unreadNotifications = document.querySelectorAll('.bg-blue-50\\/50');

            if (unreadNotifications.length === 0) {
                // Show message if no unread notifications
                this.textContent = 'No unread notifications!';
                this.classList.add('text-gray-500');
                setTimeout(() => {
                    this.textContent = 'Mark all as read';
                    this.classList.remove('text-gray-500');
                }, 2000);
                return;
            }

            // Add loading state
            const originalText = this.textContent;
            this.textContent = 'Marking...';
            this.classList.add('opacity-75', 'cursor-not-allowed');

            // Simulate processing delay for better UX
            setTimeout(() => {
                unreadNotifications.forEach((notification, index) => {
                    setTimeout(() => {
                        // Change background to white with smooth transition
                        notification.classList.remove('bg-blue-50/50', 'border-blue-100');
                        notification.classList.add('bg-white', 'border-gray-200');

                        // Remove blue dot indicator
                        const dot = notification.querySelector('.bg-blue-500');
                        if (dot) {
                            dot.classList.remove('bg-blue-500');
                            dot.classList.add('bg-transparent');
                        }

                        // Change icon background to gray
                        const iconContainer = notification.querySelector('.bg-blue-100');
                        if (iconContainer) {
                            iconContainer.classList.remove('bg-blue-100');
                            iconContainer.classList.add('bg-gray-100');
                        }

                        // Change icon color to gray
                        const icon = notification.querySelector('.text-blue-500');
                        if (icon) {
                            icon.classList.remove('text-blue-500');
                            icon.classList.add('text-gray-500');
                        }

                        // Change archive button to unarchive
                        const archiveBtn = notification.querySelector('.material-icons');
                        if (archiveBtn && archiveBtn.textContent === 'archive') {
                            archiveBtn.textContent = 'unarchive';
                        }

                        // Add subtle animation
                        notification.classList.add('transform', 'transition-all', 'duration-300');
                        notification.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            notification.style.transform = 'scale(1)';
                        }, 150);

                    }, index * 100); // Stagger the animations
                });

                // Reset button state
                setTimeout(() => {
                    this.textContent = 'All marked as read!';
                    this.classList.remove('opacity-75', 'cursor-not-allowed');
                    this.classList.add('text-green-600');

                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('text-green-600');
                    }, 2000);
                }, unreadNotifications.length * 100 + 500);

            }, 300);
        });

        // Add hover effects for notification items
        const notificationItems = document.querySelectorAll('.flex.items-start.justify-between.p-4');
        notificationItems.forEach(item => {
            item.classList.add('transition-all', 'duration-200', 'hover:shadow-md', 'hover:-translate-y-0.5', 'cursor-pointer');
        });
    });

    // Enhanced card interactions
    // const modernCards = document.querySelectorAll('.modern-card');
    // modernCards.forEach(card => {
    //     // Add ripple effect on click
    //     card.addEventListener('click', function(e) {
    //         const ripple = document.createElement('span');
    //         const rect = this.getBoundingClientRect();
    //         const size = Math.max(rect.width, rect.height);
    //         const x = e.clientX - rect.left - size / 2;
    //         const y = e.clientY - rect.top - size / 2;
    //
    //         ripple.style.cssText = `
    //             position: absolute;
    //             width: ${size}px;
    //             height: ${size}px;
    //             left: ${x}px;
    //             top: ${y}px;
    //             background: rgba(14, 165, 233, 0.1);
    //             border-radius: 50%;
    //             transform: scale(0);
    //             animation: ripple 0.6s linear;
    //             pointer-events: none;
    //         `;
    //
    //         this.appendChild(ripple);
    //
    //         setTimeout(() => {
    //             ripple.remove();
    //         }, 600);
    //     });
    // });

    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Enhanced form interactions
    const modernInputs = document.querySelectorAll('.modern-input, .modern-select');
    modernInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Add loading states to buttons
    const primaryButtons = document.querySelectorAll('.btn-primary');
    primaryButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // if (this.type === 'submit') {
            //     const originalText = this.textContent;
            //     this.innerHTML = `
            //         <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            //             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            //             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            //         </svg>
            //         Processing...
            //     `;
            //     this.disabled = true;
            //
            //     // Simulate processing
            //     setTimeout(() => {
            //         this.innerHTML = originalText;
            //         this.disabled = false;
            //     }, 2000);
            // }
        });
    });


        // Image upload functionality
    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profileImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Language selection functionality
    function selectLanguage(lang) {
        const buttons = document.querySelectorAll('button[onclick^="selectLanguage"]');
        buttons.forEach(button => {
            if (button.onclick.toString().includes(`'${lang}'`)) {
                button.className = 'px-4 py-2 bg-[#0073AF] text-white rounded-lg font-medium transition-colors';
            } else {
                button.className = 'px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors';
            }
        });
    }

    // Password validation
    document.getElementById('confirmPassword').addEventListener('input', function () {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = this.value;

        if (newPassword !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
        } else {
            this.setCustomValidity('');
        }
    });

    // Form submission handling
    document.addEventListener('DOMContentLoaded', function () {
        const saveButton = document.querySelector('button[class*="bg-[#0073AF]"]');
        if (saveButton) {
            saveButton.addEventListener('click', function (e) {
                e.preventDefault();

                // Basic form validation
                const email = document.getElementById('email').value;
                const displayName = document.getElementById('displayName').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!email || !displayName) {
                    alert('Please fill in all required fields');
                    return;
                }

                if (newPassword && newPassword !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }

                // Here you would typically send the data to a server
                alert('Settings saved successfully!');
            });
        }
    });

    // FAQ Page Tab Functionality
    const faqTabButtons = document.querySelectorAll('.tab-button[data-tab]');
    const faqTabContents = document.querySelectorAll('.tab-content');

    faqTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active classes from all buttons
            faqTabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600', 'active');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active classes to clicked button
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-500', 'text-blue-600', 'active');
            
            // Hide all tab contents
            faqTabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target tab content
            const targetContent = document.getElementById(`${targetTab}-tab`);
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });

    // FAQ Management Functions
    let faqItemCounter = 3; // Start from 3 since we have 2 existing items

    // Add new FAQ item
    document.getElementById('add-faq-btn')?.addEventListener('click', function() {
        const activeTab = document.querySelector('.tab-button.active');
        const targetTab = activeTab ? activeTab.getAttribute('data-tab') : 'mystery-visitor';
        const targetContainer = document.querySelector(`#${targetTab}-tab .space-y-6`);
        
        if (targetContainer) {
            const newFaqItem = createFaqItem(faqItemCounter);
            targetContainer.appendChild(newFaqItem);
            faqItemCounter++;
        }
    });

    // Create FAQ item template
    function createFaqItem(itemNumber) {
        const faqItem = document.createElement('div');
        faqItem.className = 'bg-white rounded-xl border border-gray-200 p-3 sm:p-4 lg:p-6 shadow-sm hover:shadow-md transition-shadow duration-200 mb-4 sm:mb-6';
        faqItem.innerHTML = `
            <div class="flex justify-between items-start">
                <h3 class="text-sm sm:text-base leading-none pb-3 sm:pb-4 font-semibold text-gray-800">FAQ Item ${itemNumber}</h3>
            </div>

            <div class="w-full flex flex-col gap-3 sm:gap-2">
                <div class="w-full flex flex-col gap-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Question</label>
                    <input type="text" class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Question">
                </div>
                
                <div class="w-full flex flex-col gap-1">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Answer</label>
                    <textarea class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Answer"></textarea>
                </div>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                    <button class="add-more-btn btn-primary px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 flex items-center justify-center gap-2 w-full sm:w-auto">
                        Add more
                    </button>
                    
                    <div class="flex items-center space-x-1 sm:space-x-2 w-full sm:w-auto justify-center sm:justify-end">
                        <button class="view-btn text-gray-400 hover:text-gray-600 p-2 transition-all duration-200" title="View">
                            <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z"></path>
                            </svg>
                        </button>
                        <button class="copy-btn text-gray-400 hover:text-gray-600 p-2 transition-all duration-200" title="Copy">
                            <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.9998 6V3C6.9998 2.44772 7.44752 2 7.9998 2H19.9998C20.5521 2 20.9998 2.44772 20.9998 3V17C20.9998 17.5523 20.5521 18 19.9998 18H16.9998V20.9991C16.9998 21.5519 16.5499 22 15.993 22H4.00666C3.45059 22 3 21.5554 3 20.9991L3.0026 7.00087C3.0027 6.44811 3.45264 6 4.00942 6H6.9998ZM8.9998 6H16.9998V16H18.9998V4H8.9998V6ZM6.9998 11V13H12.9998V11H6.9998ZM6.9998 15V17H12.9998V15H6.9998Z"></path>
                            </svg>
                        </button>
                        <button class="delete-btn text-gray-400 hover:text-red-600 p-2 transition-all duration-200" title="Delete">
                            <svg class="size-[16px] sm:size-[20px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 4H22V6H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V6H2V4H7V2H17V4ZM9 9V17H11V9H9ZM13 9V17H15V9H13Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Add event listeners to the new FAQ item
        addFaqItemEventListeners(faqItem);
        
        return faqItem;
    }

    // Add event listeners to FAQ item buttons
    function addFaqItemEventListeners(faqItem) {
        // Add more button
        const addMoreBtn = faqItem.querySelector('.add-more-btn');
        addMoreBtn.addEventListener('click', function() {
            const activeTab = document.querySelector('.tab-button.active');
            const targetTab = activeTab ? activeTab.getAttribute('data-tab') : 'mystery-visitor';
            const targetContainer = document.querySelector(`#${targetTab}-tab .space-y-6`);
            
            if (targetContainer) {
                const newFaqItem = createFaqItem(faqItemCounter);
                targetContainer.appendChild(newFaqItem);
                faqItemCounter++;
            }
        });

        // View button
        const viewBtn = faqItem.querySelector('.view-btn');
        viewBtn.addEventListener('click', function() {
            const question = faqItem.querySelector('input[type="text"]').value;
            const answer = faqItem.querySelector('textarea').value;
            
            if (question && answer) {
                alert(`Question: ${question}\n\nAnswer: ${answer}`);
            } else {
                alert('Please fill in both question and answer before viewing.');
            }
        });

        // Copy button
        const copyBtn = faqItem.querySelector('.copy-btn');
        copyBtn.addEventListener('click', function() {
            const question = faqItem.querySelector('input[type="text"]').value;
            const answer = faqItem.querySelector('textarea').value;
            
            if (question && answer) {
                const textToCopy = `Question: ${question}\nAnswer: ${answer}`;
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // Show feedback
                    const originalText = this.innerHTML;
                    this.innerHTML = '<svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    setTimeout(() => {
                        this.innerHTML = originalText;
                    }, 1000);
                });
            } else {
                alert('Please fill in both question and answer before copying.');
            }
        });

        // Delete button
        const deleteBtn = faqItem.querySelector('.delete-btn');
        deleteBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this FAQ item?')) {
                faqItem.style.transition = 'all 0.3s ease-out';
                faqItem.style.transform = 'translateX(-100%)';
                faqItem.style.opacity = '0';
                setTimeout(() => {
                    faqItem.remove();
                }, 300);
            }
        });
    }

    // Add event listeners to existing FAQ items
    document.querySelectorAll('.bg-white.rounded-lg.border.border-gray-200.p-6.shadow-sm').forEach(faqItem => {
        addFaqItemEventListeners(faqItem);
    });


    
function toggleDropdown(button) {
  const wrapper = button.closest(".dropdown-wrapper"); // get parent container
  const dropdown = wrapper.querySelector(".dropdown");

  // close all other dropdowns first
  document.querySelectorAll(".dropdown").forEach(d => {
    if (d !== dropdown) d.classList.add("hidden");
  });

  // toggle current one
  dropdown.classList.toggle("hidden");
}

// close if clicking outside
document.addEventListener("click", function (event) {
  if (!event.target.closest(".dropdown-wrapper")) {
    document.querySelectorAll(".dropdown").forEach(d => d.classList.add("hidden"));
  }
});


function toggleInput(button, action) {
    const wrapper = button.closest(".content-wrapper");
    const input = wrapper.querySelector(".input-field");
    let display = wrapper.querySelector(".input-display");
    const content = wrapper.querySelector(".main-content");
    const buttonCTN = wrapper.querySelector(".button-content");

    const showBtn = wrapper.querySelector(".show-btn");
    const hideBtn = wrapper.querySelector(".hide-btn");

    if (action === 'show') {
        // Show input
        input.classList.remove("hidden");
        content.classList.remove("hidden");
        buttonCTN.classList.remove("hidden");
        input.focus();

        // Switch buttons
        showBtn.classList.add("hidden");
        hideBtn.classList.remove("hidden");

        if (display) display.remove();
    } else if (action === 'hide') {
        // Hide input
        input.classList.add("hidden");
        content.classList.add("hidden");
        buttonCTN.classList.add("hidden");

        // Switch buttons
        hideBtn.classList.add("hidden");
        showBtn.classList.remove("hidden");

        // Create or update display
        if (!display) {
            display = document.createElement('div');
            display.classList.add('input-display', 'mt-2', 'text-gray-700');
            display.textContent = input.value.trim() || "Quesion"; // default text
            input.insertAdjacentElement('afterend', display);
        } else {
            display.textContent = input.value.trim() || "Quesion";
        }
    }
}



