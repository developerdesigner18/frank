@component('mail::message')
# Visit Approved

Hi {{ $visit->visitor->first_name ?? 'Visitor' }},

Good news — your visit has been **approved**!

@component('mail::panel')
    **Visit ID:** #{{ $visit->id }}
    **Branch:** {{ $visit->branch->branch_name ?? 'N/A' }}
    **Date & Time:** {{ \Carbon\Carbon::parse($visit->created_at)->locale('nl')->translatedFormat('l, d F Y H:i') ?? 'N/A' }}
    **Approved By:** Admin
@endcomponent

You can view or manage your visit using the button below:


Thanks,<br>
{{ config('app.name') }}
@endcomponent
