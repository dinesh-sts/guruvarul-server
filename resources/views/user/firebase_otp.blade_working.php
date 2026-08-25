@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
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
    .phone-input {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        overflow: hidden;
        background: white;
    }
    .phone-code {
        background: #f1f1f1;
        padding: 10px;
        font-size: 16px;
        border-right: 1px solid #ccc;
        white-space: nowrap;
    }
    .phone-number {
        flex: 1;
        border: none;
        padding: 10px;
        font-size: 16px;
        outline: none;
    }
    button.btn-custom {
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
    p#status {
        margin-top: 10px;
        font-size: 14px;
    }
    .success { color: green; }
    .error { color: red; }
</style>
@endsection

@section('content')
<section class="inLogin mb-5 mt-5">
    <div class="otp-container">
        <h2>Login with OTP</h2>
        
        <label>Mobile Number</label>
        <div class="phone-input">
            <span class="phone-code">+91</span>
            <input type="tel" id="phoneNumber" class="phone-number" maxlength="10" placeholder="Enter 10-digit number" autofocus />
        </div>

        <div id="recaptcha-container" style="margin: 10px 0;"></div>

        <button id="sendOtpBtn" class="btn btnSecondary d-block w-100">Send OTP</button>

        <label style="margin-top:15px;">Enter OTP</label>
        <input type="text" id="otp" class="form-control" placeholder="Enter OTP" disabled />

        <button id="verifyOtpBtn" class="btn-custom" disabled>Verify OTP</button>

        <p id="status"></p>
    </div>
</section>
@endsection

@section('pageJS')
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
    import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

    /*const firebaseConfig = {
        apiKey: "AIzaSyDxTPy50nELZGUpZHm6ycTCPtAQQHEA-Nc",
        authDomain: "guruvarul-5ecce.firebaseapp.com",
        projectId: "guruvarul-5ecce",
        storageBucket: "guruvarul-5ecce.appspot.com",
        messagingSenderId: "812663943957",
        appId: "1:812663943957:web:d0dcfd4fd853876f3def1c",
        measurementId: "G-ZTD654HNL6"
    };*/
    // apiKey: "AIzaSyAaz2sOtg3_44MhX0Rzi8suLuJqQULutV0

    const firebaseConfig = {
        apiKey: "AIzaSyAaz2sOtg3_44MhX0Rzi8suLuJqQULutV0",
        authDomain: "guruvarul-6bac2.firebaseapp.com",
        projectId: "guruvarul-6bac2",
        storageBucket: "guruvarul-6bac2.appspot.com",
        messagingSenderId: "398504700947",
        appId: "1:398504700947:web:20cfd64168e171527563e6",
        measurementId: "G-XLWTWKBWS0"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    auth.languageCode = 'en';

    window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
        size: 'normal',
        callback: () => console.log('Recaptcha verified')
    });

    // Allow only numbers in phone input
    const phoneInput = document.getElementById('phoneNumber');
    phoneInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10); // Only digits, max 10
    });

    let confirmationResult;

    document.getElementById('sendOtpBtn').addEventListener('click', () => {
        const phoneNumberPart = phoneInput.value.trim();
        const statusEl = document.getElementById('status');

        if (!phoneNumberPart.match(/^\d{10}$/)) {
            statusEl.textContent = "Please enter a valid 10-digit mobile number.";
            statusEl.className = "error";
            return;
        }

        const fullNumber = "+91" + phoneNumberPart;

        document.getElementById('sendOtpBtn').disabled = true;
        statusEl.textContent = "Sending OTP...";
        statusEl.className = "";

        signInWithPhoneNumber(auth, fullNumber, window.recaptchaVerifier)
            .then((result) => {
                confirmationResult = result;
                statusEl.textContent = "OTP sent successfully!";
                statusEl.className = "success";

                // Enable OTP field & focus on it
                const otpInput = document.getElementById('otp');
                otpInput.disabled = false;
                otpInput.focus();

                document.getElementById('verifyOtpBtn').disabled = false;
            })
            .catch((error) => {
                console.error("Error sending OTP:", error);
                statusEl.textContent = "Failed to send OTP: " + error.message;
                statusEl.className = "error";
                document.getElementById('sendOtpBtn').disabled = false;
            });
    });

    document.getElementById('verifyOtpBtn').addEventListener('click', () => {
        const code = document.getElementById('otp').value.trim();
        const statusEl = document.getElementById('status');

        if (!code) {
            statusEl.textContent = "Please enter OTP.";
            statusEl.className = "error";
            return;
        }

        document.getElementById('verifyOtpBtn').disabled = true;
        statusEl.textContent = "Verifying OTP...";
        statusEl.className = "";

        confirmationResult.confirm(code)
            .then((result) => {
                const user = result.user;
                statusEl.textContent = "✅ OTP Verified! User ID: " + user.uid;
                statusEl.className = "success";
            })
            .catch((error) => {
                console.error("Error verifying OTP:", error);
                statusEl.textContent = "❌ Invalid OTP: " + error.message;
                statusEl.className = "error";
                document.getElementById('verifyOtpBtn').disabled = false;
            });
    });
</script>
@endsection
