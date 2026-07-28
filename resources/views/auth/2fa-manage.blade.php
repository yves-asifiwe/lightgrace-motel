@extends('layouts.app')

@section('title', 'Manage Two-Factor Authentication')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600">
                <h2 class="text-2xl font-bold text-white">Two-Factor Authentication</h2>
            </div>
            
            <div class="p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                        {{ session('info') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Status</h3>
                            <p class="text-gray-600 text-sm">
                                @if($user->hasTwoFactorEnabled())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Enabled
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Disabled
                                    </span>
                                @endif
                            </p>
                        </div>
                        @if(!$user->hasTwoFactorEnabled())
                            <a href="{{ route('2fa.setup') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enable 2FA
                            </a>
                        @endif
                    </div>
                </div>

                @if($user->hasTwoFactorEnabled())
                    <!-- Recovery Codes -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recovery Codes</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Store these recovery codes in a secure location. You can use them to access your account if you lose your authenticator device.
                        </p>
                        
                        @if(session('recovery_codes'))
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <p class="text-sm text-yellow-800 font-medium mb-2">
                                    ⚠️ Save these codes now. You won't see them again!
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach(session('recovery_codes') as $code)
                                        <code class="bg-white px-2 py-1 rounded text-sm">{{ $code }}</code>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!empty($recoveryCodes))
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                                <p class="text-sm text-gray-600 mb-2">
                                    You have {{ count($recoveryCodes) }} remaining recovery codes.
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($recoveryCodes as $code)
                                        <code class="bg-white px-2 py-1 rounded text-sm">••••••••</code>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <p class="text-sm text-red-600">
                                    You have no recovery codes remaining. Please regenerate them.
                                </p>
                            </div>
                        @endif

                        <form action="{{ route('2fa.regenerate-codes') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                Regenerate Recovery Codes
                            </button>
                        </form>
                    </div>

                    <!-- Disable 2FA -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold text-red-600 mb-4">Disable Two-Factor Authentication</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            Disabling 2FA will make your account less secure. You can enable it again at any time.
                        </p>
                        
                        <form action="{{ route('2fa.disable') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Confirm your password
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required
                                    class="mt-1 appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                    placeholder="Enter your password"
                                >
                            </div>
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                Disable 2FA
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
