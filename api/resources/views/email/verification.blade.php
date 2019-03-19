@component('email.header')
@endcomponent
<span class="text">
    <h3>Email Verification</h3>
    Hello {{$user->username}}!
    <br>
    <br>
    <label class="text-secondary">Welcome to ID Factory!</label>
    <br>
    We just need to verify that {{$user->email}} is your email address.
    <br>
    Click the button below to:
    <br>
    <a href="http://idfactory.ph/#/login_verification/{{$user->username}}/{{$user->code}}">
        <button class="button">Confirm</button>
    </a>
    <br>
</span>
<span class="text">
    If you did not make this change, please <a href="http://idfactory.ph/#/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account and reply to this message to notify us.
</span>
@component('email.footer')
@endcomponent