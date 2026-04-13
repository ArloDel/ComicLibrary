# Design System Document

## 1. Overview & Creative North Star: "The Editorial Ronin"

This design system is not a template; it is a digital manifestation of a collector’s curation. The "Creative North Star" is **The Editorial Ronin**—a philosophy that balances the raw, high-energy impact of Shonen manga with the quiet, disciplined precision of Japanese minimalism. 

We are moving away from the "web-standard" 12-column grid. Instead, we embrace **Manga Layout Dynamics**: intentional asymmetry, heavy verticality, and negative space that acts as a "breath" between moments of high-intensity color. The goal is to make the user feel they are browsing a premium art book rather than a database. 

- **Asymmetry as Intent:** Use uneven gutters and staggered card placements to guide the eye.
- **The Bold Stroke:** Utilize the `primary` red and `on_surface` black as ink strokes against the `surface` paper.
- **Breathing Room:** White space is not "empty"; it is a functional component (Ma) that gives the collection its prestige.

---

## 2. Colors & Tonal Architecture

Our palette is a trio of Red, White, and Deep Black, but we achieve depth through Material 3-inspired tonal layering rather than flat fills.

### The "No-Line" Rule
Traditional 1px borders are strictly prohibited for sectioning. To separate the navigation from the hero, or a filter sidebar from the gallery, use a background shift. For example, place a `surface_container_low` section against the main `surface` background.

### Surface Hierarchy & Nesting
Treat the UI as stacked sheets of *washi* paper. 
- **Base Level:** `surface` (#f3fcf0)
- **Secondary Level:** `surface_container_low` (#edf6ea)
- **Interactive/Floating Level:** `surface_container_lowest` (#ffffff)

### Signature Textures & Gradients
To avoid a "flat" digital look, use subtle linear gradients on primary CTA buttons and Hero section highlights. Transition from `primary` (#b7102a) to `primary_container` (#db313f) at a 135-degree angle. This mimics the slight sheen of fresh lacquerware.

---

## 3. Typography: The Modern Script

The typography system pairs the geometric precision of **Plus Jakarta Sans** with the utilitarian readability of **Manrope**, punctuated by the technical edge of **Space Grotesk**.

- **Display & Headlines (Plus Jakarta Sans):** Used for "Hero" moments and comic titles. These should be set with tight letter-spacing (-0.02em) to mimic the impactful titles found in manga covers.
- **Body (Manrope):** Clean, high x-height for readability in comic synopses and metadata.
- **Labels (Space Grotesk):** All-caps for "Filter Chips" and "Metadata Labels," evoking the technical look of publication dates and archival stamps.

**Stylized Accent Rule:** For top-level navigation or section headers, consider vertical text orientation (writing-mode: vertical-rl) to give a subtle nod to traditional Japanese typesetting.

---

## 4. Elevation & Depth: Tonal Layering

We do not use drop shadows to create "material" height. We use light.

- **The Layering Principle:** A Comic Card (`surface_container_lowest`) sitting on a search results area (`surface_container_low`) creates a natural lift.
- **Ambient Shadows:** Only for "Floating" elements like Modals or Mobile Navigation. Use an extra-diffused shadow: `box-shadow: 0 20px 40px rgba(22, 29, 22, 0.06);`. The shadow color is a tint of `on_surface`, not pure grey.
- **The "Ghost Border" Fallback:** If accessibility requires a container boundary, use the `outline_variant` token at 15% opacity. It should be felt, not seen.
- **Glassmorphism:** For the Top Navigation bar, use `surface` at 80% opacity with a `backdrop-filter: blur(12px)`. This allows the vibrant comic covers to bleed through as the user scrolls, creating a sense of continuity.

---

## 5. Components

### Comic Cards
*Forbid the use of divider lines.*
- **Structure:** A full-bleed image container with 0px border-radius.
- **Typography:** The title uses `title-md` (Manrope) directly on the `surface_container_lowest` background. 
- **Interaction:** On hover, the image should slightly scale (1.02x) and the background shift from `surface_container_lowest` to `primary_fixed` (#ffdad8) for a soft "glow" effect.

### Filter Chips
- **State:** Unselected chips use `surface_container_high` with `on_surface_variant`. 
- **Selected:** Transitions to `primary` background with `on_primary` text.
- **Shape:** 0px radius (Hard Square). This reinforces the minimalist manga panel aesthetic.

### Search Bar
- **Style:** A "Negative Space" input. No background fill. Only a 2px bottom-border using the `primary` token. 
- **Iconography:** Use thick-stroke (2pt) icons to match the bold line theme.

### Stylized Navigation
- **Layout:** High-contrast. Use `on_background` (#161d16) for text.
- **Active State:** A thick 4px red (`primary`) underline that extends 10px beyond the text width on both sides, mimicking a horizontal brush stroke.

---

## 6. Do's and Don'ts

### Do
- **Do** embrace the 0px border-radius. Square edges are essential for the "manga panel" feel.
- **Do** use `primary` red sparingly. It is a "signal" color meant for action, alerts, and vital branding—not for large background fills.
- **Do** use vertical white space (spacing-scale 64px+) to separate distinct story arcs or collection categories.

### Don't
- **Don't** use "Card Shadows" to separate content. Use background color shifts.
- **Don't** use rounded buttons or chips. This breaks the "Sharp Edge" Japanese aesthetic.
- **Don't** use 100% opaque black for long-form body text. Use `on_surface` to reduce eye strain against the off-white `surface`.
- **Don't** use standard "system" icons. Choose or create icons with uniform, heavy stroke weights to match the brand's "inked" personality.