@extends('admin_panel.adminLayout') @section('content')
<div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                    <a href="{{route('admin.categories')}}"> < Volver a la lista</a>
                    <br><br>
                      <h4 class="card-title">Eliminar categoría</h4>
                      <br>
                      <form class="forms-sample" method="post">
                      {{csrf_field()}}
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nombre de la Categoría</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" name="Name" value="{{$category->name}}" disabled>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1">Tipo de categoría</label>
                          <textarea type="textarea" class="form-control" name="Type" disabled>{{$category->type}}</textarea>
                        </div>
                        <input  type="submit" name="updateButton"  class="btn btn-danger mr-2" id="updateButton" value="ELIMINAR" />
                      </form>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
@endsection