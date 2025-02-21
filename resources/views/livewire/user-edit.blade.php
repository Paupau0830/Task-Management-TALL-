<div class="flex flex-wrap -mx-3">

    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            </div>

            <div class="my-auto ml-auto pr-6">
                <a class="inline-block px-8 py-2 m-0 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-fuchsia shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85" href="{{ url('user-management') }}">Back</a>
            </div>

            <!-- Content Start -->
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto" style="padding: 30px;">

                    <livewire:edit-component :id="$this->id" />

                </div>
            </div>
            <!-- Content End -->

        </div>
    </div>
</div>