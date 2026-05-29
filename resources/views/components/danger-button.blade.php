<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-red-600 rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-red-50 active:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
