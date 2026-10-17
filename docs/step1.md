# Step 1 — Applicant Resource

Build the Filament resource to list, create, edit, and view applicants.

The panel lives at `/app`. The `Applicant` model and the `Program` / `ApplicantStatus` enums already exist.

## 0. Prerequisites

```bash
php artisan migrate
php artisan make:filament-user
```

## 1. Generate the resource

```bash
php artisan make:filament-resource Applicant --generate --view --record-title-attribute=name
```

This creates `app/Filament/Resources/Applicants/` with:

- `ApplicantResource.php`: the resource itself
- `Schemas/ApplicantForm.php`: the form
- `Schemas/ApplicantInfolist.php`: the view page
- `Tables/ApplicantsTable.php`: the table
- `Pages/`: list, create, edit, and view pages

Open `/app/applicants`. Thanks to `--generate`, it already works.

## 2. Polish the form (`Schemas/ApplicantForm.php`)

- `email`: add `->email()` and `->unique(ignoreRecord: true)`.
- `phone`: add `->tel()`.
- `program`: change it to `Select::make('program')->options(Program::class)->required()`.
- `status`: change it to `Select::make('status')->options(ApplicantStatus::class)->default(ApplicantStatus::Pending)->required()`.

The enums implement `HasLabel`, so the selects show friendly labels with no extra code.

## 3. Polish the table (`Tables/ApplicantsTable.php`)

- `name` and `email`: add `->searchable()->sortable()`.
- `program`: add `->badge()`.
- `status`: add `->badge()`. The colors come from `ApplicantStatus::getColor()`.
- `phone`, `previous_school`, and the timestamps: add `->toggleable(isToggledHiddenByDefault: true)`.
- Add two filters:

```php
->filters([
    SelectFilter::make('program')->options(Program::class),
    SelectFilter::make('status')->options(ApplicantStatus::class),
])
```

## 4. Navigation

In `ApplicantResource.php`, set:

```php
protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedAcademicCap;
```

## Done when

- You can create, edit, view, and delete applicants from `/app/applicants`.
- Status shows as a colored badge.
- Search by name or email works.
- You can filter by program and by status.
