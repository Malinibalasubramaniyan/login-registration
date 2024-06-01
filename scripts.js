document.addEventListener('DOMContentLoaded', function () {
    const data = {
        "USA": {
            "California": ["Los Angeles", "San Francisco", "San Diego", "Sacramento", "San Jose"],
            "Florida": ["Miami", "Orlando", "Tampa", "Jacksonville", "Tallahassee"],
            "New York": ["New York City", "Buffalo", "Rochester", "Albany", "Syracuse"],
            "Texas": ["Houston", "Austin", "Dallas", "San Antonio", "Fort Worth"],
            "Illinois": ["Chicago", "Springfield", "Naperville", "Peoria", "Rockford"]
        },
        "India": {
            "Delhi": ["New Delhi", "Gurgaon", "Noida", "Faridabad", "Ghaziabad"],
            "Karnataka": ["Bangalore", "Mysore", "Mangalore", "Hubli", "Belgaum"],
            "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Thane", "Nashik"],
            "Tamil Nadu": ["Chennai", "Coimbatore", "Madurai", "Tiruchirappalli", "Salem"],
            "West Bengal": ["Kolkata", "Howrah", "Darjeeling", "Siliguri", "Durgapur"]
        },
        "Canada": {
            "Ontario": ["Toronto", "Ottawa", "Mississauga", "Brampton", "Hamilton"],
            "Quebec": ["Montreal", "Quebec City", "Laval", "Gatineau", "Longueuil"],
            "British Columbia": ["Vancouver", "Victoria", "Surrey", "Burnaby", "Richmond"],
            "Alberta": ["Calgary", "Edmonton", "Red Deer", "Lethbridge", "St. Albert"],
            "Manitoba": ["Winnipeg", "Brandon", "Steinbach", "Thompson", "Portage la Prairie"]
        },
        "Australia": {
            "New South Wales": ["Sydney", "Newcastle", "Wollongong", "Maitland", "Tweed Heads"],
            "Victoria": ["Melbourne", "Geelong", "Ballarat", "Bendigo", "Shepparton"],
            "Queensland": ["Brisbane", "Gold Coast", "Cairns", "Townsville", "Toowoomba"],
            "Western Australia": ["Perth", "Fremantle", "Albany", "Bunbury", "Kalgoorlie"],
            "South Australia": ["Adelaide", "Mount Gambier", "Whyalla", "Gawler", "Port Lincoln"]
        },
        "UK": {
            "England": ["London", "Manchester", "Birmingham", "Leeds", "Liverpool"],
            "Scotland": ["Edinburgh", "Glasgow", "Aberdeen", "Dundee", "Inverness"],
            "Wales": ["Cardiff", "Swansea", "Newport", "Wrexham", "Bangor"],
            "Northern Ireland": ["Belfast", "Derry", "Lisburn", "Newry", "Armagh"],
            "Isle of Man": ["Douglas", "Ramsey", "Peel", "Port Erin", "Castletown"]
        }
        // Add more countries, states, and cities as needed
    };

    const countrySelect = document.getElementById('country');
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    // Populate countries
    for (let country in data) {
        let option = document.createElement('option');
        option.value = country;
        option.textContent = country;
        countrySelect.appendChild(option);
    }

    // Populate states based on selected country
    countrySelect.addEventListener('change', function () {
        stateSelect.innerHTML = '<option value="">Select State</option>';
        citySelect.innerHTML = '<option value="">Select City</option>';
        let selectedCountry = this.value;
        if (selectedCountry) {
            let states = Object.keys(data[selectedCountry]);
            for (let state of states) {
                let option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            }
        }
    });

    // Populate cities based on selected state
    stateSelect.addEventListener('change', function () {
        citySelect.innerHTML = '<option value="">Select City</option>';
        let selectedCountry = countrySelect.value;
        let selectedState = this.value;
        if (selectedCountry && selectedState && data[selectedCountry][selectedState]) {
            let cities = data[selectedCountry][selectedState];
            for (let city of cities) {
                let option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            }
        }
    });

    // Form validation
    const form = document.getElementById('registrationForm');
    form.addEventListener('submit', function (event) {
        let isValid = true;
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                isValid = false;
                input.classList.add('error');
            } else {
                input.classList.remove('error');
            }
        });

        if (!isValid) {
            event.preventDefault();
            alert('Please fill all the required fields correctly.');
        } else {
            alert('Form submitted successfully!');
        }
    });
});

function goToLogin() {
    window.location.href = 'login.html';
}
