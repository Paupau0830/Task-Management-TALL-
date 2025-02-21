<div class="bg-white p-4 rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-4">Comments</h2>

    <!-- Comment Input -->
    <div class="mb-4">
        <textarea wire:model="newComment" class="w-full p-2 border rounded-lg" placeholder="Add a comment..."></textarea>
        @error('newComment') <span class="text-red-500">{{ $message }}</span> @enderror
        <button wire:click="addComment" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Add Comment
        </button>
    </div>

    <!-- Comment List -->
    <div class="space-y-3">
        @foreach ($comments as $comment)
        <div class="p-3 bg-gray-100 rounded-lg relative">
            <p class="text-sm"><strong>{{ $comment->user->name }}</strong>:</p>
            <p class="text-gray-700">{{ $comment->content }}</p>
            <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>

            @if ($comment->user_id === auth()->id())
            <button wire:click="deleteComment({{ $comment->id }})" class="absolute top-1 right-2 text-red-500 text-xs">
                Delete
            </button>
            @endif
        </div>
        @endforeach
    </div>
</div>