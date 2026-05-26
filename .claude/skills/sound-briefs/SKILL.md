---
name: sound-briefs
description: >
  Writing sound briefs for A Boy in the Wild chapters. Use this skill before
  writing any Suno prompt for ambient sound effects, ambient music, or played
  chapter music. Produces a Suno prompt for each sound type needed by a
  chapter. Triggers on: "write a sound brief", "write a Suno prompt",
  "what sound should chapter X have", or any task that produces audio
  generation prompts for a chapter.
---

# Sound Briefs

Read chapter-design before this skill. The chapter-design skill covers the
sound vocabulary and when each type is used. This skill covers how to write
the Suno prompts that generate the audio.

---

## Before writing any sound brief

Consult the story outline for the chapter:
- Season, time of day, physical environment
- Emotional register and arc
- Whether the chapter is a played chapter

Consult the chapter design for the sound decision:
- Which type of sound does this chapter use?
- What is the emotional register the sound should carry?

---

## Three sound types

Every chapter uses one of three sound types. Each uses a different Suno
workflow and prompt approach.

| Type | Suno mode | Format | Duration |
|---|---|---|---|
| Ambient (sound effects) | Sounds → Loop | Seamless loop | 10–15 seconds |
| Ambient (full song) | Music | Full track, instrumental | 2–4 minutes |
| Played chapter | Music | Full track, instrumental | 2–4 minutes |

---

## The instrument

He builds a stringed instrument in Era 2 from dense dark wood found at the
abandoned settlement. He carves it over one winter (Ch 35). It makes its
first sound in Ch 44. By Ch 87 Elara hears him play it. By the final played
chapter (Ch 190) it is unrecognizable from what it started as.

The instrument is always:
- Stringed
- Handmade — imperfect, resonant, organic
- Made from wilderness materials
- His own voice, not any known instrument

Its sound evolves across the story. Prompts must reflect where the instrument
is in this arc.

| Era | Sound character |
|---|---|
| Era 2 (Ch 35, first carved) | Not yet playable |
| Era 3 (Ch 44, first sound) | Raw, uncertain, unexpected resonance. Not quite any known instrument. Like a dulcimer or zither made by someone who has never heard one. |
| Era 4 (Ch 70, 87) | More controlled. Still handmade and imperfect. Drone-like qualities. Low, warm, slightly buzzing strings. |
| Era 5 (Ch 101) | Developing its own character. He has learned what it does well. Meditative, resonant, slow. |
| Era 6–7 (Ch 135) | Fully itself. Something between a hurdy-gurdy, a lap steel, and a stringed percussion instrument. Not identifiable. |
| Era 10 (Ch 190) | Unrecognizable. Entirely its own thing. Ancient-sounding, deep, with harmonic overtones that don't belong to any scale. |

Never describe it as a guitar, violin, cello, or any standard instrument.
Describe its qualities — the texture of the sound, its resonance, its
handmade imperfection — not its category.

---

## Suno prompt structure

### Music prompts (ambient songs and played chapters)

Suno reads the Style field as weighted comma-separated tags. Use 8–15 tags.
Too few is vague. Too many dilutes.

**Five components, in order:**

1. **Genre/type** — what kind of piece this is
2. **Mood** — the emotional register
3. **Instrumentation** — specific instruments and their character
4. **Production** — the sonic texture and mix quality
5. **BPM** — tempo anchor (slow pieces: 40–70 BPM)

Music prompts for this project are always:
- Instrumental only — no vocals
- No lyrics field needed
- Acoustic or organic — no electronic production unless the chapter
  specifically calls for it
- Grounded in the physical world of the wilderness

**Template:**

```
{genre/type}, {mood}, {mood detail}, no vocals, instrumental,
{instrument 1 and character}, {instrument 2 if needed},
{production quality}, {mix texture}, {BPM} BPM
```

### Sound effects prompts (ambient loops)

Use Suno's Sounds mode → Loop. Do not use the music generator for sound
effects.

Prompt like an audio designer — describe what the sound is, its texture,
its environment. Not a genre or song style.

**Template:**

```
{what the sound is}, {specific physical detail}, {time of day or season
if relevant}, seamless loop, {duration hint: 10-15 seconds}
```

---

## Ambient sound effects — writing the prompt

Sound effects are the physical world as he experiences it. Rain on shelter.
Fire breathing. Wind through pine canopy. The specific quality of silence
before snow.

His wilderness is northern Minnesota. Every sound effect should feel like it
belongs to that physical place — old, cold, dense forest.

**What to specify:**
- The exact sound event or environment
- Physical specificity — not "rain" but "steady rain on pine needles and
  bare earth, occasional drip from shelter roof"
- Time of day where relevant
- Season where it changes the character of the sound

**Examples:**

*Deep winter night, fire inside shelter:*
```
low crackling fire, occasional pop and shift of logs, small enclosed space,
deep winter silence underneath, seamless loop, 10-15 seconds
```

*Late summer, creek nearby:*
```
slow moving creek over stones, late summer insects, distant wind in pine
canopy, warm day, seamless loop, 10-15 seconds
```

*Storm, shelter interior:*
```
heavy rain on shelter roof, wind gusts through trees, occasional thunder
distant, interior acoustic, muffled from outside, seamless loop, 10-15 seconds
```

---

## Ambient full songs — writing the prompt

Ambient songs are the wilderness given music. They carry the seasonal and
emotional register of the chapter without his instrument — the world itself
as sound.

They loop. They should be noticed on arrival and forgotten within thirty
seconds. Never intrusive. Never melodic in a way that competes with the
prose.

**Seasonal character:**

| Season | Sound character |
|---|---|
| Late summer | Warm, slow, amber. Drone-like. Old stringed instruments, barely touched. |
| Early autumn | Cooler, deeper. Subtle tension beneath the warmth. |
| Deep winter | Minimal, cold, spacious. Long sustained tones. Very slow. |
| Midwinter | Same cold register, slightly more internal. Almost still. |
| First spring | Tentative, not yet warm. Ice-melt quality. Sparse. |

**Example — late summer ambient:**
```
ambient, slow and warm, meditative, no vocals, instrumental, bowed
string drone barely audible, very sparse acoustic texture, field
recording quality, wilderness atmosphere, ancient and unhurried, 45 BPM
```

**Example — deep winter ambient:**
```
ambient, cold and spacious, minimal, no vocals, instrumental, long
sustained string tones, near silence between notes, sparse high
harmonics, winter stillness, vast and empty, 35 BPM
```

---

## Played chapters — writing the prompt

Played chapters carry his instrument as the primary voice. Prose is minimal
or absent. The sound is the content.

The instrument evolves — see the era arc above. Every played chapter prompt
must reflect where the instrument is at that point in the story.

**Played chapter prompts always:**
- Feature his instrument as the dominant voice
- Are instrumental only
- Are slow — he plays in the wilderness, not for an audience
- Have the quality of something heard from a distance or through trees

**Example — Ch 44, first sound (Era 3, raw and uncertain):**
```
experimental folk, uncertain and searching, no vocals, instrumental,
handmade stringed instrument with rough imperfect resonance, like a
dulcimer built by someone who has never heard one, sparse hesitant
notes, wilderness acoustic space, raw and unpolished, 50 BPM
```

**Example — Ch 87, she hears him (Era 4, more controlled):**
```
ambient folk, meditative and private, no vocals, instrumental, handmade
drone string instrument, low warm resonance with slight buzz, occasional
harmonic overtone, played alone in open forest, distant and intimate,
warm analog texture, 45 BPM
```

**Example — Ch 190, final played chapter (Era 10, unrecognizable):**
```
experimental ambient, ancient and vast, no vocals, instrumental,
unidentifiable handmade stringed instrument, deep harmonic overtones
outside any known scale, resonant and unhurried, something between
drone and melody, wilderness acoustic, timeless quality, 40 BPM
```

---

## Output format

For each chapter, produce one prompt per sound type needed, clearly labeled:

```
**Sound type:** Ambient (sound effects) / Ambient (song) / Played chapter

**Suno mode:** Sounds → Loop / Music

**Prompt:**
[prompt text]

**Notes:**
[anything specific about how this should feel, or what to listen for
when evaluating the output]
```
