@component('mail::message')
    <h2>Hi,</h2>
    <p>You have been invited to {{$company->company_name}}.</p>
    <p> @component('mail::button', ['url' => route('company.check-invitation',['cryptToken' => $cryptMail])])
            Accept Invitation
        @endcomponent</p>
@endcomponent
