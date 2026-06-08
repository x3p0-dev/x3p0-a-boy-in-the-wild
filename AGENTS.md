# A Boy in the Wild — Agent Project Context

A WordPress block theme for a serialized episodic story. Read `.claude/docs/private/project-brief.md` for full orientation.

---

## Key documents

| Document | Purpose |
|---|---|
| `.claude/docs/private/story-outline.md` | Source of truth for chapter content — read before any chapter work |
| `.claude/docs/private/story-continuity.md` | What's built, what's established on the page, design decisions |
| `.claude/docs/private/story-foundation.md` | Backstory, themes, emotional arc |
| `.claude/docs/private/project-brief.md` | General orientation, build status, key file paths |
| `.claude/docs/public/style-system-overview.md` | Colour, typography, spacing, and style variation reference |

---

## Skills

Read the relevant skill before starting any task that falls into its area.

| Task | Skill |
|---|---|
| Writing any JS | `.claude/skills/x3p0-code-style-js/` |
| Writing any PHP | `.claude/skills/x3p0-code-style-php/` |
| Writing or modifying canvas effects | `.claude/skills/abitw-canvas-effects/` |
| Designing or building a chapter pattern | `.claude/skills/abitw-chapter-design/` + `.claude/skills/abitw-patterns/` |
| Writing any pattern file | `.claude/skills/x3p0-theme-patterns/` + `.claude/skills/abitw-patterns/` |
| Creating or modifying block/section style variations | `.claude/skills/x3p0-theme-block-style-variations/` + `.claude/skills/abitw-block-style-variations/` |
| Writing any text in the theme or story | `.claude/skills/abitw-story-voice/` |
| Writing chapter prose | `.claude/skills/abitw-story-voice/` + `.claude/skills/abitw-chapter-content/` |
| Writing sketch briefs or image prompts | `.claude/skills/abitw-sketch-briefs/` |
| Writing sound briefs or Suno prompts | `.claude/skills/abitw-sound-briefs/` |

---

## Commands

Slash commands that run a task inline. Each reads the outline entry for the
chapter and pulls the skills above. Type `/` to list them.

| Command | Args | Purpose |
|---|---|---|
| `/chapter` | `<N>` | Orchestrate a full chapter build, in order, stopping at the design gate |
| `/design-brief` | `<N>` | Write the design brief for a chapter |
| `/sketch-brief` | `<N>` | Photoshop prompt, caption, and alt text per sketch |
| `/sound-brief` | `<N>` | Suno prompts for a chapter, or none if it wants silence |
| `/voice-check` | `[file or diff]` | Review text against the boy's voice (delegates to `voice-reviewer`) |
| `/continuity-check` | `<N> [file]` | Check a draft against canon (delegates to `continuity-keeper`) |

---

## Agents

Read-only verification subagents. Use them as an isolated or parallel second
pass on drafted work — they report, they do not edit. The two checker commands
above delegate to these; invoke an agent directly to fan out (e.g. check
several drafts at once).

| Agent | Checks |
|---|---|
| `continuity-keeper` | A draft against canon — character facts, the buried thing, timeline, sealed-chapter keys, the page record |
| `voice-reviewer` | Any reader-facing text against the boy's voice, age-aware to the chapter |
