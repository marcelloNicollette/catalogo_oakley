<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-[#E7E7E7] focus:bg-[#E7E7E7] active:bg-[#DADADA] focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
