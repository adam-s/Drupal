# Overnight Research Progress Log

Autonomous harvest of university Drupal sites → organized into `docs/research/`.
No subagents; gathered with `curl` / `gh` / web fetches.

## Status legend
✅ done · 🔄 in progress · ⏳ queued

## Plan & status
1. ✅ Set up `docs/research/` structure
2. ✅ Yale design tokens (colors+hex, type, spacing, breakpoints, effects, themes) → `yalesites/design-tokens.md`
3. ✅ Yale component inventory → `yalesites/component-inventory.md`
4. ✅ Yale module list (100 contrib modules) → `yalesites/modules.md`
5. ✅ Fingerprint sweep — 20 + 22 universities → `_sweep/patterns.md`, `_sweep/fingerprints*.md`
6. ✅ Region/block + SEO extraction (5 sites) → `_sweep/region-block-and-seo.md`
7. ✅ Governance docs (site-request, roles, user mgmt) → `governance-models.md`
8. ✅ **Tulane current-site teardown** → `tulane/current-site.md`  ← KEY FINDING
9. ✅ Scaffold Playwright harvester (runnable) → `tools/harvester/`
10. ✅ **RAN the harvester** on 9 sites → computed tokens + scroll behavior →
    `_sweep/computed-tokens-and-scroll.md` (profiles in `tools/harvester/out/`)
11. ✅ Cross-site synthesis + gap analysis + brand foundation → `synthesis.md`
12. ✅ Research index → `README.md`

## 🔑 Headline discoveries
- **Tulane already runs Drupal 10** (`tulane_tailwindcss` Tailwind theme, Pantheon+Fastly,
  Layout Builder + Paragraphs, Slate, **Freight** typeface). Project = **evolution, not
  greenfield.** Biggest gap = component breadth (~5 vs Yale's ~30) + formal token system.
- **Tulane is Tailwind, Yale is SCSS/Emulsify** → adopt Yale's *taxonomy + token structure*,
  re-implement in Tailwind. Do NOT drop in Yale's component library wholesale.
- **Yale is fully open source** — extracted real tokens (Yale Blue `#00356b`), 100-module
  profile, full component library. Best blueprint to learn *structure* from.
- **Peer mainstream = Pantheon + Fastly + custom theme + Drupal 11.** Tulane already on
  Pantheon+Fastly (D10).
- **Uniform service kit:** Slate, Localist, Siteimprove, ServiceNow, Adobe Fonts, Qualtrics,
  Font Awesome.
- **Three-tier governance** (Author/Editor/Manager) + ServiceNow request → prebuilt site.
- **Nobody ships homepage JSON-LD** — free SEO win (Tulane already has 1 block).

## Wave 2 (this run) — ✅ done
- ✅ Harvester on **interior/long pages** (Tulane news/academics/events, Yale doc, Stanford
  program) → `tools/harvester/out-interior/`. Finding: Tulane = simple fixed 80px sticky (no
  animation); **no interior page has JSON-LD** (SEO gap confirmed across content types).
- ✅ **Component anatomy** — read Yale callout + facts-and-figures Twig/props → re-implementation
  guidance for Tulane Tailwind → `yalesites/component-anatomy.md` (sources in `components-src/`).
- ✅ **Breadth via browser** — Oxford depts (D7/D10/D11 — confirmed Drupal at dept level), Duke,
  NYU (shrink header), Berkeley, Stanford GSB (D8) → `_sweep/fingerprints-browser.md`.
- ✅ **Interaction patterns** doc (header/menu scroll archetypes) → `interaction-patterns.md`.

## Wave 3 (this run) — ✅ done
- ✅ **Schema.org/SEO recommendation** → `seo-schema-recommendation.md` (content-type → @type
  mapping; confirmed no peer ships homepage OR interior JSON-LD).
- ✅ **Tulane brand tokens** → `tulane/brand-tokens.md`. Theme repo is **private** (not on
  public GitHub) — used official brand guide (Tulane Green `#285C4D`, Blue `#71C5E8`, +
  secondaries) + harvested computed colors. Freight type confirmed.
- ✅ **Improved scroll capture** (offsets 0/400/1000/2000 + scroll-up) → confirmed Harvard
  shrink+pin (105→72px), Penn absolute→fixed, Tulane fixed-80 (no anim); NYU was a selector
  artifact (noted). Mobile 375px hamburger probe (all 4 sites have one; Yale = 16 accessible
  toggles). → updated `interaction-patterns.md`.
- ✅ **Component computed-CSS deltas** Tulane vs Yale → `tulane/component-deltas.md`
  (Tulane serif/editorial + 96px h1 + Arial-fallback buttons; Yale sans/modern; both radius 0).

## Wave 4 (this run) — ✅ done
- ✅ **Tulane component backlog** (field schemas per Yale prop contracts, impact×effort order)
  → `tulane/component-backlog.md` (Yale prop files saved in `yalesites/components-src/`).
- ✅ **JSON-LD spot-check correction** — Tulane subdomains DO emit site-level schema
  (CollegeOrUniversity/WebSite/EducationalOrganization); gap is **per-content-type** +
  inconsistent across subdomains. Updated `seo-schema-recommendation.md`.
- ✅ **Header-selector fix** in `scroll.ts` (scored, tags `data-harvest-header`) — validated:
  Berkeley now 42px (was a 5478px artifact), Harvard consistent. **NYU render-gates in
  headless** (unconfirmed — honest). Updated `interaction-patterns.md`.
- ✅ **Executive summary** (1 page, stakeholder-facing) → `EXECUTIVE-SUMMARY.md`.

## Wave 5 (this run) — ✅ done
- ✅ **Recipe drafts** (review proposals, NOT applied) → `tulane/recipe-drafts/`:
  tulane_person/program/event, editorial_workflow, accessibility_defaults, department_site.
- ✅ **Visual component catalog** (downscaled screenshots) → `_catalog/` + README. Grounded a
  correction: **Tulane homepage is green-led** (not teal) — updated `tulane/brand-tokens.md`.
  Also: Yale hero has dual CTAs, Tulane's has none.
- ✅ **Phased roadmap** → `tulane/roadmap.md` (decisions → tokens → components → SEO → D11 → polish).

## ✅ RESEARCH PHASE COMPLETE — stopping the autonomous loop
After 5 waves the research repo is comprehensive (stack, modules, tokens, components,
governance, interaction, SEO, Tulane teardown + brand + deltas + backlog + recipe drafts +
roadmap, a working harvester, and an executive summary). **Further autonomous waves would be
low-value** — the remaining work needs **your decisions**, not more research:
- D10 redesign vs **D11 upgrade** vs rebuild.
- Access to the private `tulane_tailwindcss` repo (authoritative tokens).
- Brand direction (green-led confirmed; how much teal/sky accent).
- Subdomain scope; hosting confirmation.
- Then: **build** (Phase 1 tokens → Phase 2 components), which is implementation, not research.

No further wakeups scheduled. Start at [EXECUTIVE-SUMMARY.md](EXECUTIVE-SUMMARY.md) →
[tulane/roadmap.md](tulane/roadmap.md). Nothing committed (left for your review).

## Notes for the morning
- Everything is on disk under `docs/research/` + `tools/harvester/`; nothing committed
  (left for your review). Raw HTML + token sources saved for offline re-analysis.
- Open questions to confirm: Tulane theme repo access, D10-redesign vs D11-upgrade vs
  rebuild, official Tulane brand palette/type, subdomain scope.
- Markdown lint warnings in docs are cosmetic (table spacing / bare URLs); content is sound.
