# uni-drupal-harvester

Playwright/CDP tools that profile university Drupal sites — region/block structure, computed
design tokens, header/menu scroll behavior, SEO posture, and module + third-party-service
fingerprints — into one comparable `SiteProfile` JSON per site.

Built to the spec in [`../../docs/harvester-tooling.md`](../../docs/harvester-tooling.md),
following the `prairielearn-debug` conventions (explicit token-optimized capture,
render-gating, json reporter).

## Setup
```bash
cd tools/harvester
npm install
npx playwright install chromium
```

## Run
```bash
npm run harvest                       # profile the default target list
HARVEST_TARGETS="https://college.harvard.edu/,https://www.cornell.edu/" npm run harvest
```
Output: `out/<site>/profile.json` + token-optimized screenshots in `out/screenshots/`.

## Primitives (`src/`)
| File | Extracts |
|------|----------|
| `gotoRendered.ts` | render-gating + Drupal detection |
| `shot.ts` | token-optimized screenshot (sharp downscale ~1024px) |
| `regions.ts` | region/block structure + layout system (LB vs Layout Paragraphs) |
| `tokens.ts` | computed design tokens (spacing/type/weight/color) |
| `scroll.ts` | header/menu scroll behavior (sticky/shrink/hide-reveal) |
| `seo.ts` | meta/OG/JSON-LD/sitemap/robots |
| `fingerprint.ts` | Drupal core/theme/hosting/modules |
| `services.ts` | third-party services (signature catalog in `signatures/services.json`) |

## Why this exists
The headers-only sweep (see `../../docs/research/_sweep/`) already fingerprinted 20 sites.
This adds what only a real browser can: **computed style tokens**, **scroll/menu animation**,
and **region/block structure on JS-heavy sites** (Harvard College, Penn, Cornell, Oxford
subdomains) the curl pass couldn't read.

## Guardrails
Serial (`workers: 1`), generous timeouts, identifying UA, public pages only, single pass.
Add polite delays before scaling to many subdomains. Tag inferred findings by confidence.

## Adding a service signature
Append one entry to `signatures/services.json` (`category`, `name`, `patterns`). No code change.
