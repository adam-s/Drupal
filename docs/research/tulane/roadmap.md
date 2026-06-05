# Tulane Web Platform — Phased Roadmap (draft)

A rough, sequenced plan turning the research into delivery. Pulls from
[../EXECUTIVE-SUMMARY.md](../EXECUTIVE-SUMMARY.md), [component-backlog.md](component-backlog.md),
[brand-tokens.md](brand-tokens.md), and [../seo-schema-recommendation.md](../seo-schema-recommendation.md).
Sequencing is directional — validate effort with the Tulane team.

## Guiding principle
Tulane already has a solid foundation (D10, Pantheon+Fastly, Layout Builder + Paragraphs,
Tailwind). This is **evolution**: formalize the system, fill the component gap, then upgrade.
Each phase ships independently and is captured in `config/sync` (config-as-code).

## Phase 0 — Decisions & access (prerequisite)
- Confirm: **D10 redesign vs D11 upgrade vs rebuild** (recommend planning the **D11 upgrade**).
- Get access to the private `tulane_tailwindcss` repo (authoritative `tailwind.config.js`).
- Confirm brand direction (green-led confirmed; how much teal/sky accent; modernize green?).
- Confirm hosting stays Pantheon; subdomain scope (www only vs department estate).

## Phase 1 — Design tokens (foundation)
*Why first: every component reads from these.*
- Define `tailwind.config.js` tokens: **color** (Tulane Green `#285C4D`, Blue `#71C5E8`,
  secondaries, neutrals; semantic roles; optional named sub-brand themes), **type** (Freight
  serif + FreightSans; add a **mid weight 500/600**), **spacing** scale + semantic aliases,
  **breakpoints**, **effects** (reduced-motion-aware).
- Fix the **button defect** (Arial fallback → Freight; size/padding/hover).
- Decide `border-radius` as a deliberate token (classic 0 vs softer).
- Deliverable: a documented Tulane token system (Yale-structure, Tulane values).

## Phase 2 — Component library (the biggest gap)
*Build from [component-backlog.md](component-backlog.md), impact×effort order.*
- Wave A (high impact, low effort): **cards + card-collection, callout, accordion,
  related-content, facts-and-figures**.
- Wave B: **tabs, pull-quote, in-this-section (secondary nav), tiles**.
- Each as a Paragraph type (or SDC) reading Phase-1 tokens; accessible (ARIA/keyboard);
  exported to `config/sync`.
- Govern with `layout_builder_restrictions_by_role` so flexibility ≠ brand breakage.
- Add **hero CTAs** (Apply / Request Info) — Tulane's hero lacks them vs Yale.

## Phase 3 — Structured data / SEO
*Low effort, high visibility; few peers do it.*
- Add **Schema.org Metatag** per content type: Organization/CollegeOrUniversity (site),
  NewsArticle (news), EducationalOccupationalProgram/Course (programs), Event (events),
  Person (profiles), BreadcrumbList (all). Standardize across **all subdomains** (some lack it).
- Expand Open Graph/Twitter coverage (currently `og:title` only on homepage).
- Validate with Rich Results Test; add to Go-Live checklist.

## Phase 4 — Drupal 11 upgrade
*Match the peer mainstream (Stanford/Penn/Harvard College on 11).*
- Upgrade-status audit (module compatibility), then core + contrib to 11.
- Sequence after the token/component work stabilizes so the upgrade isn't moving two targets.
- Re-test components + accessibility post-upgrade.

## Phase 5 — Governance & provisioning
- Implement the three-tier role model + content moderation
  ([recipe-drafts/editorial_workflow](recipe-drafts/editorial_workflow/recipe.yml)).
- Stand up the **request → Recipe-provisioned subsite** pipeline
  ([recipe-drafts/department_site](recipe-drafts/department_site/recipe.yml)) for the
  department estate.
- Editor training + brand/accessibility guidelines (governance deliverables).

## Phase 6 — Interaction & polish
- Header: consider shrink/hide-reveal (Harvard reference) vs current flat sticky.
- Motion: card hover-rise, link underline, fade-in-up (reduced-motion aware).
- Mobile nav: audit Tulane's combined search+hamburger against Yale's accessible disclosure.

## Rough sequencing
```
Phase 0 (decisions) ──► Phase 1 (tokens) ──► Phase 2 (components) ──► Phase 3 (SEO)
                                              └─────────────► Phase 4 (D11 upgrade)
Phase 5 (governance) and Phase 6 (polish) run alongside 2–4 as capacity allows.
```

## Confidence
Sequencing and phase boundaries are judgment, not gospel — Phases 1→2→3 ordering is
well-grounded (dependencies); D11 timing and the governance/polish interleave are flexible.
Effort sizing needs the Tulane team + repo access.
