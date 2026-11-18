<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

<!-- LOCAL_UIUX_ROUTING_BEGIN -->
## Local UI/UX Skills routing (Codex)
Use relevant skills only; do NOT load all UI/UX skills for every task.
- New pages, layout direction, color and typography: `ui-ux-pro-max` and `frontend-design`.
- Forms, dashboards, cards and component rules: `ui-design-brain`.
- Responsive behavior, mobile-first layout and RTL logical properties: `responsive-design`.
- User flows, validation, feedback, animations and states: `interaction-design`.
- Accessibility checks: `accessibility`; web UI code review: `web-design-guidelines`.
- Visual polish and critique: `impeccable`; distinctive marketing/landing pages: `design-taste-frontend`.
- Larger design-system analysis, tokens and optional visual QA gates: `ux-ui-agent-skills`.

For the Luqya project: keep Laravel Blade, HTML, CSS, vanilla JavaScript, Arabic RTL and the established Mint Atelier design system. Do not introduce React, replace existing colors or mix Tailwind and Bootstrap in a component unless explicitly requested. Preserve existing layouts and functionality unless redesign is requested. Validate mobile, desktop, dark/hover/focus/error/empty/loading states as applicable. Never claim a browser QA pass without actual checks. Keep output concise; load only needed skill references.
<!-- LOCAL_UIUX_ROUTING_END -->


## Automatic Skill Orchestration

1. At the beginning of every task, consider all available system, installed plugin, user, and project skills based on their descriptions and applicability.
2. Automatically select and invoke relevant skills without requiring the user to name them.
3. Combine complementary skills when beneficial, including Laravel architecture, clean code, security, performance, testing, database, debugging, UI/UX, responsive design, accessibility and design review.
4. Do not activate every skill indiscriminately. Select the smallest useful set, expanding only for complex tasks.
5. Read full SKILL.md files and references only for selected skills. Never load all skills merely to inspect them.
6. Follow project architecture, Laravel Blade, RTL, established design tokens, and existing coding standards.
7. Verify important changes using appropriate tests, checks or browser review. Never claim verification without actually running it.
8. Do not modify unrelated files, add unnecessary dependencies, or publish changes without authorization.
9. If a required skill is not discoverable, report its exact name and missing path instead of pretending it was applied.
10. Keep final responses concise: selected skills, changes, verification and remaining issues.
