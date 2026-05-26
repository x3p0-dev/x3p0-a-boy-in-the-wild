# A Boy in the Wild — Style System Overview

*The complete reference for the theme's design tokens, colour system, typography, spacing, and variation architecture.*

---

## Colour palette

12 slots. Two semantic families — parchment (backgrounds) and ink (foregrounds) — plus four story-specific semantic colours. Default values are the late summer palette.

| Slug | Name | Default value | Role                            |
|---|---|---|---------------------------------|
| `parchment` | Parchment | `#f2e8cc` | Main background                 |
| `parchment-raised` | Parchment Raised | `#f8eecc` | Elevated surface                |
| `parchment-surface` | Parchment Surface | `#fdf8ed` | Elevated x 2 surface            |
| `parchment-accent` | Parchment Accent | `#9a5818` | Accent background               |
| `ink` | Ink | `#120802` | Primary foreground              |
| `ink-subtle` | Ink Subtle | `#5c2c08` | Lighter foreground              |
| `ink-muted` | Ink Muted | `#9a5818` | Even lighter foreground         |
| `ink-accent` | Ink Accent | `#7a4010` | Accent foreground / links       |
| `ink-on-accent` | Ink on Accent | `#fdf8ed` | Foreground on accent background |
| `rule` | Rule | `rgba(130,72,14,0.22)` | Separators / borders            |
| `sketch-parchment` | Sketch Parchment | `#f2e8cc` | Field sketch background         |
| `sketch-ink` | Sketch Ink | `rgba(48,24,4,0.70)` | Field sketch stroke / captions  |

CSS custom property path: `var(--wp--preset--color--{slug})`

---

## Style variations

Style variations override the palette custom properties via `styles.css` in the variation JSON. `settings.color` cannot be overridden in block style variations — the `css` property override is the correct approach.

### Season variations

#### Late Summer (`is-style-season-late-summer`)
The default world. Warm parchment, sepia ink, amber accents.
```
parchment: #f2e8cc / parchment-raised: #f8eecc / parchment-surface: #fdf8ed
parchment-accent: #9a5818 / ink: #120802 / ink-subtle: #5c2c08
ink-muted: #9a5818 / ink-accent: #7a4010 / ink-on-accent: #fdf8ed
handwritten: #9a5818 / rule: rgba(130,72,14,0.22)
sketch-parchment: #f2e8cc / sketch-ink: rgba(130,72,14,0.42)
```

#### Early Autumn (`is-style-season-early-autumn`)
Cooler grey-tan parchment, warm dark ink. Raised surfaces go lighter than the base — content lifts off the background. Warmth carried by the ink rather than the page.

```
parchment: #c8b88a / parchment-raised: #d8cca0 / parchment-surface: #e8deb8
parchment-accent: #4a2808 / ink: #1a0800 / ink-subtle: #4a2808
ink-muted: #8a5820 / ink-accent: #4a2808 / ink-on-accent: #e8deb8
rule: rgba(90,50,8,0.20) / sketch-parchment: #d8cca0
sketch-ink: rgba(90,50,8,0.50)
```

#### Deep Winter (`is-style-season-deep-winter`)
Near-black base, cool grey ink, minimal. Atmospheric pulse animation.
```
parchment: #1a1f1c / parchment-raised: #242820 / parchment-surface: #0e1210
parchment-accent: rgba(180,175,155,0.55) / ink: rgba(200,196,176,0.82)
ink-subtle: rgba(180,175,155,0.55) / ink-muted: rgba(180,175,155,0.28)
ink-accent: rgba(180,175,155,0.55) / ink-on-accent: #1a1f1c
handwritten: rgba(180,175,155,0.42) / rule: rgba(180,175,155,0.18)
sketch-parchment: #242820 / sketch-ink: rgba(180,175,155,0.45)
```

#### Midwinter (`is-style-season-midwinter`)
Slightly lighter than deep winter. Background shimmer animation.
```
parchment: #242820 / parchment-raised: #2e3228 / parchment-surface: #1a1e18
parchment-accent: rgba(170,165,145,0.42) / ink: rgba(188,184,165,0.80)
ink-subtle: rgba(170,165,145,0.55) / ink-muted: rgba(170,165,145,0.32)
ink-accent: rgba(170,165,145,0.42) / ink-on-accent: #242820
handwritten: rgba(170,165,145,0.40) / rule: rgba(170,165,145,0.15)
sketch-parchment: #2e3228 / sketch-ink: rgba(170,165,145,0.45)
```

### Mood variations

#### Survival (`is-style-mood-survival`)
Darkest, most tense. Crisis chapters.
```
parchment: #161b18 / parchment-raised: #1e2420 / parchment-surface: #0e1210
parchment-accent: rgba(200,196,176,0.22) / ink: rgba(200,196,176,0.80)
ink-subtle: rgba(200,196,176,0.52) / ink-muted: rgba(200,196,176,0.28)
ink-accent: rgba(200,196,176,0.52) / ink-on-accent: #161b18
handwritten: rgba(200,196,176,0.42) / rule: rgba(200,196,176,0.10)
sketch-parchment: #1e2420 / sketch-ink: rgba(200,196,176,0.28)
```

#### Storm (`is-style-chapter-storm`)
Derived from the Chapter 3 storm background image. Rain animation via CSS `::before`/`::after`.
```
parchment: #070c12 / parchment-raised: #0e1620 / parchment-surface: #020508
parchment-accent: rgba(77,120,100,0.55) / ink: rgba(200,215,210,0.85)
ink-subtle: rgba(160,180,175,0.60) / ink-muted: rgba(130,150,145,0.35)
ink-accent: rgba(160,200,160,0.70) / ink-on-accent: #070c12
handwritten: rgba(150,170,160,0.45) / rule: rgba(130,160,150,0.15)
sketch-parchment: #0e1620 / sketch-ink: rgba(130,160,150,0.50)
```

### Arc variations

#### Spine (`is-style-arc-spine`)
Warm parchment with weight. The buried thing always present. Contour flow field canvas effect. Slow background pulse.
```
parchment: #e8dfc0 / parchment-raised: #f0e8cc / parchment-surface: #f5f0e0
parchment-accent: rgba(90,55,12,0.45) / ink: #160c02 / ink-subtle: #5c2c08
ink-muted: rgba(90,55,12,0.50) / ink-accent: rgba(90,55,12,0.45)
ink-on-accent: #f5f0e0 / handwritten: rgba(90,55,12,0.50)
rule: rgba(90,55,12,0.18) / sketch-parchment: #e8dfc0
sketch-ink: rgba(90,55,12,0.42)
```

#### Buried (`is-style-arc-buried`)
Handwritten paper. Caveat dominant. No ruled lines. Used for all buried chapters.
```
parchment: #ede8d5 / parchment-raised: #e8e2cc / parchment-surface: #f5f0e4
parchment-accent: rgba(100,62,12,0.45) / ink: rgba(30,16,2,0.86)
ink-subtle: rgba(30,16,2,0.68) / ink-muted: rgba(30,16,2,0.50)
ink-accent: rgba(100,62,12,0.45) / ink-on-accent: #f5f0e4
handwritten: rgba(80,48,10,0.52) / rule: rgba(100,62,12,0.12)
sketch-parchment: #e8e2cc / sketch-ink: rgba(100,62,12,0.42)
```

### Chapter-specific variations

#### Chapter Fire (`is-style-chapter-fire`)
Deep winter palette with warm amber ink-accent. Snow + ember canvas effect.
```
parchment: #1a1f1c / parchment-raised: #242820 / parchment-surface: #0e1210
parchment-accent: rgba(180,175,155,0.55) / ink: rgba(200,196,176,0.82)
ink-subtle: rgba(180,175,155,0.55) / ink-muted: rgba(180,175,155,0.28)
ink-accent: rgba(200,140,60,0.80) / ink-on-accent: #1a1f1c
handwritten: rgba(180,175,155,0.42) / rule: rgba(180,175,155,0.18)
sketch-parchment: #242820 / sketch-ink: rgba(180,175,155,0.45)
```

---

## Typography

### Font families

| Slug | Name | Stack | Role |
|---|---|---|---|
| `primary` | The Titles (Playfair Display) | Playfair Display, Lora, Rockwell, serif | Headings, declarations, emotional peaks |
| `secondary` | The Field Notes (Lora) | Lora, Rockwell, serif | Body text, standard prose |
| `tertiary` | The Hand (Caveat) | Caveat, cursive | Datelines, captions, annotations, navigation |

Body font: `secondary` (Lora)
Heading font: `primary` (Playfair Display)
Navigation font: `tertiary` (Caveat)

### Font sizes

| Slug | Name | Value |
|---|---|---|
| `2-xs` | 2XS | `clamp(0.7462rem, 0.2582cqi + 0.6688rem, 0.834rem)` |
| `xs` | Extra Small | `clamp(0.8395rem, 0.2905cqi + 0.7524rem, 0.9383rem)` |
| `sm` | Small | `clamp(0.9444rem, 0.3268cqi + 0.8464rem, 1.0556rem)` |
| `md` | Medium | `clamp(1.06rem, 0.37cqi + 0.95rem, 1.19rem)` |
| `lg` | Large | `clamp(1.2rem, 0.85cqi + 0.94rem, 1.48rem)` |
| `xl` | Extra Large | `clamp(1.34rem, 1.5cqi + 0.89rem, 1.86rem)` |
| `2-xl` | 2XL | `clamp(1.51rem, 2.37cqi + 0.8rem, 2.32rem)` |
| `3-xl` | 3XL | `clamp(1.7rem, 3.52cqi + 0.65rem, 2.9rem)` |
| `4-xl` | 4XL | `clamp(1.91rem, 5.03cqi + 0.41rem, 3.62rem)` |
| `5-xl` | 5XL | `clamp(2.15rem, 6.99cqi + 0.06rem, 4.53rem)` |
| `6-xl` | 6XL | `clamp(2.42rem, 9.53cqi + -0.43rem, 5.66rem)` |
| `7-xl` | 7XL | `clamp(2.73rem, 12.8cqi + -1.11rem, 7.08rem)` |
| `inherit` | Inherit | `inherit` |

### Line heights (custom tokens)
`--wp--custom--line-height--{slug}`: `2-xs` and `xs`: 1.625 / `sm`: 1.625 / `md`: 1.6875 / `lg`: 1.5 / `xl`: 1.3125 / `2-xl`: 1.25 / `3-xl`: 1.1875 / `4-xl`: 1.125 / `5-xl`: 1.0625 / `6-xl`: 1.03125 / `7-xl`: 1.015625

---

## Spacing

| Slug | Name | Value |
|---|---|---|
| `10` | Fluid -3 | `clamp(0.31rem, 0.11cqi + 0.28rem, 0.35rem)` |
| `20` | Fluid -2 | `clamp(0.47rem, 0.16cqi + 0.42rem, 0.53rem)` |
| `30` | Fluid -1 | `clamp(0.71rem, 0.25cqi + 0.63rem, 0.79rem)` |
| `40` | Fluid Base | `clamp(1.06rem, 0.37cqi + 0.95rem, 1.19rem)` |
| `50` | Fluid +1 | `clamp(1.20rem, 0.85cqi + 0.94rem, 1.48rem)` |
| `60` | Fluid +2 | `clamp(1.34rem, 1.5cqi + 0.89rem, 1.86rem)` |
| `70` | Fluid +3 (Global) | `clamp(1.86rem, 3.7cqi + -0.05rem, 2.32rem)` |
| `80` | Fluid +4 | `clamp(1.86rem, 7.53cqi + -1.2rem, 3.62rem)` |
| `90` | Fluid +5 | `clamp(1.86rem, 10.2cqi + -2rem, 4.53rem)` |
| `100` | Fluid +6 | `clamp(1.86rem, 13.53cqi + -3rem, 5.66rem)` |
| `110` | Fluid +7 | `clamp(1.86rem, 17.69cqi + -4.25rem, 7.08rem)` |
| `120` | Fluid +8 | `clamp(1.86rem, 22.9cqi + -5.81rem, 8.85rem)` |
| `130` | Fluid +9 | `clamp(1.86rem, 29.4cqi + -7.76rem, 11.06rem)` |
| `140` | Fluid +10 | `clamp(1.86rem, 37.53cqi + -10.2rem, 13.82rem)` |
| `px` | Fixed: 1 Pixel | `1px` |

Global block gap: `var(--wp--preset--spacing--70)`

---

## Layout

```json
"layout": {
  "contentSize": "560px",
  "wideSize": "720px"
}
```

---

## Block style variations reference

### Paragraph
- `chapter-dateline` — Caveat, `ink-subtle`, `md` size. For dateline text.
- `chapter-caption` — Caveat, `ink-muted`, `sm` size. For captions.
- `chapter-opener` — Lora, drop cap, opening paragraph treatment.
- `chapter-location` — Caveat, stamp location text.
- `chapter-aside` — Lora italic, `ink-muted`. Secondary/contextual prose.
- `chapter-annotation` — Caveat, `annotation` colour, small. Margin notes.
- `chapter-pull-quote` — Playfair Display italic, larger. Emotional peak quotes.
- `chapter-interrupted-thought` — Lora, trailing em dash, faded.
- `chapter-list-of-sounds` — Lora sm, muted, sparse line height.
- `chapter-promise-to-self` — Centred, italic, Lora.
- `chapter-got-out` — Playfair Display, large, declaration register.
- `chapter-note` — Caveat, `handwritten` colour. Short field note.

### Separator
- `chapter-rule` — 64% width, left-aligned, 1px `rule` colour.
- `chapter-divider` — 40px centred, soft section break.
- `chapter-rule-storm` — fade-out gradient for storm chapter.
- `field-note-endmark` — SVG wave/triangle endmark, centred.

### Image
- `chapter-field-sketch` — tilted `-1.8deg`, paper texture background, layered `box-shadow` hand-drawn border, Caveat caption.

### Group
- `chapter-place-annotation` — annotation block with label and note.
- `chapter-place-annotation-contained` — same, with background fill.
- `chapter-place-grid` — grid layout for multiple place annotations.
- `chapter-stat` — single stat label/value pair.
- `chapter-stat-block` — group of stat pairs.
- `chapter-log` — attempt log container.
- `chapter-log-row` — single log entry.
- `chapter-title-hero` — large title treatment for declaration chapters.
- `chapter-title-storm` — storm chapter title variant.
- `chapter-got-out` — the *I got out.* declaration block.
- `chapter-spine-marker` — vertical rule for spine chapter bottom.
- `chapter-sealed-message` — sealed chapter message container.

### Button
- `chapter-audio-toggle` — the audio listen/stop button. No border-radius, `box-shadow` hand-drawn border, circle/square HTML entity icons.
- `button-link` — plain link-style button. Tertiary font, no background.

### Post excerpt
- `chapter-dateline` — displays excerpt as dateline text.

### Post title
- `field-note-title` — custom size/weight for chapter title display.

---

## Movement / animation reference

| Effect | Variation / class | Type | Duration | Trigger |
|---|---|---|---|---|
| Spine pulse | `is-style-arc-spine` | CSS `@keyframes` background-color | 8s | Continuous |
| Deep winter sky | `is-style-season-deep-winter` | CSS `@keyframes` background-color | 10s | Continuous |
| Midwinter shimmer | `is-style-season-midwinter` | CSS `::before` opacity | 14s | Continuous |
| Storm rain | `is-style-chapter-storm` | CSS `::before`/`::after` translateY | 1.4s | Continuous |
| Snow + embers | `is-style-chapter-fire` | Canvas `requestAnimationFrame` | — | On load |
| Contour lines | `is-style-arc-spine` | Canvas `requestAnimationFrame` | — | On load |
| Rule draw | `is-style-chapter-rule` | CSS `scaleX` | 0.6s | On load |
| Field sketch hover | `is-style-chapter-field-sketch` | CSS `transform` transition | 0.3s | Hover |

All CSS animations wrapped in `@media (prefers-reduced-motion: no-preference)`. Canvas effects check `window.matchMedia('(prefers-reduced-motion: no-preference)')` before starting.

---

## Easter egg system reference

| Sealed # | Title | Key | Key location |
|---|---|---|---|
| 38 | What I Told Margaret | `still here` | Ch 35 final line |
| 51 | What I Said Before I Left | `before she woke` | Ch 49 final sentence (deliberate grammatical error) |
| 56 | My Name | `the right person` | Ch 55 + Ch 83 echo |
| 85 | What the Pattern Means | Cipher decoded | Sketch cipher Ch 45→73→78→84 |
| 93 | The Other Thing I Write | `another thing` | Ch 92 mid-chapter |
| 123 | What I Actually Said | `for anyone who wasn't` | Ch 122 final sentence |
| 155 | For Daniel, When He Is Ready | `when he's ready` | Ch 154 final sentence |
| 183 | The Letter in the Map | Cipher decoded | Ch 45→73→78→84→182 + Ch 1 + Ch 55 |

**Passive easter egg systems:**
- **Dash signal** — mid-sentence dash signals a buried chapter follows (from Ch 19 onward)
- **Number 412** — appears in sketches Ch 9 (uncircled), Ch 39 (circled), Ch 94 (resolved as deer name)
- **The cipher** — mark pattern in carved object sketches across Ch 45, 73, 78, 84, 182
- **Signature symbol** — Elara's camp mark from Ch 78 appears in sketch signature from Ch 133 onward
