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

// Close button functionality
closeBtn.addEventListener("click", function () {
  if (window.innerWidth >= 992) {
    // Desktop: hide sidebar with smooth animation
    aside.style.transition = "transform 0.3s ease-in-out";
    aside.style.transform = "translateX(-100%)";
    setTimeout(() => {
      aside.style.display = "none";
      aside.style.transform = "translateX(0)";
    }, 300);
  } else {
    // Mobile/Tablet: close offcanvas slide
    aside.classList.remove("show");
    
    // Remove backdrop
    const backdrop = document.querySelector(".sidebar-backdrop");
    if (backdrop) backdrop.remove();
  }
})

// Language Selection Functionality
function selectLanguage(language) {
    // Remove active class from all language buttons
    const languageButtons = document.querySelectorAll('[onclick^="selectLanguage"]');
    languageButtons.forEach(button => {
        button.classList.remove('bg-[#0073AF]', 'text-white');
        button.classList.add('bg-gray-100', 'text-gray-700');
    });

    // Add active class to selected button
    const selectedButton = document.querySelector(`[onclick="selectLanguage('${language}')"]`);
    if (selectedButton) {
        selectedButton.classList.remove('bg-gray-100', 'text-gray-700');
        selectedButton.classList.add('bg-[#0073AF]', 'text-white');
    }

    // Store language preference in localStorage
    localStorage.setItem('selectedLanguage', language);
}


// Tab functionality
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