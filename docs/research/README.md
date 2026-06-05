# University Drupal Research Repository

Harvested intelligence on how peer universities build their Drupal sites — the foundation
for designing a unique Tulane brand. Gathered via `curl`/`gh`/web (no subagents). See
[PROGRESS.md](PROGRESS.md) for the run log.

## Contents

### Cross-site (`_sweep/`)
- [patterns.md](_sweep/patterns.md) — fingerprint sweep of 20 universities: Drupal versions,
  themes, hosting, services, and the patterns they share.
- [region-block-and-seo.md](_sweep/region-block-and-seo.md) — page-composition architectures
  (Layout Builder vs. Layout Paragraphs) + SEO profiles + the structured-data gap.
- [computed-tokens-and-scroll.md](_sweep/computed-tokens-and-scroll.md) — **real CDP data**
  from running the harvester: computed font/weight/spacing tokens + header scroll behavior
  across 9 sites (Tulane & Cornell both use Freight; Harvard has an animated header).
- [fingerprints.md](_sweep/fingerprints.md) — raw fingerprint table.
- `html_*.html` — saved homepage HTML for offline analysis.

### YaleSites (deep dive — open source) (`yalesites/`)
- [design-tokens.md](yalesites/design-tokens.md) — full color palette (hex), typography,
  spacing, breakpoints, effects, and the theming system. **Ground truth, not CDP-guessed.**
- [modules.md](yalesites/modules.md) — the complete 100-module stack, categorized.
- `tokens-src/` — raw token source files (YAML/SCSS/JSON).
- `profile-composer.json`, `composer.json` — raw dependency manifests.

### Governance (all institutions)
- [governance-models.md](governance-models.md) — site-request process, the three-tier role
  model, user management, content responsibilities.

### Synthesis
- **[EXECUTIVE-SUMMARY.md](EXECUTIVE-SUMMARY.md)** — one-page stakeholder summary (start here).
- [synthesis.md](synthesis.md) — what it all means for Tulane: recommended stack, the brand
  foundation, and a gap analysis.
- [seo-schema-recommendation.md](seo-schema-recommendation.md) — Schema.org per content type.
- [interaction-patterns.md](interaction-patterns.md) — header/menu scroll + mobile patterns.

### Tulane (`tulane/`)
- [current-site.md](tulane/current-site.md) — teardown of the existing D10 Tailwind site.
- [brand-tokens.md](tulane/brand-tokens.md) — official palette + type + observed values.
- [component-deltas.md](tulane/component-deltas.md) — Tulane vs Yale computed-CSS.
- [component-backlog.md](tulane/component-backlog.md) — build plan w/ field schemas.

## Top-line findings
1. **Pantheon + Fastly + custom theme** is the higher-ed Drupal mainstream; **Drupal 11** is
   already widely adopted (Stanford, Harvard College, Penn, CU Boulder, Yale Law).
2. **A uniform service kit** recurs: Slate, Localist, Siteimprove, ServiceNow, Adobe Fonts,
   Qualtrics, Font Awesome.
3. **Two page-composition models**: Layout Builder + component system (Yale — most
   reskinnable) vs. Layout Paragraphs (Stanford).
4. **A three-tier governance model** (Author/Editor/Manager) + ServiceNow site-request →
   prebuilt accessible site is the operational norm.
5. **Nobody ships homepage JSON-LD** — a free SEO differentiator for Tulane.
6. **Yale's open-source platform** (tokens + Emulsify components + atomic theme + 100-module
   profile) is the single best blueprint to learn the *structure* from.

## Related design docs
- [../design-research.md](../design-research.md) — research strategy & methodology
- [../harvester-tooling.md](../harvester-tooling.md) — the Playwright/CDP tool design
- [../architecture-considerations.md](../architecture-considerations.md) — build context
