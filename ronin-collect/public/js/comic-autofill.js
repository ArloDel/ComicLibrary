/**
 * comic-autofill.js
 *
 * Menangani logika pencarian multi-sumber dan autofill form penambahan komik baru.
 * Mendukung empat sumber: AniList, MangaDex, Google Books, Open Library.
 *
 * Konfigurasi di-inject via window.AUTOFILL_CONFIG dari Blade:
 *   window.AUTOFILL_CONFIG = { routes: { anilist, mangadex, googlebooks, openlibrary }, csrf }
 */
document.addEventListener('DOMContentLoaded', function () {

    // ─── DOM References ──────────────────────────────────────────────────────

    const searchBtn       = document.getElementById('mal_search_btn');
    const searchInput     = document.getElementById('mal_search_input');
    const resultsDropdown = document.getElementById('mal_results');
    const sourceDesc      = document.getElementById('source_description');

    // Form fields yang akan di-autofill
    const inputTitle  = document.querySelector('input[name="title"]');
    const inputAuthor = document.querySelector('input[name="author"]');
    const inputTags   = document.querySelector('input[name="tags_input"]');
    const inputDesc   = document.querySelector('textarea[name="description"]');
    const hiddenCoverUrl = document.getElementById('cover_image_url');

    // Cover preview
    const previewContainer = document.getElementById('cover_preview_container');
    const previewDiv       = document.getElementById('cover_preview');
    const sourceBadge      = document.getElementById('cover_source_badge');
    const clearCoverBtn    = document.getElementById('clear_cover_btn');

    // ─── API Config (diinject dari Blade) ────────────────────────────────────

    const { routes: PROXY, csrf: CSRF } = window.AUTOFILL_CONFIG;

    // ─── Metadata per Sumber ─────────────────────────────────────────────────

    let activeSource = 'anilist';

    const SOURCE_META = {
        anilist: {
            placeholder: 'Cari judul manga (romaji/english)...',
            desc: 'Sumber: AniList GraphQL API — metadata lengkap, cover medium-large',
        },
        mangadex: {
            placeholder: 'Cari judul manga di MangaDex...',
            desc: 'Sumber: MangaDex API — cover resolusi tinggi, database terlengkap',
        },
        googlebooks: {
            placeholder: 'Cari judul buku/manga (cocok untuk ISBN)...',
            desc: 'Sumber: Google Books API — ideal untuk cover buku fisik & versi cetak',
        },
        openlibrary: {
            placeholder: 'Cari judul manga/buku di Open Library...',
            desc: 'Sumber: Open Library (Internet Archive) — gratis, tanpa API key, cover dari ISBN',
        },
    };

    // ─── Tab Initialization ──────────────────────────────────────────────────

    const tabs = document.querySelectorAll('.source-tab');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active-tab'));
            tab.classList.add('active-tab');
            activeSource = tab.dataset.source;
            searchInput.placeholder = SOURCE_META[activeSource].placeholder;
            sourceDesc.textContent  = SOURCE_META[activeSource].desc;
            resultsDropdown.classList.add('hidden');
            resultsDropdown.innerHTML = '';
        });
    });

    // Inisialisasi tab pertama sebagai aktif
    tabs[0]?.classList.add('active-tab');
    searchInput.placeholder = SOURCE_META.anilist.placeholder;
    sourceDesc.textContent  = SOURCE_META.anilist.desc;

    // ─── Event Listeners ─────────────────────────────────────────────────────

    searchBtn.addEventListener('click', performSearch);

    searchInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') { e.preventDefault(); performSearch(); }
    });

    clearCoverBtn?.addEventListener('click', () => {
        hiddenCoverUrl.value = '';
        previewContainer.classList.add('hidden');
        previewDiv.style.backgroundImage = '';
    });

    // Tutup dropdown saat klik di luar area pencarian
    document.addEventListener('click', e => {
        const isOutside = !resultsDropdown.contains(e.target)
            && e.target !== searchInput
            && !searchBtn.contains(e.target);
        if (isOutside) resultsDropdown.classList.add('hidden');
    });

    // ─── Search Dispatcher ───────────────────────────────────────────────────

    async function performSearch() {
        const query = searchInput.value.trim();
        if (!query) return;

        searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin" data-icon="progress_activity">progress_activity</span>';
        resultsDropdown.innerHTML = '';
        resultsDropdown.classList.remove('hidden');

        try {
            const searchFns = {
                anilist:     searchAniList,
                mangadex:    searchMangaDex,
                googlebooks: searchGoogleBooks,
                openlibrary: searchOpenLibrary,
            };
            await searchFns[activeSource]?.(query);
        } catch (error) {
            console.error('[Autofill] Search error:', error);
            resultsDropdown.innerHTML = '<div class="p-4 text-primary text-sm font-bold text-center">Gagal mengambil data. Coba lagi.</div>';
        } finally {
            searchBtn.innerHTML = '<span class="material-symbols-outlined text-sm" data-icon="search">search</span> Cari';
        }
    }

    // ─── Shared Fetch Helper ─────────────────────────────────────────────────

    async function proxyFetch(url) {
        const res = await fetch(url, {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        return res.json();
    }

    // ─── Source: AniList ─────────────────────────────────────────────────────

    async function searchAniList(query) {
        const data   = await proxyFetch(`${PROXY.anilist}?title=${encodeURIComponent(query)}`);
        const mangas = data.data?.Page?.media || [];

        if (!mangas.length) return showEmpty('AniList');

        renderResults(mangas.map(m => ({
            title:       m.title.english || m.title.romaji,
            author:      m.staff?.edges?.[0]?.node?.name?.full || '',
            coverUrl:    m.coverImage?.extraLarge || m.coverImage?.large || '',
            tags:        m.genres || [],
            description: m.description ? m.description.replace(/<[^>]*>/gm, '').trim() : '',
            source:      'AniList',
        })));
    }

    // ─── Source: MangaDex ────────────────────────────────────────────────────

    async function searchMangaDex(query) {
        const data   = await proxyFetch(`${PROXY.mangadex}?title=${encodeURIComponent(query)}`);
        const mangas = data.data || [];

        if (!mangas.length) return showEmpty('MangaDex');

        renderResults(mangas.map(m => {
            const attrs = m.attributes;

            const title = attrs.title?.en
                || attrs.title?.['ja-ro']
                || attrs.title?.ja
                || Object.values(attrs.title || {})[0]
                || 'Unknown';

            const authorRel = m.relationships?.find(r => r.type === 'author');
            const coverRel  = m.relationships?.find(r => r.type === 'cover_art');

            // MangaDex API uses 'fileName' (camelCase) per the API spec
            const coverFile = coverRel?.attributes?.fileName || coverRel?.attributes?.filename || null;
            const coverUrl  = coverFile
                ? `https://uploads.mangadex.org/covers/${m.id}/${coverFile}.512.jpg`
                : '';

            return {
                title,
                author:      authorRel?.attributes?.name || '',
                coverUrl,
                tags:        attrs.tags?.map(t => t.attributes?.name?.en).filter(Boolean) || [],
                description: attrs.description?.en || attrs.description?.['ja-ro'] || '',
                source:      'MangaDex',
            };
        }));
    }

    // ─── Source: Google Books ─────────────────────────────────────────────────

    async function searchGoogleBooks(query) {
        const data  = await proxyFetch(`${PROXY.googlebooks}?title=${encodeURIComponent(query)}`);
        const items = data.items || [];

        if (!items.length) return showEmpty('Google Books');

        renderResults(items.map(item => {
            const info   = item.volumeInfo;
            const covers = info.imageLinks || {};

            // Upgrade zoom untuk resolusi lebih tinggi
            const coverUrl = (covers.extraLarge || covers.large || covers.medium || covers.thumbnail || '')
                .replace('http://', 'https://')
                .replace('zoom=1', 'zoom=3')
                .replace('&edge=curl', '');

            return {
                title:       info.title || '',
                author:      (info.authors || []).join(', '),
                coverUrl,
                tags:        info.categories || [],
                description: info.description || '',
                source:      'Google Books',
            };
        }));
    }

    // ─── Source: Open Library ─────────────────────────────────────────────────

    async function searchOpenLibrary(query) {
        const data = await proxyFetch(`${PROXY.openlibrary}?title=${encodeURIComponent(query)}`);
        const docs = data.docs || [];

        if (!docs.length) return showEmpty('Open Library');

        renderResults(docs.map(doc => {
            // Cover via cover_i → large (-L) image
            let coverUrl = '';
            if (doc.cover_i) {
                coverUrl = `https://covers.openlibrary.org/b/id/${doc.cover_i}-L.jpg`;
            } else if (doc.isbn?.length) {
                coverUrl = `https://covers.openlibrary.org/b/isbn/${doc.isbn[0]}-L.jpg`;
            }

            return {
                title:       doc.title || '',
                author:      (doc.author_name || []).join(', '),
                coverUrl,
                tags:        (doc.subject || []).slice(0, 6),
                description: doc.first_publish_year ? `Pertama terbit: ${doc.first_publish_year}` : '',
                source:      'Open Library',
            };
        }));
    }

    // ─── Render Helpers ──────────────────────────────────────────────────────

    function showEmpty(sourceName) {
        resultsDropdown.innerHTML = `
            <div class="p-4 text-on-surface-variant text-sm text-center">
                Tidak ada hasil di ${sourceName}.
            </div>`;
    }

    function renderResults(items) {
        resultsDropdown.innerHTML = '';

        items.forEach(item => {
            const el = document.createElement('div');
            el.className = 'flex items-center gap-4 p-4 hover:bg-surface-container cursor-pointer transition-colors';
            el.innerHTML = `
                <div class="w-12 h-16 flex-shrink-0 bg-surface-container-high border border-outline/20 overflow-hidden">
                    ${item.coverUrl
                        ? `<img src="${item.coverUrl}" alt="Cover" class="w-full h-full object-cover" loading="lazy"
                               onerror="this.parentElement.innerHTML='<span class=\\'text-xs text-outline-variant flex items-center justify-center h-full\\'>?</span>'">`
                        : '<span class="text-xs text-outline-variant flex items-center justify-center h-full">?</span>'}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-headline font-bold text-on-surface text-sm leading-tight uppercase line-clamp-1">${escapeHtml(item.title)}</h4>
                    <span class="text-xs font-label uppercase tracking-widest text-on-surface-variant block">${escapeHtml(item.author)}</span>
                    ${item.tags.length
                        ? `<span class="text-[9px] text-primary tracking-widest font-label">${item.tags.slice(0, 3).join(' · ')}</span>`
                        : ''}
                </div>`;

            el.addEventListener('click', () => {
                fillForm(item);
                resultsDropdown.classList.add('hidden');
                searchInput.value = '';
            });

            resultsDropdown.appendChild(el);
        });
    }

    function fillForm(item) {
        if (item.title)       inputTitle.value  = item.title;
        if (item.author)      inputAuthor.value = item.author;
        if (item.tags.length) inputTags.value   = item.tags.slice(0, 8).join(', ');
        if (item.description) inputDesc.value   = item.description;

        if (item.coverUrl) {
            hiddenCoverUrl.value = item.coverUrl;
            previewContainer.classList.remove('hidden');
            previewDiv.style.backgroundImage = `url('${item.coverUrl}')`;
            sourceBadge.textContent = item.source;

            // Animasi pulse ringan
            previewDiv.style.opacity = '0.5';
            setTimeout(() => { previewDiv.style.opacity = '1'; }, 300);
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str || ''));
        return div.innerHTML;
    }

});
