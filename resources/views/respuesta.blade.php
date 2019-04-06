

@extends('layouts')
@section('contenido')
<div class="container mt-5" >
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Datos de la transacción</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Razon social</th>
                            <td>Prueba Comercio</td>
                        </tr>
                        <tr>
                            <th>NIT</th>
                            <td>12345-5</td>
                        </tr>
                        <tr>
                            <th>Fecha y Hora</th>
                            <td>{{$status['date']}}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>Transacción {{$status['status']}}</td>
                        </tr>
                        <tr>
                            <th>Motivo</th>
                            <td>{{$status['message']}}</td>
                        </tr>
                        <tr>
                            <th>Valor</th>
                        <td>{{$request['payment']['amount']['total']}} {{$request['payment']['amount']['currency']}}</td>
                        </tr>
                        <tr>
                            <th>Iva</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Franquicia</th>
                            <td>{{$payment[0]['franchise']}}</td>
                        </tr>
                        <tr>
                            <th>Banco</th>
                            <td>{{$payment[0]['issuerName']}}</td>
                        </tr>
                        <tr>
                            <th>Autorización</th>
                            <td>{{$payment[0]['authorization']}}</td>
                        </tr>
                        <tr>
                            <th>Recibo</th>
                            <td>{{$payment[0]['receipt']}}</td>
                        </tr>
                        <tr>
                            <th>Referencia</th>
                            <td>{{$payment[0]['reference']}}</td>
                        </tr>
                        <tr>
                            <th>Descripción</th>
                            <td>Transacción de prueba</td>
                        </tr>
                        <tr>
                            <th>DirecciónIp</th>
                            <td>@php
                              echo($_SERVER['REMOTE_ADDR']); 
                            @endphp</td>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <td>{{$request['payer']['name']}} {{$request['payer']['surname']}}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{$request['payer']['email']}}</td>
                        </tr>
                        <tr>
                            <th colspan="2"><p>Si tiene alguna inquietud contactenos al teléfono 12345 o vía email example@gmail.com</p></th>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-center">
                       
                        <div class="col-md-3"><a class="btn btn-primary" href="/">Volver al inicio</a> </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection