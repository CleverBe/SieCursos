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
                    <select class="form-control" wire:model.defer='asignatura_id'{{ $selected_id > 0 ? 'disabled' : '' }}>
                        <option value="Elegir" disabled selected>Elegir</option>
                        @foreach ($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('asignatura_id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Aula" />
                    <x-select wire:model.defer='aula_id'>
                        <option class="form-control" value="Elegir" disabled selected>Elegir</option>
                        @foreach ($aulas as $aula)
                            <option value="{{ $aula->id }}">{{ $aula->codigo }}</option>
                        @endforeach
                    </x-select>
                    @error('aula_id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
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
                    <x-select wire:model.lazy='professor_id'>
                        <option value="Elegir" disabled selected>Elegir</option>
                        @foreach ($profesores as $profe)
                            <option value="{{ $profe->id }}">{{ $profe->nombre }}</option>
                        @endforeach
                    </x-select>
                    @error('professor_id')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <x-label texto="Periodo" />
                    <input class="form-control" type="month" wire:model.defer="periodo"
                        {{ $selected_id > 0 ? 'disabled' : '' }}>
                    @error('periodo')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <x-label texto="Hora inicio" />
                    <input class="form-control" type="time" wire:model.lazy="hora_inicio"
                        {{ $professor_id == 'Elegir' ? 'disabled' : '' }}>
                    @error('hora_inicio')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <x-label texto="Hora fin" />
                    <input class="form-control" type="time" wire:model.lazy="hora_fin"
                        {{ $professor_id == 'Elegir' ? 'disabled' : '' }}>
                    @error('hora_fin')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Fecha inicio" />
                    <x-input type="date" wire:model.lazy="fecha_inicio" />
                    @error('fecha_inicio')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Fecha fin" />
                    <x-input type="date" wire:model.lazy="fecha_fin" />
                    @error('fecha_fin')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <x-label texto="Dias" />
                    <div class="n-chk text-center">
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="lunes">
                            <span class="new-control-indicator"></span>Lunes
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="martes">
                            <span class="new-control-indicator"></span>Martes
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="miercoles">
                            <span class="new-control-indicator"></span>Miercoles
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="jueves">
                            <span class="new-control-indicator"></span>Jueves
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="viernes">
                            <span class="new-control-indicator"></span>Viernes
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="sabado">
                            <span class="new-control-indicator"></span>Sabado
                        </label>
                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-outline-primary">
                            <input @if (!$hora_inicio && !$hora_fin) disabled @endif type="checkbox"
                                class="new-control-input" wire:model.lazy="domingo">
                            <span class="new-control-indicator"></span>Domingo
                        </label>
                    </div>
                    @error('dias_seleccionado')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Costo de matrícula" />
                    <input class="form-control" type="number" wire:model.defer="costo_matricula"
                        {{ $selected_id > 0 ? 'disabled' : '' }}>
                    @error('costo_matricula')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Costo del curso" />
                    <input class="form-control" type="number" wire:model="costo_curso"
                        {{ $selected_id > 0 ? 'disabled' : '' }}>
                    @error('costo_curso')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Duración meses" />
                    <input class="form-control" type="number" wire:model="duracion_meses"
                        {{ $selected_id > 0 ? 'disabled' : '' }}>
                    @error('duracion_meses')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Cuota-mes" />
                    <h6 class="form-control" wire:model.defer="pago_cuota"><strong>{{ $pago_cuota }}</strong></h6>
                    @error('pago_cuota')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="form-group">
                    <x-label texto="Dia de cobro" />
                    <x-input type="number" wire:model.defer="dia_de_cobro" />
                    @error('dia_de_cobro')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <x-label texto="Hrs capacitación" />
                    <x-input type="number" wire:model.defer="horas_capacitacion" />
                    @error('horas_capacitacion')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                @error('profesor_libre')
                    <span class="text-danger er">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-12 col-md-6">
                @error('horario_libre')
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
        @endif
        <button class="btn" wire:click="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            CANCELAR</button>
    </x-slot>
</x-modal>
