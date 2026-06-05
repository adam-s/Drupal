# YaleSites — Component Inventory (Emulsify atomic design)

From `component-library-twig/components/`. The full set of UI components Yale offers editors —
the "chips, cards, menus, sections" catalog. Browse live:
https://yalesites-org.github.io/component-library-twig

## Atoms (`01-atoms`)
controls · date-time · divider · forms · images · lists · tables · typography · videos

## Molecules (`02-molecules`)
accordion · alert · banner · callout · cards · content-spotlight-portrait · embed ·
facts-and-figures · image · inline-message · link-grid · link-group · link-skip · menu ·
meta · modal · page-title · pager · pull-quote · quick-links · quote-callout · read-time ·
related-content · search-result · social-links · tabs · taxonomy-display · text-with-image ·
text · tile-item · video · wrapped-callout · wrapped-image

## Organisms (`03-organisms`)
block-wrapper · calendar · card-collection · component-wrapper · custom-card-collection ·
facts-and-figures-group · galleries · layout · menu · site-footer · site-header ·
site-in-this-section (secondary/section nav) · tiles

## Page layouts (`04-page-layouts`)
full-width templates · placeholder · page examples

## Mapping to render (confirmed from live HTML)
The live `yalesites.yale.edu` markup shows these components rendered through **Layout
Builder** with a `data-component-*` attribute system:
- `data-component-width` (33×) · `data-component-alignment` (26×) ·
  `data-component-variation` (14×) · `data-component-theme` (9×) ·
  `data-component-has-overlay` · `data-component-has-image` · `data-component-grid-count`
- Every block wrapped in `block-wrapper` with `--padding-*` modifiers.
- Layouts: `layout--onecol`, `layout--banner`.

So a component's appearance is driven by **attributes (width / alignment / variation / theme /
padding)** reading from the [design tokens](design-tokens.md), not bespoke per-instance CSS.
This is the key reskinnability property: change tokens → all components restyle.

## Tulane mapping (component parity checklist)
A Tulane build should provide editors at least: cards, card-collection, banner/hero, callout,
quick-links, facts-and-figures, pull-quote, accordion, tabs, related-content, social-links,
tile/tiles, text-with-image, menu, site-header, site-footer, site-in-this-section, calendar,
galleries, page-title, alert. (Direct parity with Yale's offering.)
