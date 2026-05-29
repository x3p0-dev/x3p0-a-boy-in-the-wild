---
name: abitw-sketch-briefs
description: >
  Writing sketch briefs for A Boy in the Wild chapter images. Use this skill
  before writing any Photoshop AI prompt, sketch caption, or sketch alt text.
  Produces three outputs for each sketch: a Photoshop AI prompt, a caption in
  his voice, and alt text in his voice. Triggers on: "write a sketch brief",
  "write a prompt for the sketch", "write alt text for the sketch", "write a
  caption for the sketch", or any task that produces image generation prompts
  or sketch copy for a chapter.
---

# Sketch Briefs

Read story-voice before this skill. Every sketch brief produces three
outputs: a Photoshop AI prompt, a caption, and alt text. All three must
reflect his skill level at the time of the chapter.

---

## Before writing any sketch brief

Consult the story outline for the chapter. The outline specifies:

- What the sketch shows
- The medium (charcoal, ink, ochre, watercolour — see skill arc below)
- Any Easter egg details visible in the sketch
- The caption, if specified

Also consult the story-continuity document to confirm which Easter egg
systems are active at this chapter and what has already appeared in
previous sketches.

---

## His skill arc

His drawing materials and ability change across thirty years. Every prompt
must reflect where he is in this arc. A Chapter 5 sketch looks nothing like
a Chapter 150 sketch — different materials, different confidence, different
line quality.

| Era | Age | Medium | Quality |
|---|---|---|---|
| Era 1 (Ch 1–17) | 12–14 | Charcoal only | Crude, stiff lines. Proportions approximate. Corrections visible. The marks of someone who has not drawn much. Functional more than expressive. |
| Era 2 (Ch 18–35) | 15–17 | Charcoal, more confident | Lines more assured but still raw. Spatial understanding improving. Still functional — he is recording, not making art. |
| Era 3 (Ch 36–64) | 18–22 | Charcoal with first ochre pigment from Ch 62 | Charcoal more expressive. First colour appears in Ch 62 — iron-rich clay ochre, applied carefully, used sparingly. |
| Era 4 (Ch 65–100) | 23–26 | Charcoal and ochre, then ink introduced | Ink appears alongside charcoal. Ochre washes used for warmth. Confidence growing — marks are deliberate. First colour map in Ch 85 with ochre and green. |
| Era 5 (Ch 101–113) | 27–30 | Ink over ochre wash, natural pigments | Ink is primary. Ochre and natural pigment washes underneath. Accomplished technical drawing alongside expressive marks. |
| Era 6–7 (Ch 114–145) | 31–35 | Ink with watercolour washes | Fully accomplished. Natural watercolour washes — ochre, green, earth tones. Detail and confidence at their peak for technical subjects. |
| Era 8 (Ch 146–167) | 36–41 | Ink and watercolour, uncertain in new territory | In his own territory: fully accomplished. In Elara's territory (Ch 160 onward): lines uncertain again — he is drawing something he doesn't know yet. |
| Era 9–10 (Ch 168–193) | 39–42 | Ink and natural watercolour, masterwork level | The most accomplished sketches in the story. Confident, expressive, precise. The garden sketches in particular are at their fullest. |

---

## The Photoshop AI prompt

The prompt describes the image for Photoshop's generative AI. Be explicit
about subject, composition, medium, and quality level. Do not be vague.

**Structure:**

1. **Subject** — what is depicted, specifically
2. **Composition** — framing, perspective, what is foregrounded, what is at
   the edges
3. **Medium** — the exact materials (charcoal on paper, ink with ochre wash,
   etc.)
4. **Quality and style** — his skill level at this era, the quality of marks,
   the feeling of the work
5. **Paper** — aged, cream-toned field notebook paper with slight texture
6. **Easter egg details** — any imagery that needs to appear (no text — text
   is added manually in Photoshop afterward)

**Prompt format:**

Write as a clear description, not a command. Describe what the image is,
not what to do. Keep it specific and concrete.

**Example — Chapter 1, Era 1 (charcoal, crude):**

> A small fire burning in a forest clearing at night, viewed from ground
> level. Tall pine trees press close on both sides, their trunks dark and
> rough. The fire is the only light source, casting a warm glow on the
> ground immediately around it. Charcoal on cream-toned notebook paper.
> Crude, stiff lines — the work of someone who has not drawn much. Proportions
> approximate. The trees are recognizable but roughly rendered. Functional
> rather than expressive. The paper has slight texture and age.

**Example — Chapter 85, Era 4 (ink with ochre and green wash, first colour map):**

> A territory map drawn from above, showing forest, ridge lines, a creek,
> and camp locations marked with small symbols. Ink linework over ochre and
> green watercolour washes. Confident, deliberate marks — technically
> accomplished. The map has the quality of a working document: annotations,
> corrections, symbols. One camp is marked with a specific symbol in the
> lower right corner. Cream-toned notebook paper with slight texture.

**Easter egg details in prompts:**

Include visual elements that need to appear but describe them as imagery,
not as text. Any labels, numbers, or script that need to appear in the
sketch are added manually in Photoshop after generation.

- *412 in a corner* → "a small number sketched lightly in the lower right
  corner, barely visible"
- *Boundary stone at edge* → "at the right edge of the sketch, partially
  visible, a rectangular carved stone with worn markings"
- *Cipher marks on carved object* → "a carved wooden object with a pattern
  of deliberate marks along its surface"

---

## The caption

The caption is what he wrote in his notebook under the sketch. It is always
in his voice — read the story-voice skill for the era-appropriate register.

**What a caption can be:**
- A label: *The Clearing. First Night.*
- A brief observation: *Scale: about a day's walk. Maybe two.*
- A question or note to himself
- A location or date fragment
- Something oblique that only makes sense in context

**What a caption is never:**
- A description of what's in the sketch (that's alt text)
- A summary or explanation
- More than one or two short lines in most cases
- Outside his voice

**Caption length:** Usually one short line. Occasionally two. Rarely more.
The caption is a note, not a label.

**Examples:**

Early (Era 1–2) — sparse, functional:
- *The Clearing. First Night.*
- *Scale: about a day's walk. Maybe two.*
- *I know what it is. I'm not ready.*

Middle (Era 3–5) — slightly more open:
- *The first colour I used. Iron from the settlement soil.*
- *Her camp. I have not named it.*

Late (Era 6–10) — precise, confident, occasionally tender:
- *Twenty-six years. Still going.*
- *Both territories. One place.*

---

## The alt text

Alt text is written in his voice, in the era-appropriate register, describing
what's drawn to someone who cannot see it. It is practical and accurate —
he is describing his own work, not interpreting it.

**Alt text is:**
- In his voice for the chapter's era
- A description of what is literally depicted
- Specific enough to convey the image to someone who cannot see it
- Written as he would speak, not as a neutral accessibility description

**Alt text is never:**
- The same as the caption
- Poetic or interpretive beyond his voice
- Longer than necessary
- Written from outside his world

**Era-based examples for the same subject — a fire in a clearing:**

Era 1 (age 12–14):
*A fire in the clearing. Pine trees on both sides. My drawing. The proportions are not right but the fire is.*

Era 5 (age 27–30):
*The clearing fire, charcoal and ochre. The trees are closer than they look in the sketch. I drew them from memory.*

Era 9 (age 39–42):
*The clearing as I first drew it and as I drew it again thirty years later. The fire in both. The trees are the same trees.*

---

## Output format

For each sketch, produce all three outputs clearly labeled:

```
**Photoshop prompt:**
[prompt text]

**Caption:**
[caption text]

**Alt text:**
[alt text]
```
