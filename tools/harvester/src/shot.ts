import { mkdirSync } from 'node:fs';
import { dirname } from 'node:path';
import type { Page } from '@playwright/test';

/**
 * Token-optimized screenshot for cheap LLM consumption.
 *
 * Claude tokenizes an image by pixel dimensions (~w*h/750), so downscaling is the
 * real lever. Cap width (default 1024) and use low JPEG quality. `sharp` is lazy +
 * optional: without it we fall back to Playwright's JPEG. (prairielearn-debug pattern.)
 */
export interface ShotOptions {
  dir?: string;
  fullPage?: boolean;
  maxWidth?: number;
  quality?: number;
}

export async function shot(page: Page, label: string, opts: ShotOptions = {}): Promise<string> {
  const dir = opts.dir ?? process.env.HARVEST_ARTIFACTS ?? 'out/screenshots';
  const maxWidth = opts.maxWidth ?? 1024;
  const quality = opts.quality ?? 45;
  const path = `${dir}/${label.replace(/[^a-z0-9_-]+/gi, '_')}.jpg`;
  mkdirSync(dirname(path), { recursive: true });

  const raw = await page.screenshot({ type: 'jpeg', quality, fullPage: opts.fullPage ?? false });

  try {
    const sharp = (await import('sharp')).default;
    await sharp(raw).resize({ width: maxWidth, withoutEnlargement: true }).jpeg({ quality }).toFile(path);
  } catch {
    const { writeFileSync } = await import('node:fs');
    writeFileSync(path, raw); // fallback: un-resized JPEG
  }
  return path;
}
