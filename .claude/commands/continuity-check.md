---
description: Check a chapter draft against story canon for contradictions
argument-hint: "<chapter number> [file]"
---

Delegate this check to the `continuity-keeper` subagent (via the Agent tool).
It holds the canon sources and reports contradictions without editing.

## What to pass it

Chapter and target: $ARGUMENTS

- Tell the agent which chapter to check.
- If a file path is given, pass it so the agent reads that draft. Otherwise
  ask it to locate the draft for this chapter in the theme (patterns,
  content), or have the user point to it first.

The agent reads the outline, continuity, and foundation docs itself and checks
character facts, the buried thing, the timeline, sealed-chapter keys, and the
page record. Relay its report — hard contradictions and open questions kept
separate. Do not edit files. For a quick inline pass without spawning the
agent, the user can ask directly and you may read the canon docs yourself.
