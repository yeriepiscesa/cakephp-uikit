import 'tom-select/dist/css/tom-select.css';
import TomSelect from 'tom-select';
import Alpine from 'alpinejs';

function getNestedValue(object, path) {
    return path.split('.').reduce((current, key) => current?.[key], object);
}

function formatLabel(item, labelFields) {
    return labelFields
        .map((field) => getNestedValue(item, field))
        .filter(Boolean)
        .join(', ');
}

function initLookupSelects() {
    document.querySelectorAll('select[data-lookup-url]').forEach((select) => {
        if (select.tomselect) {
            return;
        }

        const lookupUrl = select.dataset.lookupUrl;
        const labelFields = (select.dataset.labelFields || 'name')
            .split(',')
            .map((field) => field.trim())
            .filter(Boolean);
        const control = new TomSelect(select, {
            plugins: select.multiple ? ['remove_button'] : (select.hasAttribute('data-clearable') ? ['clear_button'] : []),
            valueField: 'id',
            labelField: labelFields[0],
            // The server searches all configured fields; do not hide matches using a second client-side search.
            searchField: [],
            create: false,
            load(query, callback) {
                const url = new URL(lookupUrl, window.location.href);
                url.searchParams.set('search', query);
                fetch(url, { headers: { Accept: 'application/json' } })
                    .then((response) => {
                        if (!response.ok) throw new Error(`Lookup failed: ${response.status}`);
                        return response.json();
                    })
                    .then((json) => callback(Array.isArray(json.results) ? json.results : []))
                    .catch(() => callback());
            },
            render: {
                option(item, escape) {
                    return `<div>${escape(formatLabel(item, labelFields))}</div>`;
                },
                item(item, escape) {
                    return `<div>${escape(formatLabel(item, labelFields))}</div>`;
                },
            },
        });
        control.wrapper.classList.remove('uk-select');
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLookupSelects);
} else {
    initLookupSelects();
}

Alpine.start();
