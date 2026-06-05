# YaleSites — Complete Module Stack (100 contrib modules)

Definitive list from `yalesites-org/yalesites-project` →
`web/profiles/custom/yalesites_profile/composer.json` (the install profile). Drupal core
**10.3.14**. Yale-authored packages: `yalesites-org/atomic` (theme),
`yalesites-org/yale_cas` (auth), `yalesites-org/ai_engine` (AI), plus
`northernco/ckeditor5-anchor-drupal`.

> This is the real-world "what does a mature higher-ed Drupal platform install" reference —
> a strong default shopping list for Tulane.

## Page building / layout (the core of the editor experience)
- **layout_builder_browser** — visual block browser for Layout Builder
- **layout_builder_lock** — lock layout regions
- **layout_builder_restrictions** + **layout_builder_restrictions_by_role** — control which
  blocks/layouts editors can use (governance over the page builder)
- **section_library** — save & reuse layout sections
- **paragraphs** + **paragraphs_features** — structured content components
- **field_group** — group fields in forms/displays
- **components** + **emulsify_twig** — the **Emulsify** component system (the design library)

## Theme & admin UX
- **gin** (admin theme) + **gin_lb** (gin for Layout Builder) + **gin_moderation_sidebar**
- **admin_toolbar** — better admin menu
- **coffee** — fast admin command palette
- **environment_indicator** — visual dev/stage/prod banner
- **chosen** — enhanced select widgets
- **gin** is the modern admin theme standard

## Editorial workflow & revisions
- **moderation_sidebar** + **workflow_buttons** — streamlined publish/moderation UX
  (core Content Moderation underneath)
- **override_node_options** — per-role publishing options
- **quick_node_clone** — duplicate content
- **single_content_sync** — export/import single content items
- **hide_revision_field**, **node_revision_delete** — revision hygiene

## Media
- **media_library_edit**, **media_library_form_element**, **media_entity_download**,
  **media_file_delete** — media library enhancements
- **media_thumbnails** + **media_thumbnails_pdf** — thumbnails incl. PDFs
- **focal_point** — smart image cropping
- **imagemagick** — image toolkit

## SEO
- **metatag** — meta/OG/Twitter tags
- **pathauto** — automatic URL aliases
- **redirect** + **entity_redirect** — 301 management
- **simple_sitemap** — XML sitemaps (matches the sweep: sitemap.xml on every site)
- **fast_404** — efficient 404s

## Search
- **search_api** + **search_api_exclude** + **search_api_html_element_filter**
- **better_exposed_filters** + **selective_better_exposed_filters** — faceted search UX

## Accessibility
- **editoria11y** — Yale-authored automated a11y checker (confirmed live in fingerprint)

## Auth, roles & permissions
- **cas** (+ Yale's **yale_cas**) — SSO
- **role_delegation** — let site managers assign roles (the governance role model)
- **menu_admin_per_menu** — per-menu editing permissions
- **honeypot** — spam protection

## Forms & spam
- **webform** — the forms powerhouse
- **captcha** + **recaptcha** + **recaptcha_v3** — bot protection
- **formdazzle** — webform styling

## Content modeling & fields
- **address** — postal addresses
- **smart_date** — better date/time (events)
- **auto_entitylabel** — auto-generated titles
- **double_field**, **multivalue_form_element**, **multiple_fields_remove_button**
- **maxlength**, **allowed_formats** — field constraints
- **book** + **custom_book_block** — book/handbook hierarchical content
- **calendar_link** — add-to-calendar links
- **entity_usage** — track entity references (safe deletes)

## Menus & navigation
- **bigmenu** — large menu editing
- **menu_breadcrumb**, **menu_item_extras**, **menu_item_limit**

## Config management & migration
- **config_filter**, **config_ignore**, **config_split** — environment-specific config
  (the config-as-code deploy pattern)
- **migrate_plus** + **migrate_tools** — content migration (relevant to Tulane's data import)

## Editor / CKEditor
- **editor_advanced_link**, **anchor_link**, **linkit** — link UX
- **improve_line_breaks_filter**, **typogrify** — typographic polish
- **ckeditor5-anchor-drupal** (northernco)

## Performance / hosting (Pantheon)
- **pantheon_advanced_page_cache** + **pantheon_secrets** — Pantheon integration
- **redis** — cache backend
- **fast_404**

## Analytics & email
- **google_analytics** + **google_tag** (GTM)
- **mailsystem** + **mailchimp_transactional**
- **addtoany** — social sharing

## Dev / QA
- **devel** + **devel_kint_extras**, **webprofiler**, **markup**, **upgrade_status**

## AI
- **yalesites-org/ai_engine** — Yale's AI module (powers the askyale chatbot; confirmed live)

## Patterns worth copying for Tulane
1. **Governed Layout Builder** — `layout_builder_restrictions(_by_role)` + `layout_builder_lock`
   + `layout_builder_browser` + `section_library` = a powerful but *constrained* page builder.
   This is how you give editors flexibility without letting them break the brand.
2. **Gin admin theme + moderation_sidebar + workflow_buttons** — modern, low-friction
   editor experience.
3. **config_split/ignore/filter** — the multi-environment config-as-code toolkit.
4. **The SEO trio** (metatag + pathauto + simple_sitemap + redirect) — table stakes.
5. **role_delegation** — implements the three-tier governance role model from
   `governance-models.md`.
6. **Emulsify (components + emulsify_twig)** — the component-system foundation.

Raw source: `yalesites/profile-composer.json`.
