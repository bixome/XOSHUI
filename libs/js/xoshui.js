/* ==========================================================================
   XOSHUI 1.0 — comportements. Module ES, aucune dépendance.
   <script type="module" src="/libs/js/xoshui.js"></script>

   Tout se déclare en HTML :
     [data-xo-list]            navigation ↑↓, sélection, événement "xo:select"
     [data-xo-tabs]            onglets ←→, bascule des [role="tabpanel"]
     [data-xo-open="#id"]      ouvre la <dialog> ciblée
     [data-xo-close]           ferme la <dialog> parente
     .xo-dropdown              <details> : Échap et clic extérieur referment
   ========================================================================== */

const KEY_PREV = ['ArrowUp', 'ArrowLeft'];
const KEY_NEXT = ['ArrowDown', 'ArrowRight'];

/* --- Listes ------------------------------------------------------------- */

function initList(root) {
  const items = () => [...root.querySelectorAll('.xo-list__item, tbody tr')]
    .filter((el) => el.getAttribute('aria-disabled') !== 'true');

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

/* --- Montage ------------------------------------------------------------ */

const mounted = new WeakSet();

export function mount(scope = document) {
  for (const el of scope.querySelectorAll('[data-xo-list]')) {
    if (!mounted.has(el)) { mounted.add(el); initList(el); }
  }
  for (const el of scope.querySelectorAll('[data-xo-tabs]')) {
    if (!mounted.has(el)) { mounted.add(el); initTabs(el); }
  }
}

if (!mounted.has(document.body ?? document)) {
  initDialogs(document);
  initDropdowns(document);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => mount());
  } else {
    mount();
  }
}

export default { mount };
