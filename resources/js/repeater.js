/** Form-only repeater; persistence and validation remain with the consuming form. */
export function repeater(config = {}) {
    const copy = value => JSON.parse(JSON.stringify(value));
    let nextKey = 0;
    const wrap = (data, editing = false, isNew = false) => ({
        key: nextKey++, data: copy(data), editing, isNew, original: null,
        expanded: isNew || config.expanded !== false || Boolean(data._errors && Object.keys(data._errors).length),
    });
    return {
        items: (config.items || []).map(item => wrap(item)),
        removedIds: [...(config.removedIds || [])],
        toggle(item) { item.expanded = !item.expanded; },
        expandAll() { this.items.forEach(item => { item.expanded = true; }); },
        collapseAll() { this.items.forEach(item => { item.expanded = false; }); },
        add() { this.items.push(wrap(config.defaults || {}, true, true)); },
        edit(item) { item.original = copy(item.data); item.editing = true; },
        save(item) { item.editing = false; item.isNew = false; item.original = null; },
        cancel(item) {
            if (item.isNew) { this.remove(item); return; }
            item.data = item.original; item.original = null; item.editing = false;
        },
        duplicate(item) {
            const data = copy(item.data); delete data.id;
            this.items.push(wrap(data, true, true));
        },
        remove(item) {
            if (config.trackRemoved && item.data.id != null && item.data.id !== '') {
                this.removedIds.push(item.data.id);
            }
            this.items = this.items.filter(candidate => candidate.key !== item.key);
        },
    };
}
