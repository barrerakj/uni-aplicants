# University Applicants — Demo Plan

A small Filament (v5) demo app where a university faculty registers applicants, interviews them, and decides who gets admitted. The goal is to show how much Filament gives you with very little code.

## Data Model

### `applicants`

| Column              | Type   | Notes                                                        |
|---------------------|--------|--------------------------------------------------------------|
| `id`                | id     |                                                              |
| `name`              | string |                                                              |
| `email`             | string | unique                                                       |
| `phone`             | string | nullable                                                     |
| `previous_school`   | string | high school the applicant comes from                         |
| `program`           | string | cast to `Program` enum                                       |
| `status`            | string | cast to `ApplicantStatus` enum, default `pending`            |
| timestamps          |        |                                                              |

### `interviews`

| Column                  | Type            | Notes                                         |
|-------------------------|-----------------|-----------------------------------------------|
| `id`                    | id              |                                               |
| `applicant_id`          | foreignId       | constrained, cascade on delete                |
| `interviewer`           | string          | plain name, no users table needed             |
| `interviewed_at`        | date            |                                               |
| `communication`         | unsignedTinyInt | 1–5                                           |
| `motivation`            | unsignedTinyInt | 1–5                                           |
| `vocational_clarity`    | unsignedTinyInt | 1–5                                           |
| `comments`              | text            | nullable                                      |
| timestamps              |                 |                                               |

### Enums

- `Program`: `Engineering`, `Law`, `Medicine`, `Economics`, `Architecture`
- `ApplicantStatus`: `Pending`, `Interviewed`, `Admitted`, `Rejected`

Both implement Filament's `HasLabel` (and `HasColor` for status) so badges and selects work out of the box.

### Relationships

- `Applicant` hasMany `Interview`
- `Interview` belongsTo `Applicant`
- `Interview` gets an `average_score` accessor (mean of the three ratings).

## Filament

### `ApplicantResource`

- **Table**: name, email, program (badge), status (colored badge), interviews count, average score. Searchable by name/email; filters by program and status.
- **Form**: name, email, phone, previous school, program (select), status (select).
- **Interviews relation manager** on the edit/view page so interviews are created right from the applicant.
- **Actions**: `Admit` and `Reject` row actions (with confirmation) that update the status; bulk versions too.

### `InterviewResource` (optional)

A flat list of all interviews with filters by interviewer and date — useful to show cross-resource navigation.

### Behavior

- When the first interview is created for a `pending` applicant, set the status to `interviewed`.
- Ratings in the form use a select or radio with values 1–5.

### Dashboard Widgets

- Stats overview: total applicants, pending, interviewed, admitted.
- Chart: applicants per program.

## Seed Data

Factories for both models and a seeder with ~50 applicants spread across programs and statuses, most with 1–2 interviews, so the demo looks alive right away.

## Tests

Feature tests (PHPUnit) for:

- Listing, creating, and editing applicants in the Filament resource.
- Creating an interview through the relation manager and the status change to `interviewed`.
- The `Admit` / `Reject` actions.

## Build Order

1. Enums, migrations, models, factories, seeder.
2. `ApplicantResource` with form and table.
3. Interviews relation manager + status automation.
4. Admit / Reject actions.
5. Dashboard widgets.
6. Tests, then `vendor/bin/pint --dirty`.
