# Tulane Component Build Backlog

A build plan to expand Tulane's component library from its current ~5 (hero, image-and-text,
quick-links, svg-standalone, basic) toward a Yale-class set. Each component's **field schema
is derived from Yale's prop contract** (`yalesites/components-src/props-*.yml`); implement as a
Drupal **Paragraph type** (or Single Directory Component) in the `tulane_tailwindcss` theme.

> Pattern (from [../yalesites/component-anatomy.md](../yalesites/component-anatomy.md)):
> wrapper sets layout + **theme** + alignment attributes; items render content. Express
> Yale's `theme one–five` and `data-component-*` as Tailwind variant classes / config tokens
> so one component supports multiple sub-brand palettes.

## Priority order (impact × effort)

| # | Component | Impact | Effort | Why |
|---|-----------|--------|--------|-----|
| 1 | **Cards + Card Collection** | High | Med | The workhorse of every university page; biggest visible gap |
| 2 | **Callout** | High | Low | High-visibility CTA blocks; simple schema |
| 3 | **Accordion** | High | Low | FAQ/program details; cheap, ubiquitous |
| 4 | **Related content** | High | Low | Cross-linking; mostly wraps a View |
| 5 | **Facts & figures** | Med | Low | "By the numbers" stats; strong for marketing pages |
| 6 | **Tabs** | Med | Med | Dense program/department info |
| 7 | **Pull-quote** | Med | Low | Editorial polish |
| 8 | **In-this-section (secondary nav)** | High | Med | Section wayfinding — key for deep dept sites/subdomains |
| 9 | **Tiles** | Med | Med | Visual nav grids |

## Field schemas (Drupal Paragraph types)

### 1. Card / Reference Card (`paragraph: card`)
From `reference-card` + `card-collection` contracts.
- `field_card_heading` — string (req)
- `field_card_snippet` — text (long)
- `field_card_eyebrow` — string (optional kicker)
- `field_card_image` — media/image (boolean toggle in Yale; here a field)
- `field_card_link` — link
- **Collection wrapper** (`paragraph: card_collection`): `field_cc_heading` (string),
  `field_cc_type` — list: **grid / list / condensed**, `field_cc_featured` (bool),
  `field_cc_with_images` (bool), `field_cards` — entity-ref revisions (cards).
- **Tailwind:** grid via `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-*`; list =
  stacked; condensed = tighter padding. Card = `rounded-* border shadow-* p-*` (decide radius
  per brand-tokens). Hover: lift (`hover:-translate-y-1 transition`).

### 2. Callout (`paragraph: callout`)
From `callout-props.yml`.
- `field_callout_heading` — string
- `field_callout_text` — text
- `field_callout_link` — link, with `field_callout_link_type` list: **cta / link**
- `field_callout_theme` — list: **one…five** (maps to color theme)
- `field_callout_alignment` — list: **left / center**
- `field_callout_overlay_image` — media (optional background)
- **Tailwind:** themed bg via `data-theme` + config colors; `text-center`/`text-left`;
  CTA button vs text link variant.

### 3. Accordion (`paragraph: accordion`)
From `accordion-props.yml`.
- `field_accordion_heading` — string
- `field_accordion_items` — multi-value paragraph `accordion_item`:
  - `field_item_heading` — string, `field_item_content` — text (long)
- `field_accordion_theme` — list: **default / one…five**
- **Tailwind + a11y:** `<details>/<summary>` or button + `aria-expanded`; animate height;
  respect `prefers-reduced-motion`. (Match Yale's accessible disclosure.)

### 4. Related content (`paragraph: related_content`)
From `related-content-props.yml`.
- `field_rc_heading` — string
- `field_rc_view` — **reference to a Drupal View** (e.g. "related news/programs") + a
  result-limit number. (Mostly wraps an existing View — low effort.)
- **Tailwind:** reuse the card grid.

### 5. Facts & figures (`paragraph: facts_and_figures`)
From `facts-and-figures-props.yml`.
- `field_ff_items` — multi-value paragraph `fact`:
  - `field_fact_stat` — string (the number), `field_fact_content` — string (label)
  - `field_fact_icon` — string (icon name), shown when style = with-icon/icon-only
- `field_ff_presentation_style` — list: **basic / with-icon / icon-only**
- `field_ff_alignment` — list: **left / center**, `field_ff_theme` — list one…
- **Tailwind:** responsive grid; large stat type (use display weight); icon via existing
  Font Awesome (already on Tulane).

### 6. Tabs (`paragraph: tabs`)
From `tabs-props.yml` + tab twig.
- `field_tabs_theme` — list one…five
- `field_tabs_items` — multi-value paragraph `tab`: `field_tab_label` (string),
  `field_tab_content` (text/entity-ref)
- **Tailwind + a11y:** ARIA tablist/tab/tabpanel; keyboard arrow nav.

### 7. Pull-quote (`paragraph: pull_quote`)
From `pull-quote.yml` (minimal): `field_quote` — text, `field_attribution` — string,
optional `field_quote_image`. **Tailwind:** large serif (Tulane's Freight serif), fade-in-up
on scroll (copy Yale's effect).

### 8. In-this-section secondary nav (`block/region`, not a paragraph)
From `site-in-this-section-props.yml`: theme variants **in_content / in_header / one…five**.
A menu block scoped to the current section — render the active menu subtree. **Tailwind:**
sticky sidebar on desktop, collapsible on mobile. High value for deep department subdomains.

### 9. Tiles (`paragraph: tiles`)
From `tiles-props.yml`.
- `field_tiles_presentation_style` — list: **heading / icon / text-only**
- `field_tiles_alignment` — list: left/center/right; `field_tiles_vertical_alignment` —
  top/bottom
- `field_tiles_grid_count` — list: **two / three / four**
- `field_tile_with_image` (bool), `field_tiles_with_animation` (bool)
- `field_tiles_items` — multi-value tile (heading, icon/image, link)
- **Tailwind:** `grid-cols-{2,3,4}`; optional entrance animation (reduced-motion aware).

## Cross-cutting build notes
- **Theme tokens first:** define the color/spacing/type tokens in `tailwind.config.js`
  (per [brand-tokens.md](brand-tokens.md)) before building components, so every component
  reads the same system (the property that makes Yale reskinnable).
- **Constrain Layout Builder:** add `layout_builder_restrictions(_by_role)` so editors can
  place these components but not break the brand (Yale's governance pattern from
  [../yalesites/modules.md](../yalesites/modules.md)).
- **Accessibility built-in:** accordion/tabs/in-this-section need correct ARIA + keyboard +
  reduced-motion — bake in from the start (ADA Title II).
- **Each component ships with a preview + the field schema in config** (exported to
  `config/sync`).

## Confidence
- Field schemas are **directly derived** from Yale's published prop contracts (high
  confidence on the *contract*; exact Drupal field types are a sensible mapping, adjust to
  Tulane's editorial needs).
- Effort/impact ordering is judgment — validate with Tulane's content team.
