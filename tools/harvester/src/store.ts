import { mkdirSync, writeFileSync } from 'node:fs';
import type { SiteProfile } from './types.js';

/** Persist a SiteProfile as JSON under out/<site>/profile.json. */
export function writeProfile(profile: SiteProfile): string {
  const dir = `${process.env.HARVEST_OUT ?? 'out'}/${profile.site.replace(/[^a-z0-9.-]+/gi, '_')}`;
  mkdirSync(dir, { recursive: true });
  const path = `${dir}/profile.json`;
  writeFileSync(path, JSON.stringify(profile, null, 2));
  return path;
}
