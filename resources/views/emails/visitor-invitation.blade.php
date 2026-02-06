@component('mail::message')
    <h2>Hi,</h2>
    <p>You have been invited to CheckMijnZaak.</p>
    <p> @component('mail::button', ['url' => route('check-invitation',['cryptToken' => $cryptMail])])
            Accept Invitation
        @endcomponent</p>
@endcomponent
