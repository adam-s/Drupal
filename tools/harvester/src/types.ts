/** Shared types for the harvester. One SiteProfile per site/subdomain. */

export interface RenderResult {
  rendered: boolean;
  status: number | null;
  reason?: string;
  isDrupal?: boolean;
}

export interface RegionTree {
  regions: Array<{
    name: string;
    selector: string;
    blocks: Array<{
      type: string;
      classes: string[];
      componentGuess?: string;
      box: { w: number; h: number };
    }>;
  }>;
  layoutSystem: 'layout_builder' | 'layout_paragraphs' | 'blocks' | 'unknown';
  signals: Record<string, number>; // raw counts of region/block/component signatures
}

export interface TokenSet {
  spacing: number[];
  typography: { family: string[]; sizes: number[]; weights: number[]; lineHeights: number[] };
  colors: { palette: string[]; text: string[]; background: string[] };
  radii: number[];
  shadows: string[];
  samples: Record<string, Record<string, string>>;
}

export interface ScrollProfile {
  pattern: 'static' | 'sticky' | 'shrink' | 'hide-reveal' | 'mixed';
  states: Array<{ offset: number; position: string; transform: string; height: number; classes: string[] }>;
  transition?: { property: string; durationMs: number; easing: string };
  library?: string | null;
}

export interface SeoProfile {
  title?: string;
  description?: string;
  canonical?: string;
  openGraph: string[];
  twitter: string[];
  jsonLdTypes: string[];
  sitemapStatus?: number;
  robotsDirectives?: number;
}

export interface ModuleFingerprint {
  drupalCore?: string;
  hosting?: string;
  theme?: string;
  modules: Array<{ name: string; confidence: 'confirmed' | 'likely' | 'inferred'; evidence: string }>;
}

export interface ServiceInventory {
  services: Array<{ category: string; name: string; confidence: 'confirmed' | 'likely' | 'inferred'; evidence: string }>;
}

export interface SiteProfile {
  site: string;
  url: string;
  capturedAt?: string;
  mode: 'cdp' | 'source';
  regions?: RegionTree;
  tokens?: TokenSet;
  scroll?: ScrollProfile;
  seo?: SeoProfile;
  fingerprint?: ModuleFingerprint;
  services?: ServiceInventory;
  screenshots: string[];
}
