@component('email.header')
@endcomponent
<span class="text">
    <h3>NEW OTP CODE</h3>
    Hello {{$user->username}}!
    <br>
    <br>
    Please use this code: <b>{{$otpCode}}</b> to continue login to ID Factory. Enjoy!
    <br>
    <br>
</span>
<span class="text">
    If you did not make this action, please <a href="http://idfactory.ph/#/reset_password/{{$user->username}}/{{$user->code}}">reset</a> your password to secure your account and reply to this message to notify us.
</span>
@component('email.footer')
@endcomponent

