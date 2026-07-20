# Apex Academy

> Good employees are expensive. Fresh graduates are unproven. Apex Academy closes that gap.

An AI-driven employee training and development platform that assesses who someone is, teaches them what they need to know, keeps them sharp every day, and tracks their actual work — all visualized like a game.

## Tech Stack

- **Backend:** Laravel (fullstack — Blade + controllers, no separate frontend SPA)
- **Frontend:** Tailwind CSS, Alpine.js (Laravel defaults), GSAP for animations
- **Charts & Graphs:** D3.js
- **Database:** SQLite (dev) / MySQL (production)
- **Auth:** Laravel Breeze (session-based)
- **Testing:** PHPUnit — TDD methodology

## Requirements

- PHP 8.3+
- Composer
- Node.js + NPM
- SQLite (dev) or MySQL (production)

## Setup

```bash
git clone git@github.com:cyddalupan/apexacademy.git
cd apexacademy

cp .env.example .env
php artisan key:generate

# Database
touch database/database.sqlite
php artisan migrate --seed

# Frontend
npm install
npm run build

# Serve
php artisan serve
```

## Development Guidelines

### TDD

All features are developed test-first using PHPUnit.

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=TrainingModuleTest
```

### Code Style

- Laravel Pint for PSR-12 coding standards
- Controllers are thin — business logic in services/actions
- Blade for views, no Vue/React
- Livewire for reactive components when needed

### Architecture

- **P1 — Foundation Core:** Auth, companies, employees, positions, training CRUD, training loop
- **P2 — 9-Attribute Engine:** Character assessment, attributes, character sheet (D3.js radar chart)
- **P3 — Daily Habit:** Two-section daily habit with AI-generated trivia
- **P4 — Quest System + Streak Calendar:** Cadence-based tasks, visual calendar with GSAP animations
- **P5 — Reports, Configs, Polish:** Reports (D3.js charts), notifications, edge cases

## Deployment

Production: `https://apexacademy.toybits.cloud`

Apache with mod_php. SSL via Let's Encrypt.

## License

Proprietary — Toybits
