# Synthesis — What the Research Means for Tulane

Pulling the harvest together into a recommended direction, a brand foundation, and a gap
analysis. Sources: everything under `docs/research/`.

## 0. Starting reality — Tulane already runs Drupal

The sweep found **www.tulane.edu is already Drupal 10** (theme `tulane_tailwindcss`,
Pantheon+Fastly, Layout Builder + Paragraphs, Slate, Freight typeface) — see
[tulane/current-site.md](tulane/current-site.md). So this is an **evolution**, not a
greenfield build. Two consequences for everything below:

1. **Tulane is Tailwind; Yale is SCSS/Emulsify.** Adopt Yale's component *taxonomy* and
   *token structure*, but express tokens as **Tailwind theme config**, not SCSS — and do
   **not** drop in Yale's component library wholesale.
2. **The biggest gap is component breadth** (~5 components today vs. Yale's ~30), plus a
   formalized token system and possibly a **D11 upgrade**. Platform/hosting already match
   the peer mainstream.

## 1. Recommended platform stack (match the peer mainstream)

| Layer | Recommendation | Evidence |
|-------|----------------|----------|
| **Drupal core** | **11** | Stanford, Harvard College, Penn, CU Boulder, Yale Law already on 11 |
| **Hosting + CDN** | **Pantheon + Fastly** (or Acquia) | Dominant across the sweep |
| **Page building** | **Layout Builder + governed component system** | Yale's model; restrict by role |
| **Design system** | **Emulsify** component library + design tokens | Yale's foundation |
| **Admin UX** | **Gin** + moderation_sidebar + workflow_buttons | YaleSites stack |
| **Config** | config_split / config_ignore / config_filter | Multi-env config-as-code |
| **SEO** | metatag + pathauto + simple_sitemap + redirect | Universal |
| **Search** | Search API (+ Solr/OpenSearch) + better_exposed_filters | Universal |
| **A11y** | Editoria11y + reduced-motion tokens | Yale; ADA Title II driver |

## 2. The service integrations to plan for

Budget these early — they're the near-universal "higher-ed kit":
- **Slate (Technolutions)** — admissions CRM (nearly every peer)
- **Localist** — events calendar
- **Siteimprove** — accessibility + analytics monitoring
- **Qualtrics** — surveys
- **Adobe Fonts (Typekit)** — brand typography
- **ServiceNow** — IT support + the site-request pipeline
- **Font Awesome** — icons

## 3. Brand foundation — adopt structure, author Tulane values

The research gives a proven **structure**; Tulane's identity comes from new **values**.

### Token structure to adopt (from Yale's system)
- **Color:** a named primitive palette → semantic roles (background/text/heading) → **8-slot
  themes** with named global palettes. *Tulane values:* Tulane Green (`#006747`-family) +
  Tulane Blue (`#418FDE`-family) as the primitive palette; build named themes (e.g. "Uptown",
  "Audubon", "Mardi Gras" — Tulane-appropriate) on the same 8-slot model.
- **Type:** a serif display + a sans family, weights 400/500/700, body scale xl→xs.
  *Tulane values:* Tulane's brand typefaces (verify with Tulane brand guidelines) in the same
  pairing structure.
- **Spacing:** a numbered scale (1–12) + semantic responsive spacing (gutter / page-section /
  page-inner / banner). Adopt as-is; tune the rem values.
- **Breakpoints:** 576 / 768 / 992 / 1200 / 1400 — a sane default to adopt directly.
- **Motion:** reduced-motion-aware micro-interactions — card rise on hover, link underline
  slide, fade-in-up for quotes, divider expand. Adopt the *vocabulary*; restyle to taste.

### Component set to provide editors (from Emulsify inventory)
Atoms (controls, forms, images, lists, tables, typography) · Molecules (accordion, alert,
banner, callout, cards, facts-and-figures, link-grid, menu, pull-quote, quick-links,
related-content, social-links, tabs, tile, text-with-image) · Organisms (site-header,
site-footer, card-collection, galleries, menu, calendar, tiles, in-this-section).

### Page composition
Use **Layout Builder + a `data-component-*` attribute system** (Yale's approach) so one
component system serves many sub-brands across subdomains — the cleanest fit for "different
regions/blocks per content type and per subdomain."

## 4. Governance to implement
- **Three-tier roles:** Author (draft) → Editor (publish, others' content) → Manager (+ users
  + settings), via `role_delegation`. Publish is the privilege boundary.
- **Request → provisioned site:** a ServiceNow (or equivalent) request that triggers a
  **Recipe-provisioned**, pre-branded, accessible starter site (this is the `department_site`
  recipe use case — ties research back to the recipes work).
- **Hybrid model:** central team owns platform/brand/accessibility; departments own content.
- **Constrained Layout Builder:** `layout_builder_restrictions_by_role` + `layout_builder_lock`
  so flexibility never breaks the brand.

## 5. Gap analysis — where Tulane can beat peers

| Opportunity | Why it's open | Action |
|-------------|---------------|--------|
| **Homepage JSON-LD / Schema.org** | No peer ships it (sweep: 0 ld+json) | Add Schema.org Metatag (Organization/Course/Event/Person) |
| **Modern D11 from day one** | Many peers carry D7/D10 legacy (e.g. www.yale.edu on D7) | Start clean on 11 — no migration debt |
| **Unified design-token system across all subdomains** | Peers each have bespoke themes; sprawl is the norm | One token system + named sub-brand themes (Yale-style) for brand unity at scale |
| **AI-assisted editing/provisioning** | Only Yale shows `ai_engine` | The MCP/Drush + recipes workflow already set up positions Tulane here |
| **Accessibility as a launch gate** | ADA Title II deadline (Apr 2027) looms for all | Editoria11y + reduced-motion + min tap targets baked into the token system |

## 6. Recommended next steps (when you're back)
1. **Confirm Tulane brand inputs** — official palette hex + typefaces from Tulane brand
   guidelines (the research gives the *structure*; these are the *values*).
2. **Decide hosting** — Pantheon vs. Acquia vs. self-host (drives the YaleSites-adoption
   question).
3. **Spike the design layer** — clone Yale's `tokens` + `component-library-twig` + `atomic`
   and see how cleanly the system reskins with Tulane tokens.
4. **Run the Playwright harvester** (scaffolded in `tools/harvester/`) against the masked
   sites (Harvard College, Penn, Cornell, Oxford subdomains) to capture computed tokens +
   scroll behavior the headers-only pass couldn't reach.
5. **Author the first recipes** — `tulane_person`, `tulane_program`, `editorial_workflow`,
   `accessibility_defaults` → compose into `department_site`.
