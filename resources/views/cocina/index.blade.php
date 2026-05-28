@extends('layouts.pos')

@section('title', 'Cocina')
@section('view_title', '👨‍🍳 Monitor de Cocina')
@section('view_subtitle', 'Comandas en preparación en tiempo real')

@section('content')
<div class="h-full w-full p-6 overflow-x-auto flex gap-6 items-start sheet-layout bg-slate-100 text-slate-800">

    @foreach ($comandas as $comanda)
    <div class="w-85 shrink-0 flex flex-col rounded-2xl bg-white border border-slate-200 shadow-md overflow-hidden max-h-[calc(100vh-7rem)] transition-all duration-300"
         id="comanda-{{ $comanda->id }}">

        <div class="card-header p-4 flex justify-between items-start border-b border-slate-200 bg-slate-50">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Mesa</span>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-0.5">{{ $comanda->mesa->nombre }}</h3>
            </div>
            <div class="text-right">
                <span class="badge inline-block px-2.5 py-1 rounded-lg text-xs font-bold tracking-tight font-mono bg-amber-100 text-amber-800 border border-amber-200">
                    {{ $comanda->productos->where('pivot.estado', 'pendiente')->count() }} pendientes
                </span>
                <p class="text-[10px] text-slate-500 mt-1.5">
                    <i class="far fa-clock mr-1"></i>{{ $comanda->updated_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <div class="card-body p-4 flex-1 overflow-y-auto space-y-4 bg-white">
            <div class="row flex flex-col gap-4">

                <div class="col-md-6 space-y-2">
                    <h5 class="text-warning text-xs font-black uppercase tracking-wider text-amber-700 flex items-center gap-2 mb-2">
                        <i class="fas fa-clock text-xs"></i> Nuevos para preparar
                        <span class="badge bg-warning text-dark ml-auto bg-amber-100 text-amber-800 px-2 py-0.5 rounded-md font-mono text-xs font-bold border border-amber-200">
                            {{ $comanda->productos->where('pivot.estado', 'pendiente')->count() }}
                        </span>
                    </h5>

                    @forelse ($comanda->productos->where('pivot.estado', 'pendiente') as $producto)
                    <div class="alert alert-warning producto-item p-3.5 rounded-xl bg-amber-50/60 border border-amber-200/80 hover:border-amber-300 transition-all text-slate-900"
                         id="producto-{{ $comanda->id }}-{{ $producto->id }}">
                        <div class="row align-items-start flex items-center gap-4">

                            <div class="col pt-1 shrink-0 flex items-center justify-center">
                                <label class="relative flex items-center justify-center h-8 w-8 rounded-xl bg-white border-2 border-slate-300 hover:border-emerald-500 cursor-pointer transition-all active:scale-90 shadow-sm">
                                    <input type="checkbox"
                                           class="form-check-input producto-check sr-only"
                                           data-comanda="{{ $comanda->id }}"
                                           data-producto="{{ $producto->id }}"
                                           autocomplete="off">
                                    <i class="fas fa-check text-emerald-600 opacity-0 transition-opacity text-xs check-icon"></i>
                                </label>
                            </div>

                            <div class="row align-items-start d-flex flex-col min-w-0 flex-1">
                                <span class="text-[15px] tracking-tight text-slate-800">
                                    <strong class="font-mono font-black text-slate-900 text-base mr-1">{{ $producto->pivot->cantidad }}x</strong>
                                    {{ $producto->nombre }}
                                </span>
                                @if($producto->pivot->comentarios)
                                <small class="text-muted mt-1 text-xs font-bold text-rose-700 bg-rose-50 border border-rose-200 rounded px-1.5 py-0.5 inline-block w-fit">
                                    <em>⚠️ {{ $producto->pivot->comentarios }}</em>
                                </small>
                                @endif
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="alert alert-light text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-slate-500 text-xs font-medium">
                        <i class="fas fa-check-circle text-success text-emerald-600 mr-1.5"></i> Todos los productos preparados
                    </div>
                    @endforelse
                </div>

                <div class="col-md-6 space-y-2 pt-2 border-t border-slate-100">
                    <h5 class="text-success text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2 mb-2">
                        <i class="fas fa-check-circle text-emerald-600"></i> Listos para entregar
                        <span class="badge bg-success text-white ml-auto bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md font-mono text-xs font-bold border border-slate-200">
                            {{ $comanda->productos->where('pivot.estado', 'preparado')->count() }}
                        </span>
                    </h5>

                    @forelse ($comanda->productos->where('pivot.estado', 'preparado') as $producto)
                    <div class="alert alert-success mb-2 p-3 rounded-xl bg-slate-50 border border-slate-200/60 opacity-60 text-slate-500 strike-through">
                        <div class="d-flex justify-content-between flex justify-between items-center">
                            <div class="truncate pr-2">
                                <span class="font-mono font-bold text-slate-400 text-sm mr-1">{{ $producto->pivot->cantidad }}x</span>
                                <strong class="font-medium text-sm line-through">{{ $producto->nombre }}</strong>
                                @if($producto->pivot->comentarios)
                                <br><small class="text-[11px] text-slate-400 italic"><em>{{ $producto->pivot->comentarios }}</em></small>
                                @endif
                            </div>
                            <span class="text-success text-emerald-600 shrink-0">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-light text-center py-3 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs font-medium">
                        <i class="fas fa-clock text-amber-500 mr-1.5"></i> Esperando productos
                    </div>
                    @endforelse
                </div>

            </div>

            @if($comanda->productos->where('pivot.estado', 'pendiente')->count() == 0)
            <div class="mt-4 pt-2 border-t border-slate-200">
                <h5 class="text-center text-success mb-3 text-emerald-600 flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider">
                    <i class="fas fa-check-double"></i> ¡Comanda completa!
                </h5>
                <form method="POST" action="{{ route('comandas.cambiarEstado', $comanda->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="estado" value="lista">
                    <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black py-3.5 rounded-xl text-center text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20">
                        <i class="fas fa-paper-plane text-xs"></i> MARCAR COMO LISTA
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
    @endforeach

</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.producto-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const comandaId = this.dataset.comanda;
            const productoId = this.dataset.producto;
            const productoItem = document.getElementById(`producto-${comandaId}-${productoId}`);

            if (this.checked) {
                this.disabled = true;

                // Feedback visual adaptado al tema claro
                productoItem.classList.add('processing');
                const labelIcon = this.parentElement.querySelector('.check-icon');
                if (labelIcon) labelIcon.classList.remove('opacity-0');

                fetch(`/comandas/${comandaId}/producto/${productoId}/estado`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            estado: 'preparado'
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta');
                        return response.json();
                    })
                    .then(data => {
                        const comandaCard = document.getElementById(`comanda-${comandaId}`);
                        const preparadosSection = comandaCard.querySelector('.col-md-6:last-child');
                        const pendientesSection = comandaCard.querySelector('.col-md-6:first-child');

                        const emptyPrepAlert = preparadosSection.querySelector('.alert-light');
                        if (emptyPrepAlert && emptyPrepAlert.innerText.includes('Esperando')) {
                            emptyPrepAlert.remove();
                        }

                        const cantidadText = productoItem.querySelector('.font-mono').innerText;
                        const nombreText = productoItem.querySelector('span').innerText.replace(cantidadText, '').trim();
                        const comentarioElement = productoItem.querySelector('small');

                        // Elemento preparado en paleta clara de alto contraste con opacidad
                        const preparadoDiv = document.createElement('div');
                        preparadoDiv.className = 'alert alert-success mb-2 p-3 rounded-xl bg-slate-50 border border-slate-200/60 opacity-60 text-slate-500';
                        preparadoDiv.innerHTML = `
                        <div class="d-flex justify-content-between flex justify-between items-center">
                            <div>
                                <span class="font-mono font-bold text-slate-400 text-sm mr-1">${cantidadText}</span>
                                <strong class="font-medium text-sm line-through">${nombreText}</strong><br>
                                ${comentarioElement ? comentarioElement.outerHTML : ''}
                            </div>
                            <span class="text-success text-emerald-600 shrink-0">
                                <i class="fas fa-check text-xs"></i>
                            </span>
                        </div>
                    `;

                        preparadosSection.querySelector('h5').insertAdjacentElement('afterend', preparadoDiv);
                        productoItem.remove();

                        const pendientesCount = pendientesSection.querySelectorAll('.producto-item').length;
                        const preparadosCount = preparadosSection.querySelectorAll('.alert-success').length;

                        pendientesSection.querySelector('h5 .badge').textContent = pendientesCount;
                        preparadosSection.querySelector('h5 .badge').textContent = preparadosCount;

                        if (pendientesCount === 0) {
                            const emptyPendAlert = pendientesSection.querySelector('.alert-light');
                            if (!emptyPendAlert) {
                                pendientesSection.innerHTML += `
                                    <div class="alert alert-light text-center py-4 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-slate-500 text-xs font-medium">
                                        <i class="fas fa-check-circle text-success text-emerald-600 mr-1.5"></i> Todos los productos preparados
                                    </div>
                                `;
                            }

                            const completeDiv = document.createElement('div');
                            completeDiv.className = 'mt-4 pt-2 border-t border-slate-200';
                            completeDiv.innerHTML = `
                            <h5 class="text-center text-success mb-3 text-emerald-600 flex items-center justify-center gap-2 text-xs font-black uppercase tracking-wider">
                                <i class="fas fa-check-double"></i> ¡Comanda completa!
                            </h5>
                            <form method="POST" action="/comandas/${comandaId}/estado">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="estado" value="lista">
                                <button class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] transition-all text-white font-black py-3.5 rounded-xl text-center text-sm tracking-wide cursor-pointer flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/20">
                                    <i class="fas fa-paper-plane text-xs"></i> MARCAR COMO LISTA
                                </button>
                            </form>
                        `;
                            comandaCard.querySelector('.card-body').appendChild(completeDiv);

                            const headerBadge = comandaCard.querySelector('.card-header .badge');
                            headerBadge.className = 'badge inline-block px-2.5 py-1 rounded-lg text-xs font-bold tracking-tight font-mono bg-emerald-100 text-emerald-800 border border-emerald-200';
                            headerBadge.textContent = 'Lista para entregar';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = false;
                        this.disabled = false;
                        productoItem.classList.remove('processing');
                        if (labelIcon) labelIcon.add('opacity-0');
                        alert('Ocurrió un error al actualizar el estado');
                    });
            }
        });
    });
</script>

<style>
    .processing {
        opacity: 0.5;
        filter: grayscale(0.5);
        background-color: #f1f5f9 !important;
        pointer-events: none;
    }
</style>
@endsection
