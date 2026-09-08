import 'tom-select/dist/css/tom-select.css';
import TomSelect from 'tom-select';

function formatCityOption(city) {
    const cityName = city?.name ?? '';
    const stateName = city?.state?.name ?? '';
    const countryIso = city?.state?.country?.iso ?? '';

    return {
        ...city,
        id: city?.id,
        text: [cityName, stateName, countryIso].filter(Boolean).join(', ')
    };
}

function initCityTomSelect() {
    const select = document.querySelector('#city-id-select');
    if (!select) {
        return;
    }

    const lookupUrl = select.dataset.lookupUrl || '/admin/business-users/cities/lookup';

    new TomSelect('#city-id-select', {
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        create: false,
        load: function(query, callback) {
            fetch(`${lookupUrl}?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
				.then(json => {
					callback(json.results);
				}).catch(()=>{
					callback();
				});
        },
        render: {
            option: function(item, escape) {
                const city = formatCityOption(item);
                return `<div>${escape(city.text)}</div>`;
            },
            item: function(item, escape) {
                const city = formatCityOption(item);
                return `<div>${escape(city.text)}</div>`;
            }
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCityTomSelect);
} else {
    initCityTomSelect();
}

// Start Alpine after component registration
Alpine.start();