@component('layouts.main-content', ['type' => 'Persona'])
    @php
        $tshirtColors = [
            ['value' => 'branco', 'label' => 'Branco', 'hex' => '#ffffff'],
            ['value' => 'preto', 'label' => 'Preto', 'hex' => '#111827'],
            ['value' => 'vermelho', 'label' => 'Vermelho', 'hex' => '#ef4444'],
            ['value' => 'azul', 'label' => 'Azul', 'hex' => '#3b82f6'],
            ['value' => 'verde', 'label' => 'Verde', 'hex' => '#22c55e'],
        ];

        $tshirtSizes = [
            ['value' => 'S', 'label' => 'S'],
            ['value' => 'M', 'label' => 'M'],
            ['value' => 'L', 'label' => 'L'],
            ['value' => 'XL', 'label' => 'XL'],
        ];
    @endphp

    <main class="min-h-screen bg-background">
        <div class="container mx-auto px-4 py-12">
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-3xl font-bold text-foreground">Cria a Tua T-Shirt</h1>
                <p class="text-muted-foreground">Carrega a tua imagem e personaliza a tua t-shirt única</p>
            </div>

            <div class="mx-auto grid max-w-5xl gap-8 lg:grid-cols-2">
                <div class="space-y-6">
                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="p-6">
                            <h2 class="mb-4 text-lg font-semibold">Carrega a tua imagem</h2>
                            <div
                                id="upload-dropzone"
                                class="flex min-h-75 cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-dashed border-border bg-muted transition-colors duration-200 hover:border-primary/50 hover:bg-muted/70"
                            >
                                <svg class="mb-4 h-12 w-12 text-muted-foreground" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 3v10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8 7l4-4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 21H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mb-2 text-center font-medium text-foreground">Arrasta e larga a tua imagem aqui</p>
                                <p class="mb-4 text-center text-sm text-muted-foreground">ou clica para selecionar</p>
                                <button id="upload-button" type="button" class="inline-flex items-center gap-2 rounded-lg border border-border px-4 py-2 text-sm font-semibold text-foreground transition hover:border-primary/70">
                                    Escolher ficheiro
                                </button>
                            </div>
                            <input id="upload-input" type="file" accept="image/*" class="hidden" />
                            <div id="upload-preview" class="relative mt-6 hidden">
                                <div class="relative aspect-square overflow-hidden rounded-3xl bg-zinc-100">
                                    <img id="preview-image" src="" alt="Imagem carregada" class="hidden object-contain w-full h-full" />
                                    <div id="preview-placeholder" class="flex h-full items-center justify-center rounded-3xl border-2 border-dashed border-black/20">
                                        <p class="text-center text-sm text-black/40">A tua imagem aparece aqui</p>
                                    </div>
                                </div>
                                <button id="remove-image" type="button" class="absolute right-3 top-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-zinc-700 shadow hover:bg-zinc-100">
                                    ×
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="p-6">
                            <h2 class="mb-4 text-lg font-semibold">Pré-visualização</h2>
                            <div id="preview-block" class="relative mx-auto aspect-square max-w-75 rounded-3xl bg-white">
                                <div class="absolute inset-0 flex items-center justify-center p-8">
                                    <div class="relative h-full w-3/4">
                                        <img id="preview-image-panel" src="" alt="Preview" class="hidden object-contain w-full h-full" />
                                        <div id="preview-empty" class="flex h-full items-center justify-center rounded-3xl border-2 border-dashed border-black/20">
                                            <p class="text-center text-sm text-black/40">A tua imagem aparece aqui</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-zinc-200 bg-white shadow-sm">
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-zinc-900">Cor da T-Shirt</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($tshirtColors as $color)
                                        <button
                                            type="button"
                                            class="color-option h-10 w-10 rounded-full border-2 border-border transition-all duration-200"
                                            data-value="{{ $color['value'] }}"
                                            data-hex="{{ $color['hex'] }}"
                                            title="{{ $color['label'] }}"
                                            style="background-color: {{ $color['hex'] }}"
                                        ></button>
                                    @endforeach
                                </div>
                                <p id="selected-color-label" class="mt-2 text-sm text-muted-foreground">Branco</p>
                            </div>

                            <div>
                                <label for="size-select" class="mb-2 block text-sm font-medium text-zinc-900">Tamanho</label>
                                <select id="size-select" class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    @foreach ($tshirtSizes as $size)
                                        <option value="{{ $size['value'] }}">{{ $size['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="quantity-input" class="mb-2 block text-sm font-medium text-zinc-900">Quantidade</label>
                                <input id="quantity-input" type="number" min="1" value="1" class="w-24 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20" />
                                <p id="discount-label" class="mt-2 hidden text-sm text-primary">Desconto de quantidade aplicado!</p>
                            </div>

                            <div class="rounded-3xl bg-muted p-4">
                                <div class="flex items-center justify-between text-sm text-zinc-600">
                                    <span>Preço unitário:</span>
                                    <span id="unit-price" class="font-medium">25.00€</span>
                                </div>
                                <div id="unit-price-original" class="mt-2 hidden text-sm text-muted-foreground line-through">25.00€</div>
                                <div class="mt-3 flex items-center justify-between border-t border-zinc-200 pt-3">
                                    <span class="font-medium">Total:</span>
                                    <span id="total-price" class="text-xl font-bold text-primary">25.00€</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button id="add-to-cart-btn" type="button" class="inline-flex w-full justify-center rounded-2xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-50" disabled>
                                    Adicionar ao Carrinho
                                </button>
                                <p id="added-message" class="hidden text-center text-sm font-medium text-emerald-600">Adicionado ao carrinho!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const tshirtColors = @json($tshirtColors);
        const defaultColor = tshirtColors[0];
        const colorButtons = document.querySelectorAll('.color-option');
        const sizeSelect = document.getElementById('size-select');
        const quantityInput = document.getElementById('quantity-input');
        const uploadDropzone = document.getElementById('upload-dropzone');
        const uploadButton = document.getElementById('upload-button');
        const uploadInput = document.getElementById('upload-input');
        const uploadPreview = document.getElementById('upload-preview');
        const previewBlock = document.getElementById('preview-block');
        const previewImage = document.getElementById('preview-image-panel');
        const previewPlaceholder = document.getElementById('preview-empty');
        const selectedColorLabel = document.getElementById('selected-color-label');
        const discountLabel = document.getElementById('discount-label');
        const unitPriceEl = document.getElementById('unit-price');
        const totalPriceEl = document.getElementById('total-price');
        const unitPriceOriginal = document.getElementById('unit-price-original');
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        const addedMessage = document.getElementById('added-message');

        let selectedColor = defaultColor.value;
        let quantity = 1;
        let uploadedImage = null;

        function formatPrice(value) {
            return value.toFixed(2) + '€';
        }

        function calculatePrice(quantity) {
            const basePrice = 25;
            if (quantity >= 5) {
                return 20;
            }
            return basePrice;
        }

        function updatePrice() {
            const unitPrice = calculatePrice(quantity);
            const totalPrice = unitPrice * quantity;
            unitPriceEl.textContent = formatPrice(unitPrice);
            totalPriceEl.textContent = formatPrice(totalPrice);
            if (quantity >= 5) {
                discountLabel.classList.remove('hidden');
                unitPriceOriginal.classList.remove('hidden');
            } else {
                discountLabel.classList.add('hidden');
                unitPriceOriginal.classList.add('hidden');
            }
        }

        function setActiveColor(button) {
            colorButtons.forEach((btn) => {
                btn.classList.remove('border-primary', 'ring-2', 'ring-primary', 'ring-offset-2');
            });
            button.classList.add('border-primary', 'ring-2', 'ring-primary', 'ring-offset-2');

            selectedColor = button.dataset.value;
            const hex = button.dataset.hex;
            previewBlock.style.backgroundColor = hex;
            selectedColorLabel.textContent = button.title;
        }

        function setUploadedImage(imageUrl) {
            uploadedImage = imageUrl;
            previewImage.src = imageUrl;
            previewImage.classList.remove('hidden');
            previewPlaceholder.classList.add('hidden');
            uploadPreview.classList.remove('hidden');
            addToCartBtn.disabled = false;
        }

        function clearImage() {
            uploadedImage = null;
            previewImage.src = '';
            previewImage.classList.add('hidden');
            previewPlaceholder.classList.remove('hidden');
            uploadPreview.classList.add('hidden');
            addToCartBtn.disabled = true;
        }

        function handleFile(file) {
            if (!file || !file.type.startsWith('image/')) {
                return;
            }
            const reader = new FileReader();
            reader.onload = (event) => {
                setUploadedImage(event.target.result);
            };
            reader.readAsDataURL(file);
        }

        uploadDropzone.addEventListener('click', () => uploadInput.click());
        uploadButton.addEventListener('click', () => uploadInput.click());

        uploadInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            handleFile(file);
        });

        uploadDropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            uploadDropzone.classList.add('border-primary', 'bg-primary/5');
        });

        uploadDropzone.addEventListener('dragleave', () => {
            uploadDropzone.classList.remove('border-primary', 'bg-primary/5');
        });

        uploadDropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            uploadDropzone.classList.remove('border-primary', 'bg-primary/5');
            const file = event.dataTransfer.files[0];
            handleFile(file);
        });

        document.getElementById('remove-image').addEventListener('click', () => {
            uploadInput.value = '';
            clearImage();
        });

        colorButtons.forEach((button, index) => {
            button.addEventListener('click', () => setActiveColor(button));
            if (index === 0) {
                setActiveColor(button);
            }
        });

        quantityInput.addEventListener('input', (event) => {
            const value = parseInt(event.target.value, 10) || 1;
            quantity = Math.max(1, value);
            event.target.value = quantity;
            updatePrice();
        });

        addToCartBtn.addEventListener('click', () => {
            if (!uploadedImage) {
                return;
            }
            addedMessage.classList.remove('hidden');
            setTimeout(() => addedMessage.classList.add('hidden'), 2000);
        });

        updatePrice();
    </script>
@endcomponent
