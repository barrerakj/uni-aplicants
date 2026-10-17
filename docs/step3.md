# Step 3 — Results Widget

Add a dashboard table that shows each applicant's result: how many interviews they had, their average score, and their status.

Requires Steps 1 and 2.

## 1. Generate the widget

```bash
php artisan make:filament-widget ApplicantResults --table --panel=app
```

## 2. Query

Use `Applicant::query()` with:

- `->withCount('interviews')`.
- An `average_score` subquery: the average of `(communication + motivation + vocational_clarity) / 3` over the applicant's interviews. Making it a database column keeps it sortable.

## 3. Columns

- `name`: searchable.
- `program`: badge.
- `interviews_count`: label "Interviews".
- `average_score`: `->numeric(decimalPlaces: 1)`, sortable, with a color by value:
  - green when 4 or more
  - yellow when 3 or more
  - red when below 3
- `status`: badge.

## 4. Behavior

- Default sort: `average_score` descending, so the best candidates appear first.
- Filter by `program`.
- `protected int | string | array $columnSpan = 'full';`
- Row actions: **Admit** and **Reject**. Each is a `requiresConfirmation()` action that updates the status and is hidden when the status already matches.

## 5. Tests

Write a PHPUnit feature test that checks two things:

- The widget renders applicants ordered by average score.
- The Admit action updates the status.

## Done when

The dashboard at `/app` shows a full-width ranking of applicants. A user can admit or reject each one directly from that table.
