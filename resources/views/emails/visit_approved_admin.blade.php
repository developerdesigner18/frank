@component('mail::message')
# Visit Approved (Admin Notification)

Hello Admin,

A visit request was approved. Here are the details:

@component('mail::table')
    | Field        | Value |
    |--------------|-------|
    | Visit ID     | #{{ $visit->id }} |
    | Visitor      | {{ $visit->visitor->name ?? $visit->visitor->name ?? 'N/A' }} |
    | Branch       | {{ $visit->branch->branch_name ?? 'N/A' }} |
    | Date & Time  | {{ \Carbon\Carbon::parse($visit->visit_date)->locale('nl')->translatedFormat('l, d F Y H:i') ?? 'N/A' }} |
    | Status       | **Approved** |
    | Approved By  | {{ $visit->approved_by_name ?? 'System' }} |
    | Notes        | {{ $visit->admin_notes ?? '-' }} |
@endcomponent

@component('mail::button', ['url' => url('/admin/visits/' . $visit->id)])
    Open Visit in Admin Panel
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
