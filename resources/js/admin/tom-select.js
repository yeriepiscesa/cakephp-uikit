import TomSelect from 'tom-select';

function initTomSelects() {
    document.querySelectorAll('select[data-tom-select]').forEach((select) => {
        if (select.tomselect) return;
        const control = new TomSelect(select, { create: false, allowEmptyOption: false });
        // Tom Select copies the native class list to its wrapper. UIkit's
        // select rules would otherwise give that wrapper a second native arrow.
        control.wrapper.classList.remove('uk-select');
    });
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTomSelects);
} else {
    initTomSelects();
}
