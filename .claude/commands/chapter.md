---
description: Orchestrate a full chapter build, in order
argument-hint: "<chapter number>"
---

Build chapter $1 end to end. This is an orchestration command — follow the
sequence, and stop for the user's input at each decision gate rather than
running straight through.

## Read first

- `.claude/docs/private/story-outline.md` — the outline entry for chapter $1.
  This is the source of truth. Read it before anything else.
- `.claude/docs/private/story-continuity.md` — what is built and established.

## Sequence

1. **Design** — Use `abitw-chapter-design`. Produce the design brief for
   chapter $1 (same as `/design-brief`). Stop and confirm the direction with
   the user before building.
2. **Content** — Use `abitw-chapter-content` and `abitw-story-voice`. Write
   the chapter prose from the outline.
3. **Sketches and sound** — Use `abitw-sketch-briefs` and `abitw-sound-briefs`
   for any images and audio the brief calls for.
4. **Build** — Use `abitw-patterns` (and `abitw-canvas-effects`,
   `abitw-block-style-variations` as the brief requires) to build the chapter
   pattern.
5. **Check** — Run a continuity pass against canon and a voice pass over all
   text before calling it done (`/continuity-check $1`, `/voice-check`).

Honour the project's working conventions throughout. Do not skip the design
gate — the brief is approved before the build begins.
