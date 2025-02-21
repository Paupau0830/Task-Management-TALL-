<div x-data="editForm()" class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg">

    @if (session()->has('message'))
    <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="updateUser">
        <div x-data="{ name: '{{ $name }}', email: '{{ $email }}' }">
            <x-form-input label="Name" name="name" type="text" placeholder="User name" x-model="name" />
            <x-form-input label="Email" name="email" type="email" placeholder="User email" x-model="email" />
        </div>
        <x-form-input label="Password" name="password" type="password" placeholder="Password" wire:model="password" />
        <x-form-input label="Confirm Password" name="password_confirmation" type="password" placeholder="Password Confirmation" wire:model="password_confirmation" />

        <!-- Role Selection -->
        <x-role-select model="role" />

        <!-- User Permissions -->
        <div class="mt-4">
            <label class="font-semibold">Assign Permissions:</label>

            <x-permission-checkbox label="Manage Users" name="manageUsers" wire:model="manageUsers" />
            <x-permission-checkbox label="Manage Legends" name="manageLegends" wire:model="manageLegends" />
            <x-permission-checkbox label="Edit Tasks" name="editTasks" wire:model="editTasks" />
            <x-permission-checkbox label="Delete Tasks" name="deleteTasks" wire:model="deleteTasks" />
            <x-permission-checkbox label="Create Tasks" name="createTasks" wire:model="createTasks" />
        </div>

        <br>

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
            Update User
        </button>
    </form>
</div>

<script>
    function editForm() {
        return {

            validateName() {
                this.errors.name = this.name.length < 3 ? 'Name must be at least 3 characters.' : '';
            },

            validateEmail() {
                let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                this.errors.email = emailPattern.test(this.email) ? '' : 'Enter a valid email.';
            },

            submitForm() {
                this.validateName();
                this.validateEmail();

                if (!this.errors.name && !this.errors.email) {
                    document.querySelector('form').submit();
                }
            }
        }
    }
</script>