document.addEventListener('DOMContentLoaded', function() {
    // Dynamic pricing calculation
    const wallpaperCheckboxes = document.querySelectorAll('.wallpaper-checkbox');
    const priceDisplay = document.getElementById('price-display');
    const totalPrice = document.getElementById('total-price');
    
    if (wallpaperCheckboxes.length > 0) {
        wallpaperCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrice);
        });
    }

    function updatePrice() {
        const selectedCount = document.querySelectorAll('.wallpaper-checkbox:checked').length;
        const price = calculatePrice(selectedCount);
        if (priceDisplay) {
            priceDisplay.textContent = selectedCount;
        }
        if (totalPrice) {
            totalPrice.textContent = `$${price.toFixed(2)}`;
        }
    }

    function calculatePrice(count) {
        const prices = {
            1: 9.99,
            2: 17.99,
            3: 24.99,
            4: 29.99,
            5: 34.99
        };
        return prices[count] || 0;
    }

    // Dynamic phone model selection
    const brandSelect = document.getElementById('phone-brand');
    const modelSelect = document.getElementById('phone-model');
    
    if (brandSelect && modelSelect) {
        const phoneModels = {
            'apple': [
                'iPhone 15 Pro Max',
                'iPhone 15 Pro',
                'iPhone 15 Plus',
                'iPhone 15'
            ],
            'samsung': [
                'Galaxy S24 Ultra',
                'Galaxy S24+',
                'Galaxy S24'
            ],
            'google': [
                'Pixel 8 Pro',
                'Pixel 8'
            ]
        };

        brandSelect.addEventListener('change', function() {
            const selectedBrand = this.value;
            modelSelect.innerHTML = '';
            
            if (selectedBrand && phoneModels[selectedBrand]) {
                phoneModels[selectedBrand].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
        });
    }

    // Form validation
    const birthForm = document.getElementById('birth-form');
    if (birthForm) {
        birthForm.addEventListener('submit', function(e) {
            const year = document.getElementById('birth_year').value;
            const month = document.getElementById('birth_month').value;
            const day = document.getElementById('birth_day').value;
            const hour = document.getElementById('birth_hour_slot').value;

            if (!validateDate(year, month, day)) {
                e.preventDefault();
                alert('Please enter a valid date.');
                return;
            }

            if (!validateHour(hour)) {
                e.preventDefault();
                alert('Please enter a valid hour (0-23).');
                return;
            }
        });
    }

    function validateDate(year, month, day) {
        const date = new Date(year, month - 1, day);
        return date.getFullYear() == year && 
               date.getMonth() == month - 1 && 
               date.getDate() == day;
    }

    function validateHour(hour) {
        return hour >= 0 && hour <= 23;
    }

    // Element chart animation
    const elementBars = document.querySelectorAll('.element-bar .fill');
    if (elementBars.length > 0) {
        elementBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            setTimeout(() => {
                bar.style.width = width + '%';
            }, 100);
        });
    }
}); 