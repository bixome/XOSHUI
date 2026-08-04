/* ==========================================================================
   XOSHUI 1.0 — comportements. Module ES, aucune dépendance.
   <script type="module" src="/libs/js/xoshui.js"></script>

   Tout se déclare en HTML :
     [data-xo-list]            navigation ↑↓, sélection, événement "xo:select"
     [data-xo-tabs]            onglets ←→, bascule des [role="tabpanel"]
     [data-xo-open="#id"]      ouvre la <dialog> ciblée
     [data-xo-close]           ferme la <dialog> parente
     .xo-dropdown              <details> : Échap et clic extérieur referment
     [data-xo-palette]         palette de commandes, ouverte par Ctrl+K
     [data-xo-help]            aide des raccourcis, ouverte par ?
     [data-xo-split]           séparateur redimensionnable (souris et flèches)
     [data-xo-toast]           notification : bouton de fermeture, délai optionnel
   ========================================================================== */

const KEY_PREV = ['ArrowUp', 'ArrowLeft'];
const KEY_NEXT = ['ArrowDown', 'ArrowRight'];

/* --- Listes ------------------------------------------------------------- */

function initList(root) {
  const items = () => [...root.querySelectorAll('.xo-list__item, tbody tr')]
    .filter((el) => el.getAttribute('aria-disabled') !== 'true' && !el.hidden);

  const select = (el, notify = true) => {
    if (!el) return;
    for (const i of items()) i.setAttribute('aria-selected', String(i === el));
    el.scrollIntoView({ block: 'nearest' });
    if (notify) {
      root.dispatchEvent(new CustomEvent('xo:select', {
        bubbles: true,
        detail: { value: el.dataset.value ?? null, item: el },
      }));
    }
  };

  const current = () => root.querySelector('[aria-selected="true"]');

  const move = (delta) => {
    const list = items();
    if (!list.length) return;
    const i = list.indexOf(current());
    select(list[(i + delta + list.length) % list.length]);
  };

  root.addEventListener('keydown', (e) => {
    const vertical = root.dataset.xoList !== 'horizontal';
    const prev = vertical ? 'ArrowUp' : 'ArrowLeft';
    const next = vertical ? 'ArrowDown' : 'ArrowRight';

    if (e.key === prev)            { e.preventDefault(); move(-1); }
    else if (e.key === next)       { e.preventDefault(); move(1); }
    else if (e.key === 'Home')     { e.preventDefault(); select(items()[0]); }
    else if (e.key === 'End')      { e.preventDefault(); select(items().at(-1)); }
    else if (e.key === 'Enter' || e.key === ' ') {
      const el = current();
      if (!el) return;
      e.preventDefault();
      root.dispatchEvent(new CustomEvent('xo:activate', {
        bubbles: true,
        detail: { value: el.dataset.value ?? null, item: el },
      }));
      el.querySelector('a, button')?.click();
    }
  });

  root.addEventListener('click', (e) => {
    const el = e.target.closest('.xo-list__item, tbody tr');
    if (el && root.contains(el)) select(el);
  });

  if (!root.hasAttribute('tabindex')) root.tabIndex = 0;
  if (!current()) select(items()[0], false);
}

/* --- Onglets ------------------------------------------------------------ */

function initTabs(root) {
  const tabs = [...root.querySelectorAll('[role="tab"]')];

  const show = (tab) => {
    for (const t of tabs) {
      const on = t === tab;
      t.setAttribute('aria-selected', String(on));
      t.tabIndex = on ? 0 : -1;
      const panel = document.getElementById(t.getAttribute('aria-controls'));
      if (panel) panel.hidden = !on;
    }
  };

  root.addEventListener('click', (e) => {
    const tab = e.target.closest('[role="tab"]');
    if (tab) show(tab);
  });

  root.addEventListener('keydown', (e) => {
    const i = tabs.indexOf(document.activeElement);
    if (i === -1) return;
    let next = null;
    if (KEY_NEXT.includes(e.key))      next = tabs[(i + 1) % tabs.length];
    else if (KEY_PREV.includes(e.key)) next = tabs[(i - 1 + tabs.length) % tabs.length];
    else if (e.key === 'Home')         next = tabs[0];
    else if (e.key === 'End')          next = tabs.at(-1);
    if (!next) return;
    e.preventDefault();
    next.focus();
    show(next);
  });

  show(tabs.find((t) => t.getAttribute('aria-selected') === 'true') ?? tabs[0]);
}

/* --- Modales ------------------------------------------------------------ */

function initDialogs(scope) {
  scope.addEventListener('click', (e) => {
    const opener = e.target.closest('[data-xo-open]');
    if (opener) {
      document.querySelector(opener.dataset.xoOpen)?.showModal();
      return;
    }
    if (e.target.closest('[data-xo-close]')) {
      e.target.closest('dialog')?.close();
    }
  });
}

/* --- Menus déroulants ---------------------------------------------------- */

/* Le <details> s'ouvre et se ferme nativement. On n'ajoute que ce que le
   navigateur ne fait pas : refermer sur Échap et au clic extérieur. */
function initDropdowns(scope) {
  const closeAll = (except = null) => {
    for (const d of document.querySelectorAll('.xo-dropdown[open]')) {
      if (d !== except) d.open = false;
    }
  };

  scope.addEventListener('click', (e) => {
    const inside = e.target.closest('.xo-dropdown');
    closeAll(inside);
    // Un choix dans le menu referme le menu.
    if (inside && e.target.closest('.xo-dropdown__item')) inside.open = false;
  });

  scope.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    const open = document.querySelector('.xo-dropdown[open]');
    if (!open) return;
    e.preventDefault();
    open.open = false;
    open.querySelector('summary')?.focus();
  });
}

/* --- Palette de commandes ------------------------------------------------ */

const isTyping = (el) =>
  el instanceof HTMLElement &&
  (el.isContentEditable || ['INPUT', 'TEXTAREA', 'SELECT'].includes(el.tagName));

function initPalette(root) {
  const input = root.querySelector('input');
  const list  = root.querySelector('[data-xo-list]');
  const empty = root.querySelector('.xo-palette__empty');
  const items = [...root.querySelectorAll('.xo-list__item')];

  // Mémorise le libellé d'origine : le filtrage y insère des <mark>.
  const labels = new Map(
    items.map((el) => [el, el.querySelector('.xo-palette__label') ?? el]),
  );
  const texts = new Map([...labels].map(([el, lab]) => [el, lab.textContent.trim()]));

  const filter = (q) => {
    const needle = q.trim().toLowerCase();
    let visible = 0;

    for (const el of items) {
      const text = texts.get(el);
      const at   = needle ? text.toLowerCase().indexOf(needle) : -1;
      const show = !needle || at !== -1;
      el.hidden = !show;
      if (show) visible++;

      const label = labels.get(el);
      if (!needle || at === -1) {
        label.textContent = text;
      } else {
        // textContent puis insertion du <mark> : aucune chaîne HTML concaténée.
        label.textContent = '';
        label.append(
          text.slice(0, at),
          Object.assign(document.createElement('mark'), {
            className: 'xo-mark',
            textContent: text.slice(at, at + needle.length),
          }),
          text.slice(at + needle.length),
        );
      }
    }

    if (empty) empty.hidden = visible > 0;

    // La sélection doit rester sur une ligne visible.
    const current = list?.querySelector('[aria-selected="true"]');
    if (!current || current.hidden) {
      const first = items.find((el) => !el.hidden);
      for (const el of items) el.setAttribute('aria-selected', String(el === first));
    }
  };

  input?.addEventListener('input', () => filter(input.value));

  // Les flèches et Entrée sont saisies dans le champ : on les relaie à la liste.
  input?.addEventListener('keydown', (e) => {
    if (!['ArrowUp', 'ArrowDown', 'Home', 'End', 'Enter'].includes(e.key)) return;
    e.preventDefault();
    list?.dispatchEvent(new KeyboardEvent('keydown', { key: e.key }));
  });

  root.addEventListener('close', () => {
    if (input) input.value = '';
    filter('');
  });

  root.addEventListener('xo:activate', () => root.close());
  root.addEventListener('click', (e) => {
    if (e.target.closest('.xo-list__item')) root.close();
  });
}

/* --- Raccourcis globaux -------------------------------------------------- */

function initShortcuts() {
  document.addEventListener('keydown', (e) => {
    // Ctrl+K / Cmd+K : palette
    if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
      const palette = document.querySelector('[data-xo-palette]');
      if (!palette) return;
      e.preventDefault();
      if (!palette.open) palette.showModal();
      palette.querySelector('input')?.focus();
      return;
    }

    // ? : aide — sauf pendant une saisie
    if (e.key === '?' && !isTyping(document.activeElement)) {
      const help = document.querySelector('[data-xo-help]');
      if (!help) return;
      e.preventDefault();
      if (!help.open) help.showModal();
    }
  });
}

/* --- Notifications ------------------------------------------------------- */

function initToasts(scope) {
  const dismiss = (toast) => {
    clearTimeout(Number(toast.dataset.xoTimer));
    toast.remove();
  };

  scope.addEventListener('click', (e) => {
    const btn = e.target.closest('.xo-toast__close');
    if (btn) dismiss(btn.closest('.xo-toast'));
  });

  for (const toast of scope.querySelectorAll('[data-xo-toast]')) {
    const delay = Number(toast.dataset.xoToast);
    if (delay > 0) toast.dataset.xoTimer = String(setTimeout(() => dismiss(toast), delay));
  }
}

/* --- Séparateur redimensionnable ----------------------------------------- */

function initSplit(root) {
  const handle = root.querySelector('.xo-split__handle');
  if (!handle) return;

  const setPercent = (pct) => {
    root.style.setProperty('--xo-split', `${Math.min(85, Math.max(15, pct))}%`);
    handle.setAttribute('aria-valuenow', String(Math.round(pct)));
  };

  const onMove = (e) => {
    const box = root.getBoundingClientRect();
    setPercent(((e.clientX - box.left) / box.width) * 100);
  };

  const stop = () => {
    document.removeEventListener('pointermove', onMove);
    document.removeEventListener('pointerup', stop);
  };

  handle.addEventListener('pointerdown', (e) => {
    e.preventDefault();
    document.addEventListener('pointermove', onMove);
    document.addEventListener('pointerup', stop);
  });

  handle.addEventListener('keydown', (e) => {
    const step = e.key === 'ArrowLeft' ? -5 : e.key === 'ArrowRight' ? 5 : 0;
    if (!step) return;
    e.preventDefault();
    const box  = root.getBoundingClientRect();
    const curr = (handle.getBoundingClientRect().left - box.left) / box.width * 100;
    setPercent(curr + step);
  });
}

/* --- Montage ------------------------------------------------------------ */

const mounted = new WeakSet();

export function mount(scope = document) {
  for (const el of scope.querySelectorAll('[data-xo-list]')) {
    if (!mounted.has(el)) { mounted.add(el); initList(el); }
  }
  for (const el of scope.querySelectorAll('[data-xo-tabs]')) {
    if (!mounted.has(el)) { mounted.add(el); initTabs(el); }
  }
  for (const el of scope.querySelectorAll('[data-xo-palette]')) {
    if (!mounted.has(el)) { mounted.add(el); initPalette(el); }
  }
  for (const el of scope.querySelectorAll('[data-xo-split]')) {
    if (!mounted.has(el)) { mounted.add(el); initSplit(el); }
  }
  initToasts(scope);
}

if (!mounted.has(document.body ?? document)) {
  initDialogs(document);
  initDropdowns(document);
  initShortcuts();
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => mount());
  } else {
    mount();
  }
}

export default { mount };
