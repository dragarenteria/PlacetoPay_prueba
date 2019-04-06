@extends('layouts')
@section('contenido')
<div class="container mt-5" id="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    Finalizar compra
                </div>
                <div class="card-body">
                    <form class="row" @submit.prevent='enviar'>
                        <div class="col-md-12"><h4 class="text-center">Datos de la compra</h4></div>
                        <div class="form-group col-md-6">
                                <label for="descipcion">Descripcion de la compra</label>
                                <input type="text" required class="form-control" required v-model='persona.compra.descripcion'>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="total">Total</label>
                                <input type="number" required class="form-control" required v-model='persona.compra.total'>
                            </div>
                        <div class="col-md-12"><h4 class="text-center">Datos personales</h4></div>
                        <div class="form-group col-md-6">
                            <label for="tipo_doc">Tipo de documento</label>
                            <select class="form-control" name="tipo_doc" id="tipo_doc" required
                                v-model='persona.tipo_doc'>
                                <option value="PPN">Pasaporte</option>
                                <option value="TAX">TAX</option>
                                <option value="LIC">Labeler Identification Code</option>
                                <option value="CC">Cédula de ciudadanía</option>
                                <option value="CE">Cédula de extranjería</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="RC">Registro Civil</option>
                                <option value="NIT">Número de Identificación Tributaria</option>
                                <option value="RUT">Registro único tributario</option>
                                <option value="CI">Cédula de identidad</option>
                                <option value="RUC">Registro Único de Contribuyentes</option>
                                <option value="CIP">Cédula de identidad personal</option>
                                <option value="CPF">Cadastro de Pessoas Físicas</option>
                                <option value="SSN">Social security number</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="documento">Documento</label>
                            <input type="text" class="form-control" required v-model='persona.documento'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" required v-model='persona.nombres'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" required v-model='persona.apellidos'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Correo electronico</label>
                            <input type="email" class="form-control" required v-model='persona.email'>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" required v-model='persona.telefono'>
                        </div>
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <h4 class="text-center">Dirección de envío</h4>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="pais">Pais</label>
                                <select class="form-control" name="pais" required id="pais"
                                    v-model='persona.direccion.pais'>
                                    <option value="Colombia">Colombia</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ciudad">Ciudad</label>
                                <select class="form-control" name="ciudad" required id="ciudad"
                                    v-model='persona.direccion.ciudad'>
                                    <option value="Medellin">Medellin</option>
                                    <option value="Quibdo">Quibdo</option>
                                    <option value="Bogota">Bogotá</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" required v-model='persona.direccion.direccion'
                                    id="direccion">
                            </div>
                        </div>
                        <div class="form-group form-check col-md-12 ml-4" >
                            <input type="checkbox"  required class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Acepto</label>
                            <a href="#" data-toggle="modal" data-target="#exampleModalLong">Terminos y condiciones</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-danger btn-block"> Finalizar compra</button>

                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- moldal --}}
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle" >Terminos y condiciones</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                            <p>
                                    Cualquier persona que realice un compra en el sitio <a href="">http://placetopay.test/</a>, actuando libre
                                    y voluntariamente, autoriza a <a href="https://www.placetopay.com/web/home" target="_blank">https://www.placetopay.com/web/home</a>, a través del proveedor del servicio
                                    EGM Ingeniería Sin Fronteras S.A.S y/o Place to Pay para que consulte y solicite
                                    información del comportamiento crediticio, financiero, comercial y de servicios a
                                    terceros, incluso e
                            </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                  </div>
                </div>
              </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/pagos.js') }}"></script>

@endsection