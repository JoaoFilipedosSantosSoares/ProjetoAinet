@component('layouts.main-content', ['type' => 'Catalogo'])
    @php
        $categories = ['Todos', 'Natureza', 'Geek', 'Arte', 'Música'];
        $catalogImages = [
            ['id' => 1, 'name' => 'Floresta Lunar', 'category' => 'Natureza', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Floresta+Lunar'],
            ['id' => 2, 'name' => 'Coração Tech', 'category' => 'Geek', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Coração+Tech'],
            ['id' => 3, 'name' => 'Rosa Tribal', 'category' => 'Arte', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Rosa+Tribal'],
            ['id' => 4, 'name' => 'Guitarra Neon', 'category' => 'Música', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Guitarra+Neon'],
            ['id' => 5, 'name' => 'Céu Estrelado', 'category' => 'Natureza', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Céu+Estrelado'],
            ['id' => 6, 'name' => 'Pixel Retro', 'category' => 'Geek', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Pixel+Retro'],
            ['id' => 7, 'name' => 'Lobo Geométrico', 'category' => 'Arte', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Lobo+Geométrico'],
            ['id' => 8, 'name' => 'Onda Sonora', 'category' => 'Música', 'imageUrl' => 'https://via.placeholder.com/900x900.png?text=Onda+Sonora'],
        ];
    @endphp

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight md:text-4xl">Catálogo de Designs</h1>
            <p class="mt-2 text-muted-foreground">Escolhe um design do nosso catálogo e personaliza a tua t-shirt</p>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-2" id="category-filter">
            @foreach ($categories as $category)
                <button
                    type="button"
                    class="category-button transition-all rounded-full border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 {{ $loop->first ? 'bg-zinc-900 text-white shadow-md' : '' }}"
                    data-category="{{ $category }}"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4" id="catalog-grid">
            @foreach ($catalogImages as $image)
                <button
                    type="button"
                    class="product-card group relative aspect-square overflow-hidden rounded-xl bg-card shadow-sm transition-all hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    data-id="{{ $image['id'] }}"
                    data-category="{{ $image['category'] }}"
                >
                    <img
                        src="{{ $image['imageUrl'] }}"
                        alt="{{ $image['name'] }}"
                        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                    />
                    <div class="absolute inset-0 bg-linear-to-t from-foreground/80 via-transparent to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4 text-left text-primary-foreground opacity-0 transition-opacity group-hover:opacity-100">
                        <p class="font-semibold">{{ $image['name'] }}</p>
                        <p class="text-sm text-primary-foreground/80">{{ $image['category'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>

        <div id="empty-state" class="mt-12 text-center text-muted-foreground hidden">
            Nenhum design encontrado nesta categoria.
        </div>

        <div id="product-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
            <div class="relative w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                <button
                    type="button"
                    class="modal-close-button absolute right-4 top-4 inline-flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-700 transition hover:bg-zinc-200"
                    aria-label="Fechar modal"
                >
                    ×
                </button>
                <div class="grid gap-6 p-6 md:grid-cols-[1.4fr_0.8fr]">
                    <div class="relative aspect-square overflow-hidden rounded-3xl bg-zinc-100">
                        <img id="modal-image" src="" alt="" class="object-cover w-full h-full" />
                    </div>
                    <div class="flex flex-col gap-4">
                        <div>
                            <p id="modal-category" class="text-sm uppercase tracking-[0.2em] text-muted-foreground"></p>
                            <h2 id="modal-name" class="mt-2 text-3xl font-bold"></h2>
                        </div>
                        <p class="text-sm leading-6 text-muted-foreground">
                            Escolhe este design para personalizar a tua t-shirt com facilidade. Adiciona quantidades e finaliza a encomenda quando estiver pronto.
                        </p>
                        <div class="mt-auto flex flex-col gap-3 sm:flex-row">
                            <button
                                type="button"
                                id="modal-buy"
                                class="inline-flex justify-center rounded-lg bg-zinc-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-950"
                            >
                                Escolher design
                            </button>
                            <button
                                type="button"
                                class="modal-close-button inline-flex justify-center rounded-lg border border-zinc-300 bg-white px-5 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50"
                            >
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- tirar esta parte toda -->
    <script>
        const categories = @json($categories);
        const images = @json($catalogImages);
        const categoryButtons = document.querySelectorAll('.category-button');
        const productCards = document.querySelectorAll('.product-card');
        const emptyState = document.getElementById('empty-state');
        const modal = document.getElementById('product-modal');
        const modalImage = document.getElementById('modal-image');
        const modalName = document.getElementById('modal-name');
        const modalCategory = document.getElementById('modal-category');
        const modalCloseButtons = document.querySelectorAll('.modal-close-button');

        function updateFilteredGrid(selectedCategory) {
            const visibleCards = [];

            productCards.forEach((card) => {
                const cardCategory = card.dataset.category;
                const isVisible = selectedCategory === 'Todos' || cardCategory === selectedCategory;
                card.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    visibleCards.push(card);
                }
            });

            emptyState.classList.toggle('hidden', visibleCards.length > 0);
        }

        function setActiveCategory(button) {
            categoryButtons.forEach((btn) => {
                btn.classList.remove('bg-zinc-900', 'text-white', 'shadow-md');
            });
            button.classList.add('bg-zinc-900', 'text-white', 'shadow-md');
        }

        function openModal(id) {
            const image = images.find((item) => item.id === Number(id));
            if (!image) {
                return;
            }

            modalImage.src = image.imageUrl;
            modalImage.alt = image.name;
            modalName.textContent = image.name;
            modalCategory.textContent = image.category;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        categoryButtons.forEach((button) => {
            button.addEventListener('click', () => {
                updateFilteredGrid(button.dataset.category);
                setActiveCategory(button);
            });
        });

        productCards.forEach((card) => {
            card.addEventListener('click', () => {
                openModal(card.dataset.id);
            });
        });

        modalCloseButtons.forEach((button) => {
            button.addEventListener('click', closeModal);
        });

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });
    </script>
@endcomponent
