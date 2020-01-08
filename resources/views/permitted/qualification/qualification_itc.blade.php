@extends('layouts.admin')

@section('contentheader_title')
  @if( auth()->user()->can('View Document P') )
     Evaluacion mensual ITC
  @else
    {{ trans('message.denied') }}
  @endif 
@endsection

@section('breadcrumb_title')
    @if( auth()->user()->can('View Document P') )
        Evaluacion mensual ITC
    @else
        {{ trans('message.denied') }}
    @endif 
@endsection

@section('content')
    
<div class="card">
    <div class="row">
        <div class="col-12 table-responsive">
            <table id="table-qualification" class="table">
                <thead>
                    <tr>
                        <th v-align="center" class="bg-secondary"> ITC</th>
                        <th class="bg-blue"> Reportes correctos (100% Entregados los primeros 5 dias del mes)</th>
                        <th class="bg-blue"> NPS: 80 o Mayor</th>
                        <th class="bg-blue"> Respuestas de encuesta  (90%-100%</th>
                        <th class="bg-blue"> Tickets de soporte SLA (95% - 100%)</th>
                        <!------>
                        <th class="bg-orange"> Imagen Profesional (Uso de Unifrome y llave)</th>
                        <!------>
                        <th class="bg-green"> Disponibilidad de sus sitios asignados 98%</th>
                        <th class="bg-green"> Mantener actualizado Inventario y Memoria Técnica</th>
                        <th class="bg-green"> Cumplir con el inventario de mantenimiento</th>
                        <!------>
                        <th class="bg-blue-dark"> Pedidos de material correcto</th>
                        <th class="bg-blue-dark"> Cobranza al corriente</th>
                        <th class="bg-blue-dark"> Información actualizada (Unidad de negocio)</th>
                        <!------>
                        <th> Crear 2 oportunidades comerciales al mes</th>
                        <th> Entrega de levantamientos en tiempo (72 hrs)</th>
                        <!------>
                        <th> Sugerir una idea o mejora al mes</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

  
@endsection

@push('scripts')
<style>
    #table-qualification th{
        font-size: .8rem;
        min-width: 170px;
    }

    .bg-blue{
        background-color: #192DA1;
        color: white;
    }

    .bg-blue-dark{
        background-color: #0C154A;
        color: white;
    }

    .bg-orange{
        background-color: #EE7100;
        color: white;
    }

    .bg-green{
        background-color: #34871B;
        color: white;
    }


</style>  

<script src="{{ asset('js/admin/qualification/qualification_itc.js') }}"></script>
 
@endpush
