# Branch 1 — UI Foundation

## Branch

```bash
feature/ui-foundation
```

## Objective

Build the complete UI foundation for LawLens Morocco.

This branch must ONLY create the reusable design system and application layouts.

No business pages.

No landing page.

No authentication pages.

No dashboard content.

---

# Existing Configuration

Already configured:

- Tailwind CSS v4
- Vite
- Google Fonts
- app.css
- Vite build

Do NOT reinstall or modify these packages unless necessary.

---

# Tasks

## 1. Design System

Update:

```
resources/css/app.css
```

Create a complete design system.

### Color Palette

Primary

```
#0F766E
```

Secondary

```
#14B8A6
```

Accent

```
#C8A44D
```

Background

```
#F8FAFC
```

Surface

```
#FFFFFF
```

Dark

```
#0F172A
```

Border

```
#E2E8F0
```

Success

Warning

Danger

Info

Spacing

Border radius

Shadow tokens

Typography variables

---

## 2. Dark Mode

Prepare dark mode.

Do not implement toggle yet.

Only prepare classes and theme variables.

---

## 3. Layouts

Create

```
resources/views/layouts/

app.blade.php

guest.blade.php

entrepreneur.blade.php

admin.blade.php
```

Requirements

- Responsive
- Clean structure
- Uses Blade slots
- No duplicated code
- Extendable

---

## 4. Components

Create reusable Blade Components.

```
button.blade.php

card.blade.php

badge.blade.php

input.blade.php

textarea.blade.php

select.blade.php

modal.blade.php

alert.blade.php

loading.blade.php

empty-state.blade.php
```

Every component must support props.

Examples

Button

- Primary
- Secondary
- Outline
- Danger
- Ghost

Badge

- Success
- Warning
- Error
- Pending
- Info

Card

- Header
- Body
- Footer

Input

- Label
- Placeholder
- Validation
- Helper text

---

## 5. Shared Partials

Create

```
resources/views/components/

navbar.blade.php

sidebar.blade.php

footer.blade.php

logo.blade.php

dropdown.blade.php
```

Only structure.

No page-specific content.

---

## 6. Icons

Use Heroicons.

Never use FontAwesome.

---

## 7. Accessibility

Every component must support

- keyboard navigation
- focus states
- aria labels where necessary

---

## 8. Responsive

Components must work on

- Desktop
- Tablet
- Mobile

---

## 9. Code Rules

- Small Blade files
- No duplicated HTML
- Reusable Components
- Clean indentation
- Laravel Blade best practices

---

## 10. Verification

Create one temporary route to verify layouts.

```
/ui-preview
```

After verification, clearly indicate whether the route should be removed before production.

---

# Do NOT Build

Do NOT create

- Landing Page
- Login
- Register
- Dashboard
- Projects
- Roadmaps
- Admin Pages

Those belong to later branches.

---

# Commit

```bash
git add .
git commit -m "feat(ui): create reusable design system and layouts"
git push origin feature/ui-foundation
```

---

# STOP

After finishing:

- Test components
- Test layouts
- Push
- Open Pull Request

STOP.

Wait until the Pull Request is merged into **main**.

Never continue automatically.