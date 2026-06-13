@component('layouts.main-content', ['title' => 'Finalizar Encomenda'])

<main class="min-h-screen bg-background py-12">
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="mb-8 text-3xl font-bold tracking-tight text-zinc-900">Finalizar Encomenda (Checkout)</h1>

        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm font-medium text-red-800 border border-red-200">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.storeCheckout') }}" class="grid gap-8 lg:grid-cols-3">
            @csrf

            {{-- BLOCO ESQUERDO: DADOS DO FORMULÁRIO --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Secção 1: Dados de Envio e Faturação --}}
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm space-y-5">
                    <h2 class="text-xl font-bold text-zinc-900 border-b border-zinc-100 pb-3">Dados de Entrega & Faturação</h2>

                    {{-- Endereço de Entrega --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="address" class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Endereço de Entrega</label>
                        <input type="text" id="address" name="address" required
                            value="{{ old('address', auth()->user()->customer->address ?? '') }}"
                            placeholder="Rua, Número, Porta, Código Postal"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                    </div>

                    {{-- NIF --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="nif" class="text-xs font-bold text-zinc-700 uppercase tracking-wider">NIF (Número de Contribuinte)</label>
                        <input type="text" id="nif" name="nif" maxlength="9" pattern="[0-9]{9}"
                            value="{{ old('nif', auth()->user()->customer->nif ?? '') }}"
                            placeholder="Ex: 123456789 (Opcional)"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                    </div>

                    {{-- Notas Adicionais --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="notes" class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Notas / Observações da Encomenda</label>
                        <textarea id="notes" name="notes" rows="3"
                            placeholder="Indique informações extra relevantes para o estafeta ou para o processamento..."
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white">{{ old('notes') }}</textarea>
                    </div>
                </div>

                {{-- Secção 2: Dados de Pagamento Simulado --}}
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm space-y-5">
                    <h2 class="text-xl font-bold text-zinc-900 border-b border-zinc-100 pb-3">Método de Pagamento Simulado</h2>

                    {{-- Tipo de Pagamento --}}
                    <div class="grid gap-4 sm:grid-cols-3">
                        @php
                            $selectedPaymentType = old('payment_type', auth()->user()->customer->default_payment_type ?? 'VISA');
                        @endphp

                        <label class="relative flex items-center gap-3 p-4 border border-zinc-200 rounded-2xl cursor-pointer bg-zinc-50 hover:bg-zinc-100 transition">
                            <input type="radio" name="payment_type" value="Visa"
                                class="h-4 w-4 text-[#144226] focus:ring-[#144226]" {{ old('payment_type', auth()->user()->customer->default_payment_type) === 'Visa' ? 'checked' : '' }} required />
                            <div class="flex flex-col">
                                <span class="font-bold text-sm text-zinc-900">Visa</span>
                                <span class="text-[11px] text-zinc-500">Cartão Crédito</span>
                            </div>
                        </label>

                        <label class="relative flex items-center gap-3 p-4 border border-zinc-200 rounded-2xl cursor-pointer bg-zinc-50 hover:bg-zinc-100 transition">
                            <input type="radio" name="payment_type" value="MB WAY"
                                class="h-4 w-4 text-[#144226] focus:ring-[#144226]" {{ old('payment_type', auth()->user()->customer->default_payment_type) === 'MB WAY' ? 'checked' : '' }} />
                            <div class="flex flex-col">
                                <span class="font-bold text-sm text-zinc-900">MB WAY</span>
                                <span class="text-[11px] text-zinc-500">Conta Digital</span>
                            </div>
                        </label>

                        <label class="relative flex items-center gap-3 p-4 border border-zinc-200 rounded-2xl cursor-pointer bg-zinc-50 hover:bg-zinc-100 transition">
                            <input type="radio" name="payment_type" value="PayPal"
                                class="h-4 w-4 text-[#144226] focus:ring-[#144226]" {{ old('payment_type', auth()->user()->customer->default_payment_type) === 'PayPal' ? 'checked' : '' }} />
                            <div class="flex flex-col">
                                <span class="font-bold text-sm text-zinc-900">PayPal</span>
                                <span class="text-[11px] text-zinc-500">Conta Digital</span>
                            </div>
                        </label>
                    </div>

                    {{-- Referência do Pagamento --}}
                    <div class="flex flex-col gap-1.5">
                        <label for="payment_ref" class="text-xs font-bold text-zinc-700 uppercase tracking-wider">Referência / Dados de Pagamento</label>
                        <input type="text" id="payment_ref_input" name="payment_ref" required
                            value="{{ old('payment_ref', auth()->user()->customer->default_payment_ref) }}" 
                            placeholder="Visa (16 dg. começa por 4) | MB WAY (9 dg. começa por 9) | Email PayPal"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm text-zinc-900 outline-none transition focus:border-zinc-400 focus:bg-white" />
                        <p id="payment_help_text" class="text-[11px] text-zinc-400">
                            <b>Formatos aceites:</b> Visa (ex: 4123...), MB WAY (ex: 9123...) ou o e-mail da sua conta PayPal.
                        </p>
                    </div>
                </div>
            </div>

            {{-- BLOCO DIREITO: RESUMO DOS ARTIGOS E SUBMISSÃO --}}
            <div class="space-y-6">
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-zinc-900 border-b border-zinc-100 pb-2">Resumo dos Artigos</h3>

                    {{-- Lista dos Itens vindos diretos do Controller --}}
                    <div class="max-h-64 overflow-y-auto divide-y divide-zinc-100 pr-1">
                        @foreach($cartItems as $id => $item)
                            <div class="flex justify-between items-center py-3 text-sm">
                                <div class="overflow-hidden">
                                    <p class="font-semibold text-zinc-800 truncate max-w-40">{{ $item['name'] }}</p>
                                    <p class="text-xs text-zinc-400">Tam: {{ $item['size'] }} | Qtd: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="font-bold text-zinc-900">{{ number_format($item['sub_total'], 2) }}€</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totais Financeiros --}}
                    <div class="border-t border-zinc-100 pt-4 space-y-2 text-sm text-zinc-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium text-zinc-900">{{ number_format($grandTotal, 2) }}€</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Portes de Envio</span>
                            <span class="text-emerald-600 font-bold">Grátis</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-zinc-900 pt-3 border-t border-dashed border-zinc-200">
                            <span>Total a Debitar:</span>
                            <span class="text-xl font-extrabold text-[#144226]">{{ number_format($grandTotal, 2) }}€</span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-2xl bg-[#144226] px-5 py-4 text-sm font-bold text-white transition hover:bg-[#0e2f1b] shadow-sm mt-2">
                        Simular Pagamento e Encomendar
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.getElementById('payment_ref_input');
        const helpText = document.getElementById('payment_help_text');

        function updatePaymentUI(method) {
            if (method === 'VISA') {
                input.placeholder = "Ex: 4000 1234 5678 9010 (16 dígitos)";
                input.type = "text";
                helpText.innerText = "Insira o número do cartão (começando por 4).";
            } 
            else if (method === 'MB WAY') { 
                input.placeholder = "Ex: 910 000 000 (9 dígitos)";
                input.type = "tel";
                helpText.innerText = "Insira o número de telemóvel associado ao MB WAY.";
            } 
            else if (method === 'PAYPAL') {
                input.placeholder = "Ex: utilizador@email.com";
                input.type = "email";
                helpText.innerText = "Insira o e-mail da conta PayPal.";
            }
        }

        document.querySelectorAll('input[name="payment_type"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                updatePaymentUI(this.value);
            });
        });

        const activeRadio = document.querySelector('input[name="payment_type"]:checked');
        if (activeRadio) {
            updatePaymentUI(activeRadio.value);
        }
    });
</script>
@endcomponent