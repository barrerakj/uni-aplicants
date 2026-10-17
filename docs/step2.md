# Step 2 — Interview Resource

Build a resource to record interviews, and show each applicant's interviews on the applicant's page.

Requires Step 1.

## 1. Generate the resource

```bash
php artisan make:filament-resource Interview --generate --view
```

## 2. Form (`Interviews/Schemas/InterviewForm.php`)

- `applicant_id`: `Select::make('applicant_id')->relationship('applicant', 'name')->searchable()->preload()->required()`.
- `interviewer`: `TextInput`, required.
- `interviewed_at`: `DatePicker`, required, default `now()`.
- `communication`, `motivation`, and `vocational_clarity`: use `ToggleButtons` with options `1`–`5`, `->inline()->required()`.
- `comments`: `Textarea` with `->columnSpanFull()`.
- Group the three ratings in a `Section::make('Ratings')->columns(3)`.

## 3. Table (`Interviews/Tables/InterviewsTable.php`)

- Columns:
  - `applicant.name`: searchable and sortable.
  - `interviewer`: searchable.
  - `interviewed_at`: `->date()`, sortable.
  - The three ratings: numeric and centered.
  - `average_score`: from the model accessor.
- Default sort: `->defaultSort('interviewed_at', 'desc')`.
- Filter: `SelectFilter::make('applicant')->relationship('applicant', 'name')`.

## 4. Interviews on the applicant page

```bash
php artisan make:filament-relation-manager ApplicantResource interviews interviewer --form-schema="App\Filament\Resources\Interviews\Schemas\InterviewForm" --table="App\Filament\Resources\Interviews\Tables\InterviewsTable"
```

Then:

- Register it in `ApplicantResource::getRelations()`.
- Hide the `applicant_id` field and the `applicant.name` column when they are rendered inside the relation manager. The applicant is already known there.

## 5. Status automation

In `Interview::booted()`, on `created`: if the applicant's status is `Pending`, set it to `Interviewed`.

## 6. Tests

Write PHPUnit feature tests for:

- Creating an interview from the resource.
- Creating an interview from the relation manager.
- The status changing from `Pending` to `Interviewed`.

## Done when

- Interviews can be managed from `/app/interviews`, and from each applicant's view and edit page.
- The first interview moves a pending applicant to "Interviewed".
