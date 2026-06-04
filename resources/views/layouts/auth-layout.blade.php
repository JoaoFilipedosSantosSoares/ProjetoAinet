@component('layouts.main-content')

<main class="min-h-screen bg-background">
    <div class="container mx-auto flex min-h-[calc(100vh-200px)] items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm">
                
                <x-auth-header
                    :title="$title"
                    :description="$description" />

                <div class="p-6">
                    
                    @yield('auth-form')

                </div>
            </div>
        </div>
    </div>
</main>

@endcomponent