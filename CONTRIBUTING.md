# How to Contribute

Thanks for taking the time to contribute! ❤️

This document describes how to propose changes, naming conventions, and quality checks.

## Table of contents
- [Getting started](#getting-started)
- [Workflow](#workflow)
- [Branch naming](#branch-naming)
- [Commits](#commits)
- [Pull Requests](#pull-requests)
- [Quality checks](#quality-checks)
- [Coding style](#coding-style)
- [Tests](#tests)
- [Documentation](#documentation)
- [Security](#security)

## Getting started

1. Create or choose an Issue (bug/feature/docs).
2. Fork the repository.
3. Clone your fork and add upstream remote:
   - `origin` → your fork
   - `upstream` → this repository
4. Create a branch from `main`.
5. Make changes, run checks, open a Pull Request.

## Workflow

- **One PR per issue** (keep it focused).
- Prefer small, reviewable PRs over large “mega changes”.
- If you’re unsure about the approach, open an Issue or Draft PR early.

## Branch naming

We use a simplified trunk-based workflow.

We use a Git branch naming follows Conventional Commit types:

- `feat/<short-slug>`
- `fix/<short-slug>`
- `docs/<short-slug>`
- `chore/<short-slug>`
- `refactor/<short-slug>`
- `test/<short-slug>`

Examples:
- `feat/create-sort-button-file`
- `fix/nullref-in-parser`
- `docs/update-readme`

Use kebab-case for slugs. Keep it short and descriptive.

## Commits

We follow **Conventional Commits**:
https://www.conventionalcommits.org/en/v1.0.0/

Format:
`<type>[optional scope]: <description>`

Examples:
- `feat: add sort button to file list`
- `fix(parser): handle null reference in metadata`
- `docs: update README setup instructions`

Notes:
- Use **imperative mood** in the description (e.g., “add”, “fix”, “update”).
- Reference the issue in the PR description using:
  `Closes #123` / `Fixes #123` / `Resolves #123`

## Pull Requests

Target branch: **`main`**.

### PR requirements
- Link the related Issue.
- Explain *what* changed and *why*.
- Add screenshots/gifs for UI changes (if applicable).
- Keep PRs focused: unrelated refactors should be separate PRs.

### PR checklist
- [ ] Branch name follows `feat/`, `fix/`, `docs/`…
- [ ] Commits follow Conventional Commits
- [ ] Tests added/updated (if behavior changed)
- [ ] Docs updated (if public behavior changed)
- [ ] Lint/format/test pass locally
- [ ] CI is green

## Quality checks

Run locally before opening a PR (adjust to your scripts):
- `composer lint`
- `composer test`

## Coding style

- Follow PSR-12.
- Use the project formatter/linter (if configured via Composer scripts).

## Tests

- Add tests for new behavior and bug fixes when possible.
- Prefer deterministic tests (no network/time dependencies).

## Documentation

- Update docs when you change public behavior, endpoints, CLI, config, or examples.
- Keep examples runnable.

## Security

If you discover a security issue, please **do not** open a public issue.
Instead, follow `SECURITY.md` (or contact the maintainer privately).
