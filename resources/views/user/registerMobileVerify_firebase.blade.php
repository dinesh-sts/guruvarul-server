@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .otp-container {
        max-width: 400px;
        margin: 40px auto;
        background: #fff;
        border-radius: 8px;
        padding: 20px 25px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
    }
    .otp-container h2 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .btn-custom {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    button#verifyOtpBtn {
        background-color: #28a745;
        color: white;
        margin-top: 5px;
    }
    #status {
        margin-top: 10px;
        font-size: 14px;
        text-align: center;
    }
    .success { color: green; }
    .error { color: red; }
</style>
@endsection

@section('content')
<section class="inMobileVerification mb-5 mt-5">
    <div class="otp-container">
        <h2>Verify Your Mobile Number</h2>
        <p>Enter OTP to verify your mobile number</p>

        <h5 class="text-center">+91-{{ substr_replace(Session::get('user_id'), "xxxxxx", 2, 6) }}</h5>
	<div id="recaptcha-container"></div>
        <button id="sendOtpBtn" class="btn btn-dark d-block w-100 mb-3">Send OTP</button>

        <input type="text" id="otpInput" class="form-control mb-3 text-center" placeholder="Enter OTP" maxlength="6" disabled>

        <button id="verifyOtpBtn" class="btn-custom" disabled>Verify OTP</button>

        <p id="status"></p>
    </div>
</section>
@endsection

@section('pageJS')
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, signInWithPhoneNumber, RecaptchaVerifier } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyAaz2sOtg3_44MhX0Rzi8suLuJqQULutV0",
    authDomain: "guruvarul-6bac2.firebaseapp.com",
    projectId: "guruvarul-6bac2",
    storageBucket: "guruvarul-6bac2.appspot.com",
    messagingSenderId: "398504700947",
    appId: "1:398504700947:web:20cfd64168e171527563e6",
    measurementId: "G-XLWTWKBWS0"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
auth.languageCode = 'en';

let confirmationResult;

const sendOtpBtn = document.getElementById('sendOtpBtn');
const verifyOtpBtn = document.getElementById('verifyOtpBtn');
const otpInput = document.getElementById('otpInput');
const statusEl = document.getElementById('status');

// Send OTP when user clicks the button
sendOtpBtn.addEventListener('click', () => {
    sendOtpBtn.disabled = true;
    statusEl.textContent = "Sending OTP...";

    const phoneNumber = "+91{{ Session::get('user_id') }}";

    // Create RecaptchaVerifier for production (captcha required)
    const recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
	    size: 'normal',
	    callback: (response) => console.log('Recaptcha solved', response)
    });

    signInWithPhoneNumber(auth, phoneNumber, recaptchaVerifier)
        .then((result) => {
            confirmationResult = result;
            statusEl.textContent = "✅ OTP sent successfully!";
            otpInput.disabled = false;
            otpInput.focus();
            verifyOtpBtn.disabled = false;
        })
        .catch((error) => {
            console.error(error);
            statusEl.textContent = "❌ Failed to send OTP: " + error.message;
            sendOtpBtn.disabled = false;
        });
});

// Verify OTP and send phone + UID to server
verifyOtpBtn.addEventListener('click', () => {
    const code = otpInput.value.trim();
    if (!code) {
        statusEl.textContent = "❌ Please enter OTP";
        return;
    }

    statusEl.textContent = "Verifying OTP...";
    verifyOtpBtn.disabled = true;

    confirmationResult.confirm(code)
        .then((result) => {
            const firebaseUser = result.user;
            statusEl.textContent = "✅ OTP Verified! Completing registration...";

            fetch("{{ route('user.registerOtpVerify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({
                    phone: "{{ Session::get('user_id') }}",
                    uid: firebaseUser.uid
                }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = data.redirect;
                } else {
                    statusEl.textContent = "❌ " + (data.message || "Verification failed");
                    verifyOtpBtn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                statusEl.textContent = "❌ Something went wrong";
                verifyOtpBtn.disabled = false;
            });
        })
        .catch((error) => {
            console.error(error);
            statusEl.textContent = "❌ Invalid OTP: " + error.message;
            verifyOtpBtn.disabled = false;
        });
});
</script>
@endsection
