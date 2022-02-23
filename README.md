# Vegano Meal Kit Platform

<small>* Please note: Project was extremely rushed with a 3 month deadline and no UX or wireframe design. Thus code is not optimize, testing does not exit.</small>

## Getting Started
1. Run `php artisan migrate --seed`
2. Run `php artisan vegano:create-admin` to create the admin user. 
    - admin username: `admin@vegano.com`
    - admin password: `St34lth!` (or what is set in .env)
3. Visit `/login` to sign in as admin.
4. Visit `/admin-dashboard` to view the admin dashboard

## Stack
- Laravel
- Vue.js
- Bootstrap.css
- Stripe
