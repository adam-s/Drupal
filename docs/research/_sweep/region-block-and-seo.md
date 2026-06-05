# Region/Block Architecture & SEO — Cross-Site Findings

Extracted from saved homepage HTML of confirmed-Drupal sites (raw files: `html_*.html` in
each site dir). Architecture from region/block/component class signatures; SEO from `<head>`,
`sitemap.xml`, `robots.txt`.

## Region / block / layout architecture

Two dominant page-composition approaches emerged:

### Pattern A — Layout Builder + component system (Yale, CU Boulder)
- **Yale `atomic`** — the most refined: Drupal **Layout Builder** (`layout__region`,
  `layout--onecol`, `layout--banner`) wrapping a **component system** driven by `data-*`
  attributes:
  - `data-component-width` (33×), `data-component-alignment` (26×),
    `data-component-variation` (14×), `data-component-theme` (9×),
    `data-component-has-overlay`, `data-component-has-image`, `data-component-padding`,
    `data-component-grid-count`.
  - Every block wrapped in `block-wrapper` with padding modifiers
    (`--padding-default/no-padding/no-top/no-bottom`).
  - This is the token/theming system from `yalesites/design-tokens.md` rendered into markup —
    components read theme + spacing from attributes, not hardcoded CSS.
- **CU Boulder `boulder_base`** — Layout Builder with **inline blocks**
  (`block-layout-builder`, `block-inline-blocktext-block`, `block-block-content`,
  `block-content`/`block-body`) and title components (`block-title-text/outer`).

### Pattern B — Layout Paragraphs (Stanford)
- **Stanford `undergrad`** (Jumpstart/Stanford profile) — uses the **Layout Paragraphs**
  contrib module instead of pure Layout Builder:
  - `layout--layout-paragraphs-{one,two,three}-column`,
    `paragraph--type--stanford-{layout,wysiwyg,entity}`.
  - Clear named **regions**: `region--main`, `region--sidebar`, `region-header`,
    `region-search`, `region-menu`.
  - Blocks namespaced to the subtheme (`block-vpue-undergrad-subtheme-*`) + `block-jumpstart-ui`
    → confirms the **open-source Stanford "Jumpstart"** platform.

### Inconclusive (need CDP/browser)
- **Harvard College** (447 KB page) and **Penn** — no standard Drupal region/block classes
  matched; likely heavier custom/decoupled markup or JS-built DOM. These are exactly the
  cases the Playwright harvester is for.

### Takeaway for Tulane
The two viable architectures are **Layout Builder + a data-attribute component system**
(Yale's approach — most reskinnable) vs. **Layout Paragraphs** (Stanford — editor-friendly
nested layouts). Yale's `data-component-*` pattern is the stronger model for "one system,
many sub-brands across subdomains."

## SEO profiles

| Site | Title pattern | Meta desc | Open Graph | JSON-LD | sitemap.xml | robots.txt |
|------|---------------|-----------|------------|---------|-------------|------------|
| yalesites.yale.edu | `Page \| YaleSites` | — | type, url | **none** | ✅ 200 | 36 directives |
| undergrad.stanford.edu | `Undergrad` | ✅ full | image, title, type, url | **none** | ✅ 200 | 45 directives |
| www.colorado.edu | `Home \| University of Colorado Boulder` | ✅ full | description, image, title | **none** | ✅ 200 | 33 directives |

### Patterns
- **XML sitemaps everywhere** (HTTP 200) — the **Simple XML Sitemap** module is standard.
- **`Title | Site` title templates** — the **Metatag** module token pattern.
- **Open Graph present but inconsistent** — Stanford most complete (image+title+type+url),
  Yale minimal.
- **Canonical URLs on all.**
- **robots.txt** with many directives — standard Drupal robots plus custom disallows.

### Notable gap / opportunity
**None of the three emit JSON-LD structured data (schema.org) on the homepage** (0 `ld+json`
blocks). Even top universities skip Organization/Course/Event structured data — so
**implementing Schema.org Metatag for Tulane (Organization, Course, Event, Person) is a
low-effort SEO differentiator** few peers bother with.

## Method notes
- Homepage-only; structured data may exist on interior Program/Event pages even when absent
  from the homepage — worth re-checking per content type with the browser harvester.
- Raw HTML saved per site for deeper offline analysis.
