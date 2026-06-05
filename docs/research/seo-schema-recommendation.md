# SEO / Schema.org Recommendation — Tulane's Structured-Data Opportunity

## The confirmed gap

Across the harvest, **no peer ships JSON-LD structured data** — not on homepages and not on
interior pages where it matters most:
- Homepage check (Yale, Stanford, CU Boulder): **0 `ld+json` blocks**.
- Interior check (Tulane news article, Tulane academics/program, Tulane events, Yale doc,
  Stanford program): **0 `ld+json` blocks** — even the **news article** had none (should have
  `Article`/`NewsArticle`), and the **program page** had none (should have `Course` /
  `EducationalOccupationalProgram`).
- Tulane's homepage carries 1 JSON-LD block but its **news articles and program pages do
  not**.

**This is a low-effort, high-visibility SEO differentiator.** Rich results (event cards,
course/program panels, article rich snippets, sitelinks search box) are largely unclaimed by
peers. Implementing Schema.org well puts Tulane ahead in search presentation.

### Correction (wave 4 spot-check) — Tulane is partly ahead already
A wider spot-check of **Tulane's own subdomains** revised the picture — Tulane is **better
than the peer homepages I first checked**:
- `www.tulane.edu` — emits `CollegeOrUniversity`, `WebSite`, `WebPage`, `Article`.
- `sse.tulane.edu` (School of Science & Eng.) — `CollegeOrUniversity`, `WebSite`,
  `Article`, `ImageObject`.
- `medicine.tulane.edu` — `EducationalOrganization`, `WebSite`, `PostalAddress`.
- `liberalarts.tulane.edu` — **0** (inconsistent — some subdomains have none).

So the **real, narrower gap** is twofold: (1) **per-content-type** schema is missing where it
matters most — the **news article**, **program**, and **event** pages had **no**
`NewsArticle` / `Course` / `Event` markup (only generic site-level types); and (2) coverage is
**inconsistent across subdomains** (liberalarts has none). The opportunity is to **standardize
rich per-content-type structured data platform-wide**, not to start from zero.

## How to implement in Drupal
Use the **Schema.org Metatag** module (`drupal/schema_metatag`, companion to Metatag which
Tulane/peers already run). It emits JSON-LD per content type via token-mapped fields. No
theming work; it's config + field mapping, and exports cleanly to `config/sync`.

## Content-type → Schema.org type mapping

| Tulane content type | Schema.org `@type` | Key properties to map |
|---------------------|--------------------|------------------------|
| **Program / Degree** | `EducationalOccupationalProgram` (+ `Course` for courses) | name, description, provider (Organization), educationalCredentialAwarded, occupationalCategory, timeToComplete |
| **News / Article** | `NewsArticle` (or `Article`) | headline, image, datePublished, dateModified, author, publisher (Organization w/ logo) |
| **Event** | `Event` | name, startDate, endDate, eventAttendanceMode, location (Place/VirtualLocation), organizer, offers |
| **Person / Profile** | `Person` | name, jobTitle, worksFor (Organization/Department), image, sameAs, email, knowsAbout |
| **Department / Unit** | `CollegeOrUniversity` / `EducationalOrganization` (sub-org) | name, parentOrganization (Tulane), url, address |
| **Basic page (site-wide)** | `Organization` / `CollegeOrUniversity` | name, url, logo, sameAs (socials), contactPoint |
| **All pages** | `BreadcrumbList` | itemListElement (position, name, item) |
| **Homepage / search** | `WebSite` + `SearchAction` (sitelinks search box) | url, potentialAction (search target) |

## Priority order (impact × effort)
1. **Organization / CollegeOrUniversity** (site-wide) — one-time; enables logo + knowledge
   panel signals. Highest ROI.
2. **NewsArticle** on news — high volume, immediate rich-snippet eligibility.
3. **Event** — event rich results (dates/location cards) are visually prominent in search.
4. **EducationalOccupationalProgram / Course** on programs — the prospective-student
   conversion path; few competitors mark this up.
5. **BreadcrumbList** site-wide — easy, improves SERP breadcrumb display.
6. **Person** on directory profiles — entity signals for faculty.
7. **WebSite + SearchAction** — sitelinks search box on brand queries.

## Validation workflow
- Test with Google **Rich Results Test** + Schema Markup Validator per content type.
- Add to the **Go-Live checklist** (per `governance-models.md`) so every new content type
  ships with structured data.

## Other SEO notes from the harvest (already solid across peers — match these)
- **XML sitemaps** via Simple XML Sitemap (Tulane already has this pattern). ✅
- **Pathauto** clean aliases. ✅
- **Open Graph**: Tulane homepage emits only `og:title` — **expand** to og:description,
  og:image, og:type, og:url, plus Twitter Card tags (Stanford does this most completely).
- **Canonical** tags present. ✅

## Confidence
- Gap finding: **high** (checked 8 pages across homepage + 5 content types; consistent zero).
- Caveat: structured data *could* exist on content types not sampled (e.g. a specific
  research or faculty template) — spot-check a few more page types before declaring universal.
