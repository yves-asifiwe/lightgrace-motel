<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-lg border border-transparent bg-[#0d4a35] px-5 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-sm transition duration-150 ease-in-out hover:bg-[#1a6b4f] focus:outline-none focus:ring-2 focus:ring-[#38ef7d]/40 dark:bg-[#38ef7d] dark:text-[#0a2f1f] dark:hover:bg-[#5ef08f]']) }}>
    {{ $slot }}
</button>
