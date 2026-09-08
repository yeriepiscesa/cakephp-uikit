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
        const searchField = select.dataset.searchField || labelFields[0] || 'name';

        new TomSelect(select, {
            valueField: 'id',
            labelField: labelFields[0],
            searchField,
            create: false,
            load(query, callback) {
                fetch(`${lookupUrl}?search=${encodeURIComponent(query)}`)
                    .then((response) => response.json())
                    .then((json) => callback(json.results))
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
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLookupSelects);
} else {
    initLookupSelects();
}

Alpine.start();
