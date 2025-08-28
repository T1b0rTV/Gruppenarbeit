// Live search script with debounce and simple pagination
(function(){
  const qInput = document.getElementById('q');
  if (!qInput) return;
  const perPage = 10;
  let timer = null;
  let currentPage = 1;

  function renderTable(results){
    const existing = document.querySelector('table');
    if (existing) existing.remove();

    if (!results || results.length === 0) {
      const empty = document.querySelector('.empty');
      if (empty) empty.textContent = 'Keine Produkte gefunden.';
      return;
    }

    const table = document.createElement('table');
    const thead = document.createElement('thead');
    thead.innerHTML = '<tr><th>Code</th><th>Name</th><th>Line</th><th>Scale</th><th>Vendor</th><th>Stock</th><th>Preis</th></tr>';
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    results.forEach(p => {
      const tr = document.createElement('tr');
      tr.className = 'result-row';
      tr.innerHTML = `<td>${escapeHtml(p.productCode)}</td><td>${highlight(escapeHtml(p.productName))}</td><td>${escapeHtml(p.productLine)}</td><td>${escapeHtml(p.productScale)}</td><td>${escapeHtml(p.productVendor)}</td><td>${escapeHtml(p.quantityInStock)}</td><td>${escapeHtml(p.buyPrice)}</td>`;
      tbody.appendChild(tr);
    });
    table.appendChild(tbody);

    const container = document.querySelector('.card');
    const empty = document.querySelector('.empty');
    if (empty) empty.remove();
    container.appendChild(table);
  }

  function escapeHtml(s){
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>\"]/g, function(c){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c];
    });
  }

  function renderMeta(total){
    const meta = document.querySelector('.meta');
    if (meta) meta.textContent = `Ergebnisse — ${total} Treffer`;
  }

  function renderPagination(total){
    const existing = document.querySelector('.pagination');
    if (existing) existing.remove();
    const pages = Math.ceil(total / perPage);
    if (pages <= 1) return;

    const nav = document.createElement('div');
    nav.className = 'pagination';
    nav.style.marginTop = '12px';

    const prev = document.createElement('button');
    prev.textContent = 'Prev';
    prev.disabled = currentPage === 1;
    prev.addEventListener('click', ()=>{ if (currentPage>1){ currentPage--; doSearch(); } });
    nav.appendChild(prev);

    for (let i = 1; i <= pages; i++){
      const btn = document.createElement('button');
      btn.textContent = i;
      if (i===currentPage) btn.disabled = true;
      btn.addEventListener('click', ()=>{
        currentPage = i;
        doSearch();
      });
      nav.appendChild(btn);
    }

    const next = document.createElement('button');
    next.textContent = 'Next';
    next.disabled = currentPage === pages;
    next.addEventListener('click', ()=>{ if (currentPage<pages){ currentPage++; doSearch(); } });
    nav.appendChild(next);

    document.querySelector('.card').appendChild(nav);
  }

  function highlight(text){
    const q = qInput.value.trim();
    if (!q) return text;
    // take first term for highlight simplicity
    const term = q.split(/\s|,|and|or/)[0];
    if (!term) return text;
    const re = new RegExp('('+escapeRegExp(term)+')','ig');
    return text.replace(re, '<mark>$1</mark>');
  }

  function escapeRegExp(s){ return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }

  async function doSearch(){
    const q = qInput.value.trim();
    if (!q){
      // show hint
      const existing = document.querySelector('table'); if (existing) existing.remove();
      let empty = document.querySelector('.empty');
      if (!empty){ empty = document.createElement('div'); empty.className='empty'; document.querySelector('.card').appendChild(empty); }
      empty.textContent = 'Bitte gib einen Suchbegriff ein und drücke "Suchen".';
      return;
    }
    const url = window.location.pathname;
    try{
      const fd = new FormData();
      fd.append('ajax', '1');
      fd.append('q', q);
      fd.append('page', String(currentPage));
      fd.append('per_page', String(perPage));
      const res = await fetch(url, { method: 'POST', body: fd, cache: 'no-store' });
      if (!res.ok) throw new Error('Network');
      const data = await res.json();
      renderMeta(data.total);
      renderTable(data.results);
      renderPagination(data.total);
    }catch(e){
      console.error(e);
    }
  }

  qInput.addEventListener('input', ()=>{
    currentPage = 1;
    clearTimeout(timer);
    timer = setTimeout(doSearch, 350);
  });

  // Intercept form submit to use AJAX POST instead of full page reload
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function(e){
      e.preventDefault();
      currentPage = 1;
      clearTimeout(timer);
      doSearch();
    });
  }

  // If the page loads with a query, trigger a search
  if (qInput.value.trim() !== ''){
    setTimeout(doSearch, 50);
  }
})();
