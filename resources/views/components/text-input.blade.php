@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition duration-150 ease-in-out hover:border-[#0d4a35] focus:border-[#0d4a35] focus:outline-none focus:ring-2 focus:ring-[#38ef7d]/40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:hover:border-[#38ef7d] dark:focus:border-[#38ef7d] dark:focus:ring-[#38ef7d]/30']) }}>
