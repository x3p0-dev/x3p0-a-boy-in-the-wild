---
description: Review text against the boy's writing voice and flag where it slips
argument-hint: "[file or 'diff' — defaults to the working-tree diff]"
---

Delegate this review to the `voice-reviewer` subagent (via the Agent tool).
It holds the voice standard and reports findings without editing.

## What to review

The target is: $ARGUMENTS

- If the target is empty or the word `diff`, the agent reviews the current
  working-tree changes — pass it the output of `git diff` and
  `git diff --staged`, and tell it to review only added/changed text.
- If the target is a file path, tell the agent to read and review that file.
- If the target is something else (a pasted excerpt, a chapter number),
  interpret it sensibly and pass the relevant text to the agent.

Relay the agent's findings to the user. Do not edit files — this is a review.
For a quick inline pass without spawning the agent, the user can ask directly
and you may use the `abitw-story-voice` skill yourself instead.
