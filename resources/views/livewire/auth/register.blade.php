<div x-data="registerForm()" class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg">

    @if (session()->has('message'))
    <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="register">
        <x-form-input label="Name" name="name" type="text" />
        <x-form-input label="Email" name="email" type="email" />
        <x-form-input label="Password" name="password" type="password" />
        <x-form-input label="Confirm Password" name="password_confirmation" type="password" />

        <!-- Role Selection -->
        <x-role-select model="role" />

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
            Register
        </button>
    </form>
</div>

<script>
    function registerForm() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },

            validateName() {
                this.errors.name = this.name.length < 3 ? 'Name must be at least 3 characters.' : '';
            },

            validateEmail() {
                let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                this.errors.email = emailPattern.test(this.email) ? '' : 'Enter a valid email.';
            },

            validatePassword() {
                this.errors.password = this.password.length < 6 ? 'Password must be at least 6 characters.' : '';
            },

            validateConfirmPassword() {
                this.errors.password_confirmation =
                    this.password !== this.password_confirmation ? 'Passwords do not match.' : '';
            },

            submitForm() {
                this.validateName();
                this.validateEmail();
                this.validatePassword();
                this.validateConfirmPassword();

                if (!this.errors.name && !this.errors.email && !this.errors.password && !this.errors.password_confirmation) {
                    document.querySelector('form').submit();
                }
            }
        }
    }
</script>