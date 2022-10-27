<x-modal id="theModal">
    <x-slot name="head">
        <h5 class="modal-title text-white">
            <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Curso" />
                    <x-select wire:model.defer='asignatura'>
                        <option value="Elegir" disabled selected>Elegir</option>
                        @foreach ($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }} -
                                {{ $asignatura->duracion }} meses
                            </option>
                        @endforeach
                    </x-select>
                    @error('asignatura')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Aula" />
                    <x-select wire:model.defer='aula'>
                        <option value="Elegir" disabled selected>Elegir</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->codigo }}</option>
                        @endforeach
                    </x-select>
                    @error('aula')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Modalidad" />
                    <x-select wire:model.defer='modalidad'>
                        <option value="PRESENCIAL">PRESENCIAL</option>
                        <option value="VIRTUAL">VIRTUAL</option>
                    </x-select>
                    @error('modalidad')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Profesor" />
                    <x-select wire:model.lazy='profesor'>
                        <option value="Elegir" disabled selected>Elegir</option>
                        @foreach ($profesores as $profe)
                            <option value="{{ $profe->id }}">{{ $profe->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('profesor')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            @if ($profesor != 'Elegir')
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Hora inicio" />
                        <x-input type="time" wire:model.lazy="hora_inicio" />
                        @error('hora_inicio')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Hora fin" />
                        <x-input type="time" wire:model.lazy="hora_fin" />
                        @error('hora_fin')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Fecha inicio" />
                        <x-input type="date" wire:model.lazy="fecha_inicio" />
                        @error('fecha_inicio')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Fecha fin" />
                        <x-input type="date" wire:model.lazy="fecha_fin" />
                        @error('fecha_fin')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Periodo" />
                        <x-input type="month" wire:model.defer="periodo" />
                        @error('periodo')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Dia de cobro" />
                        <x-input type="number" wire:model.defer="dia_de_cobro" />
                        @error('dia_de_cobro')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif
            @if ($hora_inicio && $hora_fin)
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <x-label texto="Dias" />
                        <div class="n-chk">
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="lunes">
                                <span class="new-control-indicator"></span>Lu
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="martes">
                                <span class="new-control-indicator"></span>Ma
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="miercoles">
                                <span class="new-control-indicator"></span>Mi
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="jueves">
                                <span class="new-control-indicator"></span>Ju
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="viernes">
                                <span class="new-control-indicator"></span>Vi
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="sabado">
                                <span class="new-control-indicator"></span>Sa
                            </label>
                            <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                                <input @if ($profesor == 'Elegir') disabled @endif type="checkbox"
                                    class="new-control-input" wire:model.lazy="domingo">
                                <span class="new-control-indicator"></span>Do
                            </label>
                            @error('dias')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <x-label texto="Estado" />
                    <x-select wire:model.defer='estado'>
                        <option value="VIGENTE">VIGENTE</option>
                        <option value="PROXIMO">PROXIMO</option>
                    </x-select>
                    @error('estado')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                @error('resultado')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-12 col-md-6">
                @error('respuesta')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        @if ($selected_id < 1)
            <x-button wire:click.prevent="Store()" wire:loading.attr="disabled" wire:target="Store"
                texto="GUARDAR" />
        @else
            <x-button wire:click.prevent="Update()" wire:loading.attr="disabled" wire:target="Update"
                texto="ACTUALIZAR" />
            <x-button onclick="ConfirmFinalizarCurso()" color="danger" texto="FINALIZAR CURSO" />
        @endif
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
