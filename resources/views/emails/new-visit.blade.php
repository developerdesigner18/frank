@component('mail::message')
# New Visit Opportunity!

A new visit has been created and is now available.

## Visit Details:

- **Branch:** {{ $visit->branch->branch_name ?? 'N/A' }}
- **Company:** {{ $visit->branch->company->company_name ?? 'N/A' }}
- **Questionnaire:** {{ $visit->questionnaire->name ?? 'N/A' }}
- **Start Date:** {{ \Carbon\Carbon::parse($visit->start_datetime)->locale('nl')->translatedFormat('d F Y') }}
- **End Date:** {{ \Carbon\Carbon::parse($visit->end_datetime)->locale('nl')->translatedFormat('d F Y') }}
- **Price:** {{ currency_icon() }}{{ $visit->price }}
- **Expense Estimate:** {{ currency_icon() }}{{ $visit->expense_estimation_min }} - {{ currency_icon() }}{{ $visit->expense_estimation_max }}

@if($visit->description)
{{ $visit->description }}
@endif

@component('mail::button', ['url' => route('visit.available')])
View Available Visits
@endcomponent

This is a great opportunity to participate in a mystery visit!

Thanks,<br>
{{ config('app.name') }}
@endcomponent
