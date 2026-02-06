@component('mail::message')
<h2>Hello {{ $user->first_name ?? $user->name }},</h2>
<p>You recently requested to reset your password. Click the button below to proceed.</p>
<p>@component('mail::button', ['url' => $resetLink])
Reset Password
@endcomponent</p>
<p>If you didn't request this password reset, please ignore this email.</p>
<p>This password reset link will expire in 24 hours.</p>
@endcomponent
