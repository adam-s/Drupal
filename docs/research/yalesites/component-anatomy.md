# YaleSites — Component Anatomy (for Tulane re-implementation)

How a Yale Emulsify component is structured, so we can re-implement the same *contract* in
Tulane's **Tailwind** theme (Tulane is Tailwind, not SCSS/Emulsify — adopt the structure, not
the toolchain). Source files saved in `components-src/`.

## The repeating component pattern

Every molecule is a folder with a consistent file set:

| File | Role | Tulane equivalent |
|------|------|-------------------|
| `yds-<name>.twig` | wrapper markup (loops items, sets attributes) | Twig template in `tulane_tailwindcss` |
| `_yds-<name>.twig` | single-item markup (included per item) | partial |
| `<name>-props.yml` | **prop contract** — single source of truth for Storybook + docs | the Paragraph/SDC field schema |
| `<name>.yml` | demo data | preview/sample content |
| `_yds-<name>.scss` | styles | **Tailwind classes / `tailwind.config` tokens** |
| `<name>.mdx` | docs | component README |

**Key idea:** appearance is driven by **`data-component-*` attributes reading from design
tokens**, not per-instance CSS. A component sets `data-component-theme`,
`data-component-width`, `data-component-alignment`, and the token CSS does the rest. This is
why the whole library reskins by swapping tokens — and it's the property Tulane should
replicate (Tailwind theme tokens + data-attributes or utility variants).

## Example 1 — Callout

**Markup shape:** a `callouts` wrapper sets attributes and loops `callouts[]`, including
`_yds-callout.twig` per item. Optional overlay background image via a CSS custom property.

**Prop contract** (`callout-props.yml`):
| Prop | Type | Options / default |
|------|------|-------------------|
| `callout__heading` | string | — |
| `callout__text` | string | — |
| `callout__link__content` | string | — |
| `callout__link__type` | select | `cta` (default) / `link` |
| `callout__background_color` | select (theme) | `one`–`five` (from component-themes tokens) |
| `callout__alignment` | select | `left` / `center` (default) |
| `callout__overlay_background_image` | boolean | default false |

Attributes emitted: `data-component-theme`, `data-component-width`,
`data-component-alignment` + BEM `callouts` class.

## Example 2 — Facts & Figures

**Presentation styles:** `basic` / `with-icon` / `icon-only` (via
`data-facts-and-figures-style`). Renders each stat as an `<li>` with an optional icon
(`@atoms/images/icons`) + stat + content. Props: `facts_and_figures__stat`, `__content`,
`__has_icon`, `__icon_name`, `__alignment`, `__theme` (one…), `__presentation_style`.

Same token-attribute pattern (`data-component-theme`, `data-component-alignment`).

## Re-implementation guidance for Tulane (Tailwind)

For each Yale component Tulane wants parity with:
1. **Port the prop contract** → define the equivalent Paragraph type (or Single Directory
   Component) fields in Drupal. The `*-props.yml` *is* the field list.
2. **Port the variants** → Yale's `theme one–five`, `alignment left/center`, `width
   site/content`, link `cta/link` become Tulane field options / Tailwind variant classes.
3. **Map tokens, not CSS** → instead of Yale's SCSS, express the same spacing/type/color via
   **`tailwind.config.js` theme tokens** + utility classes; keep the `data-component-theme`
   attribute approach so one component supports multiple sub-brand palettes (the multi-
   subdomain goal).
4. **Keep the wrapper/item split** → wrapper sets layout + theme attributes; item renders
   content. Maps cleanly to Drupal Paragraph (wrapper) + field rendering (item).

## Priority components to build first (Tulane gap)
Tulane currently has hero, image-and-text, quick-links. Highest-value additions (by peer
ubiquity + editorial value): **cards** (custom / reference / directory-listing variants),
**callout**, **facts-and-figures**, **pull-quote**, **accordion**, **tabs**,
**related-content**, **tiles/card-collection**, **in-this-section** (secondary nav). Each has
a documented Yale prop contract to copy.
