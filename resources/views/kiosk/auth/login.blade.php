@extends('layouts.kiosk')

@section('content')
<div class="container py-2" style="max-width: 900px;">
    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-2" style="width: 70px; height: 70px;">
                    <i class="bi bi-shield-lock-fill fs-1"></i>
                </div>
                <h2 class="display-6 fw-bold text-dark mb-1">Student Authentication</h2>
                <p class="text-muted fs-5">Enter your Student ID and 4-digit Security PIN to access your records</p>
            </div>

            <div class="row g-4 align-items-center">
                <!-- Form Inputs -->
                <div class="col-md-6">
                    <form action="{{ route('kiosk.login.submit') }}" method="POST" id="kiosk-login-form">
                        @csrf

                        <!-- Student Number Input -->
                        <div class="mb-3">
                            <label for="student_number" class="form-label fs-5 fw-bold text-secondary">
                                <i class="bi bi-person-badge-fill me-1 text-primary"></i> Student Number
                            </label>
                            <input type="text"
                                   name="student_number"
                                   id="student_number"
                                   class="form-control form-control-lg fs-4 py-3 rounded-4 border-2 @error('student_number') is-invalid @enderror"
                                   placeholder="e.g. 2024-0001"
                                   value="{{ old('student_number') }}"
                                   required
                                   autocomplete="off"
                                   autofocus>
                            @error('student_number')
                                <div class="invalid-feedback fs-6">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- PIN Input -->
                        <div class="mb-4">
                            <label for="pin" class="form-label fs-5 fw-bold text-secondary">
                                <i class="bi bi-key-fill me-1 text-primary"></i> 4-Digit Security PIN
                            </label>
                            <input type="password"
                                   name="pin"
                                   id="pin"
                                   maxlength="6"
                                   class="form-control form-control-lg fs-3 py-3 rounded-4 border-2 text-center letter-spacing @error('pin') is-invalid @enderror"
                                   placeholder="&bull; &bull; &bull; &bull;"
                                   required
                                   autocomplete="off"
                                   readonly>
                            @error('pin')
                                <div class="invalid-feedback fs-6">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted small text-center mt-2">
                                <i class="bi bi-shield-check"></i> Never share your PIN with anyone on the kiosk.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-touch py-3 fs-4 shadow">
                                <i class="bi bi-arrow-right-circle-fill"></i> Sign In to Kiosk
                            </button>
                            <a href="{{ route('kiosk.home') }}" class="btn btn-outline-secondary btn-touch py-2 fs-6">
                                <i class="bi bi-x-circle"></i> Cancel & Return Home
                            </a>
                        </div>
                    </form>

                    <!-- Quick Testing Helper Pills -->
                    <div class="mt-4 p-3 bg-light rounded-4 border">
                        <small class="fw-bold text-muted text-uppercase d-block mb-2">
                            <i class="bi bi-lightbulb-fill text-warning"></i> Quick Demo Accounts (Tap to autofill):
                        </small>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill demo-btn" data-id="2024-0001" data-pin="1234">
                                Juan Dela Cruz (2024-0001)
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill demo-btn" data-id="2024-0002" data-pin="1234">
                                Maria Santos (2024-0002)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Touchscreen On-Screen Numeric Keypad for PIN -->
                <div class="col-md-6 border-start ps-md-4">
                    <div class="text-center mb-3">
                        <span class="badge bg-secondary-subtle text-secondary fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i> On-Screen Touch Keypad
                        </span>
                    </div>

                    <div class="row g-2 justify-content-center" style="max-width: 320px; margin: 0 auto;">
                        @for($i = 1; $i <= 9; $i++)
                            <div class="col-4">
                                <button type="button" class="btn btn-light border shadow-sm w-100 py-3 fs-3 fw-bold keypad-key rounded-4" data-key="{{ $i }}">
                                    {{ $i }}
                                </button>
                            </div>
                        @endfor
                        <div class="col-4">
                            <button type="button" class="btn btn-warning border shadow-sm w-100 py-3 fs-5 fw-bold text-dark keypad-clear rounded-4">
                                CLEAR
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-light border shadow-sm w-100 py-3 fs-3 fw-bold keypad-key rounded-4" data-key="0">
                                0
                            </button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-danger border shadow-sm w-100 py-3 fs-4 fw-bold keypad-backspace rounded-4">
                                <i class="bi bi-backspace-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pinInput = document.getElementById('pin');
        const studentInput = document.getElementById('student_number');

        // Touch Keypad Handling
        document.querySelectorAll('.keypad-key').forEach(btn => {
            btn.addEventListener('click', () => {
                if (pinInput.value.length < 6) {
                    pinInput.value += btn.getAttribute('data-key');
                }
            });
        });

        document.querySelector('.keypad-backspace')?.addEventListener('click', () => {
            pinInput.value = pinInput.value.slice(0, -1);
        });

        document.querySelector('.keypad-clear')?.addEventListener('click', () => {
            pinInput.value = '';
        });

        // Quick Demo Fill
        document.querySelectorAll('.demo-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                studentInput.value = btn.getAttribute('data-id');
                pinInput.value = btn.getAttribute('data-pin');
            });
        });
    });
</script>
@endpush
