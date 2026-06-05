# Browser-Discovered Fingerprints (harvester)

Sites profiled with the Playwright harvester — including ones the headers/curl pass couldn't
read (CDN-masked apexes). Profiles in `tools/harvester/out/`.

| Site | Drupal | Theme | Layout | Header scroll | Services |
|------|--------|-------|--------|---------------|----------|
| www.chem.ox.ac.uk | **7** | oxtheme | blocks | static | Google Fonts, Font Awesome, New Relic |
| www.law.ox.ac.uk | **11** | olamalu_o | blocks | sticky | Cookiebot, Google Fonts |
| www.physics.ox.ac.uk | **10** | physics | blocks | static | Adobe Fonts, Font Awesome |
| today.duke.edu | **10** | dt | — | static | Google Fonts |
| www.nyu.edu | (masked) | — | — | **shrink** | OneTrust |
| news.berkeley.edu | (masked) | — | blocks | sticky | Google Fonts, Font Awesome, Siteimprove |
| www.gsb.stanford.edu | **8** | gsb | layout_builder | static | Slate, Siteimprove |

## Findings

### Oxford IS Drupal — at the department level
The apex `www.ox.ac.uk` is Cloudflare-masked (not obviously Drupal), but **Oxford department
sites run Drupal**: Chemistry (D7, `oxtheme`), Law (D11, `olamalu_o` — Olamalu is a known
Oxford Drupal agency/platform), Physics (D10, `physics`). Oxford spans **D7→D10→D11** across
departments — the same "many independent subdomains, mixed versions" reality seen at Yale and
Stanford. The right target for Oxford is **department subdomains, not the apex.**

### GDPR consent on EU/international sites
Cookiebot (Oxford Law) and OneTrust (NYU) appear where the earlier US-state-school sweep
didn't show consent tooling — international audience driving GDPR compliance.

### More legacy versions in the wild
Stanford GSB on **Drupal 8** (with Layout Builder, `gsb` theme); Oxford Chemistry on **D7**.
Reinforces: even elite institutions carry old Drupal — Tulane starting/upgrading to D11 avoids
that debt.

### Animated headers add references
NYU = shrink-on-scroll header (joins Harvard College as an animation reference for Tulane).

> Confidence: theme/version = confirmed (asset paths/generator via rendered DOM); masked
> cores (NYU, Berkeley) = Drupal not confirmed (no generator/asset signal even in browser) —
> may be non-Drupal or fully stripped.
