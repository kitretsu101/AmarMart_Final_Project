/**
 * AmarMart — AJAX (Fetch API), live search, cart, wishlist, theme
 */
(function () {
    'use strict';

    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content || '';
    const spinner = document.getElementById('globalSpinner');

    function showSpinner() {
        spinner?.classList.remove('d-none');
    }

    function hideSpinner() {
        spinner?.classList.add('d-none');
    }

    function showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const id = 'toast-' + Date.now();
        const bg = type === 'success' ? 'text-bg-success' : 'text-bg-danger';
        container.insertAdjacentHTML('beforeend', `
            <div id="${id}" class="toast align-items-center ${bg} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>`);
        const el = document.getElementById(id);
        const toast = new bootstrap.Toast(el, { delay: 3000 });
        toast.show();
        el.addEventListener('hidden.bs.toast', () => el.remove());
    }

    function updateCartBadge(count) {
        const badge = document.getElementById('cartBadge');
        if (!badge) return;
        badge.textContent = count;
        badge.classList.toggle('d-none', !count || count < 1);
    }

    function updateWishlistBadge(count) {
        const badge = document.getElementById('wishlistBadge');
        if (!badge) return;
        badge.textContent = count;
        badge.classList.toggle('d-none', !count || count < 1);
    }

    async function api(url, options = {}) {
        const defaults = {
            headers: {
                'X-CSRF-TOKEN': csrf(),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
        };
        if (options.body && !(options.body instanceof FormData)) {
            defaults.headers['Content-Type'] = 'application/json';
        }
        const res = await fetch(url, { ...defaults, ...options, headers: { ...defaults.headers, ...(options.headers || {}) } });
        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            throw new Error(data.message || 'Something went wrong.');
        }
        return data;
    }

    // ----- Live Search -----
    const searchInput = document.getElementById('liveSearchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');
    const searchBtn = document.getElementById('liveSearchBtn');
    let searchTimer = null;

    function goSearch() {
        if (!searchInput) return;
        const q = searchInput.value.trim();
        window.location.href = (window.AmarMart?.routes?.home || '/') + (q ? '?search=' + encodeURIComponent(q) : '');
    }

    async function fetchSuggestions(q) {
        if (!suggestionsBox || !window.AmarMart?.routes?.searchSuggestions) return;
        if (q.length < 1) {
            suggestionsBox.classList.add('d-none');
            suggestionsBox.innerHTML = '';
            return;
        }
        try {
            const data = await api(window.AmarMart.routes.searchSuggestions + '?q=' + encodeURIComponent(q));
            const items = data.suggestions || [];
            if (!items.length) {
                suggestionsBox.innerHTML = '<div class="suggestion-item text-muted">No products found</div>';
                suggestionsBox.classList.remove('d-none');
                return;
            }
            suggestionsBox.innerHTML = items.map((s) => `
                <a class="suggestion-item" href="${s.url}">
                    <span>${s.name}</span>
                    <span class="text-muted">৳${s.price}</span>
                </a>`).join('');
            suggestionsBox.classList.remove('d-none');
        } catch (e) {
            suggestionsBox.classList.add('d-none');
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => fetchSuggestions(searchInput.value.trim()), 250);
        });
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                goSearch();
            }
        });
        document.addEventListener('click', (e) => {
            if (!suggestionsBox?.contains(e.target) && e.target !== searchInput) {
                suggestionsBox?.classList.add('d-none');
            }
        });
    }
    searchBtn?.addEventListener('click', goSearch);

    // ----- AJAX Add to Cart -----
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-ajax-add-cart]');
        if (!btn) return;
        e.preventDefault();
        const id = btn.getAttribute('data-ajax-add-cart');
        showSpinner();
        try {
            const data = await api(`${window.AmarMart.routes.cartAdd}/${id}`, { method: 'POST', body: '{}' });
            updateCartBadge(data.count);
            showToast(data.message || 'Added to cart!', 'success');
        } catch (err) {
            showToast(err.message, 'error');
        } finally {
            hideSpinner();
        }
    });

    // ----- AJAX Cart qty / remove -----
    document.addEventListener('click', async (e) => {
        const inc = e.target.closest('[data-cart-increase]');
        const dec = e.target.closest('[data-cart-decrease]');
        const rem = e.target.closest('[data-cart-remove]');

        if (inc || dec || rem) {
            e.preventDefault();
            const id = (inc || dec || rem).getAttribute(inc ? 'data-cart-increase' : dec ? 'data-cart-decrease' : 'data-cart-remove');
            let url, method = 'POST';
            if (inc) url = `${window.AmarMart.routes.cartIncrease}/${id}`;
            else if (dec) url = `${window.AmarMart.routes.cartDecrease}/${id}`;
            else {
                url = `${window.AmarMart.routes.cartRemove}/${id}`;
                method = 'DELETE';
            }
            showSpinner();
            try {
                const data = await api(url, { method });
                updateCartBadge(data.count);
                showToast(data.message, 'success');
                // Reload cart page totals
                if (document.getElementById('cartTable')) {
                    window.location.reload();
                }
            } catch (err) {
                showToast(err.message, 'error');
            } finally {
                hideSpinner();
            }
        }
    });

    // ----- Wishlist toggle -----
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-wishlist-toggle]');
        if (!btn) return;
        e.preventDefault();
        const id = btn.getAttribute('data-wishlist-toggle');
        showSpinner();
        try {
            const data = await api(`${window.AmarMart.routes.wishlistToggle}/${id}`, { method: 'POST', body: '{}' });
            updateWishlistBadge(data.count);
            btn.classList.toggle('active', data.added);
            btn.innerHTML = data.added
                ? '<i class="bi bi-heart-fill"></i>'
                : '<i class="bi bi-heart"></i>';
            showToast(data.message, 'success');
        } catch (err) {
            showToast(err.message, 'error');
        } finally {
            hideSpinner();
        }
    });

    // ----- Quick View -----
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('[data-quick-view]');
        if (!btn) return;
        e.preventDefault();
        const id = btn.getAttribute('data-quick-view');
        const modalEl = document.getElementById('quickViewModal');
        const body = document.getElementById('quickViewBody');
        const title = document.getElementById('quickViewTitle');
        body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
        try {
            const p = await api(`${window.AmarMart.routes.quickView}/${id}/quick-view`);
            title.textContent = p.name;
            const stockBadge = p.stock > 0
                ? `<span class="badge bg-success">In Stock (${p.stock})</span>`
                : `<span class="badge bg-danger">Out of Stock</span>`;
            body.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-5 text-center">
                        <img src="${p.image}" alt="${p.name}" class="img-fluid rounded" style="max-height:260px;object-fit:contain;">
                    </div>
                    <div class="col-md-7">
                        <h4>${p.name}</h4>
                        <div class="fs-4 text-primary mb-2">৳${p.price}</div>
                        <div class="mb-2">${stockBadge}</div>
                        <p class="text-muted">${(p.description || '').substring(0, 200)}</p>
                        <div class="d-flex gap-2 flex-wrap">
                            ${p.stock > 0 ? `<button type="button" class="btn btn-primary" data-ajax-add-cart="${p.id}" data-bs-dismiss="modal"><i class="bi bi-cart-plus me-1"></i>Add to Cart</button>` : ''}
                            <a href="${p.url}" class="btn btn-outline-secondary">View Details</a>
                        </div>
                    </div>
                </div>`;
        } catch (err) {
            body.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;
        }
    });

    // ----- Theme toggle (cookie 7 days) -----
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        document.body.classList.remove('theme-light', 'theme-dark');
        document.body.classList.add('theme-' + theme);
        if (themeIcon) {
            themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        }
    }

    applyTheme(document.documentElement.getAttribute('data-theme') || 'light');

    themeToggle?.addEventListener('click', async () => {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        try {
            await api(window.AmarMart.routes.themeSet, {
                method: 'POST',
                body: JSON.stringify({ theme: next }),
            });
        } catch (_) { /* cookie still applied client-side via response */ }
    });

    // expose helpers
    window.AmarMartUI = { showToast, showSpinner, hideSpinner, updateCartBadge };
})();
