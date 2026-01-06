@if (session($type))
    <div id="flash-message"
        class="mb-5 rounded-xl border px-4 py-3 transition-opacity duration-700 opacity-100
         {{ $type === 'success' ? 'bg-green-50 border-green-200 text-green-700' : '' }}
         {{ $type === 'error' ? 'bg-red-50 border-red-200 text-red-700' : '' }}">
        {{ session($type) }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                setTimeout(() => flash.classList.add('opacity-0'), 2500);
                setTimeout(() => flash.remove(), 3500);
            }
        });
    </script>
@endif
