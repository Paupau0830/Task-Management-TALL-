<div class="flex flex-wrap -mx-3">

    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>All users</h6>
                <!-- <p>Here you can manage users.</p> -->
            </div>

            <div class="my-auto ml-auto pr-6">
                <x-back-button href="{{ url('user-register') }}">+&nbsp;
                    Add User</x-back-button>
            </div>

            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto" style="padding: 30px;">
                    <livewire:users-table />
                </div>
            </div>
        </div>
    </div>
</div>