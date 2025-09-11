        // Toggle sidebar
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
        
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('open');
        });
        
        // Toggle user config
        function toggleUserConfig() {
            const btnUser = document.getElementById('btn-user');
            btnUser.checked = !btnUser.checked;
        }
        
        // Close user config when clicking outside
        document.addEventListener('click', function(event) {
            const userConfig = document.getElementById('user-config');
            const userInfo = document.querySelector('.user-info');
            const btnUser = document.getElementById('btn-user');
            
            if (btnUser.checked && !userConfig.contains(event.target) && !userInfo.contains(event.target)) {
                btnUser.checked = false;
            }
        });
        
        // Load page and update active menu item
        function loadPage(url, element) {
            document.getElementById('main-frame').src = url;
            
            // Update active menu item
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => item.classList.remove('active'));
            element.classList.add('active');
            
            // Close mobile menu after selection
            mobileMenu.classList.remove('open');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu.classList.contains('open') && 
                !mobileMenu.contains(event.target) && 
                !mobileMenuToggle.contains(event.target)) {
                mobileMenu.classList.remove('open');
            }
        });