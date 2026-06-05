# Cross-Site Fingerprint Sweep — Patterns

Headers + markup fingerprint across 20 university sites (raw table in
[`fingerprints.md`](fingerprints.md)). Single polite request each. Versions/themes/hosting
from `X-Generator`, asset paths, and HTTP headers; services from markup signatures.

## Confirmed-Drupal sites & their stacks

| Site | Drupal | Theme (custom) | Hosting | Key services |
|------|--------|----------------|---------|--------------|
| vpuefacstaff.stanford.edu | **11** | — | Acquia | Localist, ServiceNow, Slate, FontAwesome |
| sustainability.stanford.edu | 10 | — | Acquia | Localist, ServiceNow, FontAwesome |
| undergrad.stanford.edu | **11** | — | Acquia | Localist, Slate, FontAwesome |
| gse.harvard.edu | 10 | `harvardgse` | self-hosted | Slate |
| seas.harvard.edu | 10 | `seas` | Pantheon+Fastly | Localist, Siteimprove, Slate |
| college.harvard.edu | **11** | `harvard_college` | Pantheon+Fastly | Siteimprove, Slate |
| yalesites.yale.edu | 10 | `atomic` | Pantheon+Fastly | Editoria11y, Siteimprove |
| www.yale.edu | **7** (legacy) | — | Pantheon+Fastly | — |
| law.yale.edu | **11** | `yls_main` | Pantheon+Fastly | FontAwesome |
| ets.osu.edu | 10 | `osu_kinetic` | Pantheon+Fastly | ServiceNow, FontAwesome |
| www.osu.edu | yes | — | — | Qualtrics, Slate |
| www.brown.edu | 10 | `brown` | Pantheon+Fastly+CF | Typekit |
| www.upenn.edu | **11** | `penn_global` | Pantheon+Fastly | Slate |
| www.colorado.edu | **11** | `boulder_base` | Pantheon+Fastly | Localist, Slate, FontAwesome |
| www.arizona.edu | yes | `az_barrio` | Pantheon+Fastly | Slate, Typekit, FontAwesome |
| www.princeton.edu | 10 | `hobbes` | Acquia+CF | Typekit |

**Masked / not-Drupal-on-apex** (need CDP or subdomain targeting): news.stanford.edu (CF),
medicine.yale.edu, www.cornell.edu (Kaltura/Siteimprove/Slate present), www.georgetown.edu
(Pantheon+Fastly, Typekit) — likely Drupal but generator stripped.

## Patterns that repeat across institutions

### Hosting: Pantheon + Fastly dominates
The overwhelmingly common stack is **Pantheon (with Fastly CDN)**; **Acquia** is the main
alternative (Stanford, Princeton); a few self-host (Harvard GSE). Implication for Tulane:
Pantheon is the higher-ed default — relevant to the earlier "should we adopt YaleSites"
question (YaleSites *is* a Pantheon upstream).

### Drupal 11 adoption is already underway
Stanford, Harvard College, Yale Law, Penn, CU Boulder are on **D11** — Tulane's target
version is current and well-supported by peers. (Yale's flagship www.yale.edu is still on
**Drupal 7** — even elite institutions carry legacy; a multi-platform reality.)

### Service stack is remarkably uniform (the "higher-ed Drupal kit")
- **Slate (Technolutions)** — admissions CRM — nearly everywhere.
- **Localist** — events — Stanford, Harvard SEAS, CU Boulder.
- **Siteimprove** — accessibility/analytics — Harvard, Yale, Cornell.
- **ServiceNow** — IT support — Stanford, Ohio State.
- **Adobe Fonts (Typekit)** — brand type — Brown, Princeton, Arizona, Cornell, Yale Med.
- **Font Awesome** — icons — ubiquitous.
- **Qualtrics** — surveys — Ohio State.
- **Editoria11y** — Yale's own a11y checker.

### Every site has a bespoke custom theme
No two share a theme: `harvardgse`, `seas`, `harvard_college`, `atomic`, `yls_main`,
`osu_kinetic`, `brown`, `penn_global`, `boulder_base`, `az_barrio`, `hobbes`. Several are
**open-source platforms** worth studying alongside Yale:
- **`boulder_base`** (CU Boulder) — CU's open Drupal platform.
- **`az_barrio`** (Arizona) — Arizona's open-source Bootstrap-based theme + `arizona-profile`.
- **`atomic`** (Yale) — already in our deep-dive.

### Even one institution spans versions & stacks
Yale alone: `yalesites` D10 (Pantheon), `www.yale.edu` D7, `law.yale.edu` D11 (different
theme `yls_main`). Confirms the "many subdomains, many independent builds" reality — and why
per-subdomain profiling matters.

## Implications for the Tulane foundation

1. **Target Pantheon + Fastly + Drupal 11** to match the peer mainstream.
2. **Budget for the standard service integrations** early: Slate, Localist, Siteimprove,
   Qualtrics, Adobe Fonts.
3. **A custom theme is the norm** — nobody reuses another's; build Tulane's own (reskinning
   Yale's *system*, per the design-research plan).
4. **Additional open-source references** beyond Yale: CU Boulder (`boulder_base`) and Arizona
   (`az_barrio` / `arizona-profile`) — both publish their platforms.

## Method caveats
- Headers-only; backend-only modules not visible. Versions "unversioned" = generator
  stripped but Drupal markup present.
- A couple of `tr` locale warnings during the run did not affect the table.
- Confidence: theme/version/hosting = confirmed (asset paths/headers); services = confirmed
  where vendor script present, else likely.
