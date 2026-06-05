# Executive Summary — University Drupal Research

A one-page synthesis of the research in this folder, for stakeholders deciding the direction
of the Tulane web platform. Full detail in [README.md](README.md) and the linked docs.

## The situation

**Tulane already runs Drupal** (Drupal 10, Pantheon + Fastly, a Tailwind theme
`tulane_tailwindcss`, Layout Builder + Paragraphs, Slate, Freight typeface). Multiple Tulane
department subdomains (sse, liberalarts, medicine, …) run Drupal too. **This is an
evolution/redesign, not a new build** — and Tulane's platform already matches the higher-ed
mainstream.

## What peers do (42 universities profiled)

- **Stack mainstream:** Pantheon + Fastly + a bespoke theme + **Drupal 11** (Stanford,
  Harvard College, Penn, CU Boulder, Yale Law, UT Austin already on 11; Tulane on 10).
- **Universal service kit:** Slate (admissions), Localist (events), Siteimprove + Editoria11y
  (accessibility), ServiceNow (support/site-requests), Adobe Fonts, Qualtrics.
- **Governance is consistent:** request-a-site via IT ticket → a prebuilt, branded, accessible
  starter site; a **three-tier role model** (Author → Editor → Manager).
- **Two page-building models:** Layout Builder + a component system (Yale — most reskinnable)
  vs. Layout Paragraphs (Stanford). Tulane is in the Layout Builder camp.

## The reference: YaleSites (open source)

Yale publishes its whole platform — design tokens, ~30-component Emulsify library, 100-module
profile, the `atomic` theme. It's the best blueprint to **learn structure from** (we extracted
its real tokens, e.g. Yale Blue `#00356b`, and component prop contracts). **Caveat:** Yale is
SCSS/Emulsify; **Tulane is Tailwind** — adopt Yale's *taxonomy and token structure*, re-build
in Tailwind; don't drop in Yale's library.

## Tulane's gaps & opportunities

1. **Component breadth** — Tulane has ~5 components vs. Yale's ~30. The biggest gap. A
   prioritized build backlog with field schemas is ready in
   [tulane/component-backlog.md](tulane/component-backlog.md).
2. **Design tokens** — Tulane's styling is ad-hoc (serif/editorial identity, Freight; only
   400/700 weights; buttons fall back to **Arial**; tight spacing). Formalize a token system
   in `tailwind.config.js`; add a mid weight; fix buttons. See
   [tulane/component-deltas.md](tulane/component-deltas.md) and
   [tulane/brand-tokens.md](tulane/brand-tokens.md).
3. **Structured data (SEO)** — Tulane has site-level schema (`CollegeOrUniversity`/`WebSite`)
   but **lacks per-content-type schema** (NewsArticle, Course/Program, Event, Person) and it's
   inconsistent across subdomains. Low-effort win few peers claim —
   [seo-schema-recommendation.md](seo-schema-recommendation.md).
4. **Drupal 11 upgrade** — peers are on 11; Tulane on 10. Plan the upgrade to avoid legacy
   debt (some peers still run D7/D8).
5. **Interaction polish** — Tulane's header is a flat fixed bar; Harvard's shrink/hide-reveal
   is the modern reference — [interaction-patterns.md](interaction-patterns.md).

## Recommended direction

Keep Tulane's **Tailwind + Layout Builder + Pantheon** foundation. Then, in order:
**(1)** define the Tulane design-token system (brand palette + Freight + spacing scale);
**(2)** build out the component library from the backlog (governed Layout Builder);
**(3)** standardize per-content-type Schema.org; **(4)** plan the D11 upgrade;
**(5)** refine interaction/brand polish (buttons, header, motion). A request→Recipe-provisioned
starter-site pipeline (three-tier roles) operationalizes new department subdomains.

## Open decisions (need stakeholder input)

- Brand direction: **green-led** (heritage `#285C4D`) vs **teal/sky-led** (current site feel).
- D10 redesign vs **D11 upgrade** vs rebuild.
- Access to the private `tulane_tailwindcss` repo (for the authoritative token config).
- Subdomain scope: just `www`, or the department estate too.

## Confidence

Findings are evidence-based (live fingerprints, the open-source YaleSites code, and Playwright
computed-style/scroll captures). Limits noted per doc: headers-only fingerprints miss backend
modules; some flagship apexes are CDN-masked; a few sites (NYU) block headless capture; the
Tulane theme config itself is private. Treat brand/effort recommendations as directional,
pending the Tulane team's input.
