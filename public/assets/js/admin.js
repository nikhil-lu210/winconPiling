'use strict';

/**
 * Wincon admin — sidebar, confirmations, gallery sort, form UX.
 */
document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    var toggle = document.getElementById('adminNavToggle');
    var backdrop = document.getElementById('adminSidebarBackdrop');
    var sidebar = document.getElementById('adminSidebar');

    function closeSidebar() {
        body.classList.remove('admin-sidebar-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    }

    if (toggle && sidebar) {
        toggle.addEventListener('click', function () {
            var open = !body.classList.contains('admin-sidebar-open');
            body.classList.toggle('admin-sidebar-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }
    if (backdrop) backdrop.addEventListener('click', closeSidebar);
    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) closeSidebar();
    });

    document.querySelectorAll('form[method="post"]').forEach(function (form) {
        var action = form.getAttribute('action') || '';
        if (action.indexOf('/delete') === -1) return;
        if (form.getAttribute('onsubmit')) return;
        form.addEventListener('submit', function (e) {
            if (!confirm('Delete this item permanently?')) e.preventDefault();
        });
    });

    function csrfToken() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') || '' : '';
    }

    /* Drag-and-drop row reorder (gallery, services, land, videos) */
    (function initSortableTables() {
        if (typeof Sortable === 'undefined') return;
        var token = csrfToken();
        document.querySelectorAll('tbody[data-reorder-url]').forEach(function (tbody) {
            var reorderUrl = tbody.getAttribute('data-reorder-url');
            if (!reorderUrl) return;
            Sortable.create(tbody, {
                handle: '.admin-drag-handle',
                animation: 150,
                onEnd: function () {
                    body.classList.add('admin-is-loading');
                    var rows = tbody.querySelectorAll('tr[data-id]');
                    var order = [];
                    rows.forEach(function (tr, i) {
                        order.push({ id: parseInt(tr.getAttribute('data-id'), 10), sort: i });
                    });
                    var fd = new FormData();
                    fd.append('_csrf_token', token);
                    fd.append('order', JSON.stringify(order));
                    fetch(reorderUrl, { method: 'POST', body: fd, credentials: 'same-origin' })
                        .then(function (r) { return r.json(); })
                        .then(function (j) {
                            if (!j.success) alert('Could not save order.');
                        })
                        .catch(function () { alert('Could not save order.'); })
                        .finally(function () { body.classList.remove('admin-is-loading'); });
                },
            });
        });
    })();

    /* YouTube thumbnail live preview (video form) */
    (function initYoutubePreview() {
        var inp = document.getElementById('youtube_id');
        var img = document.getElementById('ytPreview');
        if (!inp || !img) return;
        function upd() {
            var id = (inp.value || '').trim();
            if (id.length === 11) {
                img.src = 'https://img.youtube.com/vi/' + encodeURIComponent(id) + '/hqdefault.jpg';
                img.style.display = '';
            } else {
                img.style.display = 'none';
            }
        }
        inp.addEventListener('input', upd);
        upd();
    })();

    /* Image file input preview (gallery + land) */
    document.querySelectorAll('input[type="file"][data-preview-target]').forEach(function (input) {
        var targetId = input.getAttribute('data-preview-target');
        var preview = targetId ? document.getElementById(targetId) : null;
        if (!preview) return;
        input.addEventListener('change', function () {
            var f = input.files && input.files[0];
            if (!f || !/^image\//.test(f.type)) {
                if (preview.tagName === 'IMG') {
                    preview.removeAttribute('src');
                    preview.style.display = 'none';
                }
                return;
            }
            var url = URL.createObjectURL(f);
            if (preview.tagName === 'IMG') {
                preview.onload = function () {
                    URL.revokeObjectURL(url);
                    preview.onload = null;
                };
                preview.src = url;
                preview.style.display = '';
            }
        });
    });

    /* Service form: slug from title + dynamic sub-items */
    (function initServiceForm() {
        var form = document.querySelector('form[data-admin-service-form]');
        if (!form) return;
        var title = document.getElementById('title');
        var slug = document.getElementById('slug');
        var isCreate = form.getAttribute('data-is-edit') !== '1';
        var slugEdited = false;
        if (title && slug && isCreate) {
            title.addEventListener('input', function () {
                if (slugEdited) return;
                var s = title.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                slug.value = s;
            });
        }
        if (slug) {
            slug.addEventListener('input', function () { slugEdited = true; });
        }
        var list = document.getElementById('subItemsList');
        var addBtn = document.getElementById('addSubItem');
        function addRow() {
            var row = document.createElement('div');
            row.className = 'admin-dynamic-row';
            var inp = document.createElement('input');
            inp.className = 'admin-input';
            inp.type = 'text';
            inp.name = 'sub_items[]';
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'admin-btn admin-btn--ghost admin-remove-row';
            btn.setAttribute('aria-label', 'Remove');
            btn.textContent = '×';
            btn.addEventListener('click', function () { row.remove(); });
            row.appendChild(inp);
            row.appendChild(btn);
            list.appendChild(row);
        }
        if (addBtn) addBtn.addEventListener('click', addRow);
        if (list) {
            list.querySelectorAll('.admin-remove-row').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var row = btn.closest('.admin-dynamic-row');
                    if (row) row.remove();
                });
            });
        }
    })();

    /* Land form: dynamic features */
    (function initLandForm() {
        var form = document.querySelector('form[data-admin-land-form]');
        if (!form) return;
        var list = document.getElementById('featuresList');
        var addBtn = document.getElementById('addFeature');
        function addRow(val) {
            var row = document.createElement('div');
            row.className = 'admin-dynamic-row';
            var inp = document.createElement('input');
            inp.className = 'admin-input';
            inp.type = 'text';
            inp.name = 'features[]';
            inp.value = val || '';
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'admin-btn admin-btn--ghost admin-remove-row';
            btn.setAttribute('aria-label', 'Remove');
            btn.textContent = '×';
            btn.addEventListener('click', function () { row.remove(); });
            row.appendChild(inp);
            row.appendChild(btn);
            list.appendChild(row);
        }
        if (addBtn) addBtn.addEventListener('click', function () { addRow(''); });
        if (list) {
            list.querySelectorAll('.admin-remove-row').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var row = btn.closest('.admin-dynamic-row');
                    if (row) row.remove();
                });
            });
        }
    })();

    /* Message detail: mark read via fetch (matches bulk API) */
    (function initMessageViewMarkRead() {
        var el = document.getElementById('adminMessageViewMark');
        if (!el) return;
        var id = parseInt(el.getAttribute('data-message-id') || '0', 10);
        var url = el.getAttribute('data-mark-read-url');
        if (!id || !url) return;
        var fd = new FormData();
        fd.append('_csrf_token', csrfToken());
        fd.append('ids[]', String(id));
        body.classList.add('admin-is-loading');
        fetch(url, { method: 'POST', body: fd, credentials: 'same-origin' })
            .finally(function () { body.classList.remove('admin-is-loading'); });
    })();
});
