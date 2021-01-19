@extends('admin_panel.adminLayout') @section('content')
<style>label.error {
  color: #a94442;
  background-color: #f2dede;
  border-color: #ebccd1;
  padding:1px 20px 1px 20px;
}</style>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('admin.products')}}">
                                < Volver a la lista</a>
                                    <br>
                                    <br>
                                    <h4 class="card-title">Editar producto</h4>
                                    <br>
                                    <img id="imageHolder" src="../../../uploads/products/{{$product->id}}/{{$product->image_name}}" alt="añadir imagen" height="300" width="300"/>
                                    <br>
                                     <input  type="file" name="inp_files" id="inp_files" multiple="múltiple" >
                                    <br>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        
                                       <input id="inp_img" name="img" type="hidden" value="">
                                        <div class="form-group">
                                            <label >nombre del producto</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="Nombre" value="{{$product->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Descripción del producto</label>
                                            <textarea type="textarea" class="form-control" name="Descripción">{{$product->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Gran selección</label>
                                            <select class="form-control form-control-md" id="exampleFormControlSelect1" name="Categoría">
                                                @php foreach($catlist->all() as $cat) { if($product->category->id==$cat->id) { $select_attribute='selected'; } echo "
                                                <option value=".$cat->id." " .$select_attribute.">".$cat->name." </option>"; $select_attribute=''; } @endphp
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label >Precio del producto</label>
                                            <input type="text" class="form-control" name="Precio" value="{{$product->price}}">
                                        </div>
                                        <div class="form-group">
                                            <label >Precio con descuento del producto</label>
                                            <input type="text" class="form-control"  name="Precio descontado" value="{{$product->discount}}">
                                        </div>
                                        
                                        <div class="form-group ">
                                            <label >Colores del producto</label>
                                            
                                            <input type="color" id="picker" class="form-control col-md-2">
                                            <br>
                                            <a onclick="addColor()" class="btn btn-sm btn-primary" >añadir</a>
                                            <br>
                                            <br>
                                            <div id="colors" style="border:1px solid #eee"> 
                                            </div>  
                                            <br>            
                                            <input type="text" class="form-control" id="color_list" name="Color" value="{{$product->colors}}" hidden>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label >Etiquetas de productos</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1" name="Etiquetas" value="{{$product->tag}}">
                                        </div>
                                        <input type="submit" name="saveButton" class="btn btn-success mr-2" id="updateButton" value="ACTUALIZAR" />
                                    </form>
                                    @if($errors->any())


                                    <ul>
                                        @foreach($errors->all() as $err)
                                        <tr>
                                            <td>
                                                <li>{{$err}}</li>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </ul>
                                    @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    
<script>
 
  function fileChange(e) {
 
     document.getElementById('inp_img').value = '';
 
     for (var i = 0; i < e.target.files.length; i++) { 
     
        var file = e.target.files[i];
 
        if (file.type == "image/jpeg" || file.type == "image/png") {
 
           var reader = new FileReader();  
           reader.onload = function(readerEvent) {
 
              var image = new Image();
              image.onload = function(imageEvent) { 
 
                 var max_size = 600;
                 var w = image.width;
                 var h = image.height;
                   
                 if (w > h) {  if (w > max_size) { h*=max_size/w; w=max_size; }
                 } else     {  if (h > max_size) { w*=max_size/h; h=max_size; } }
               
                 var canvas = document.createElement('canvas');
                 canvas.width = w;
                 canvas.height = h;
                 canvas.getContext('2d').drawImage(image, 0, 0, w, h);
                 if (file.type == "image/jpeg") {
                    var dataURL = canvas.toDataURL("image/jpeg", 1.0);
                 } else {
                    var dataURL = canvas.toDataURL("image/png");    
                 }
                 document.getElementById('inp_img').value += dataURL + '|';
              }
              image.src = readerEvent.target.result;
           }
           reader.readAsDataURL(file);
           
            readURL(this);

        } else {
           document.getElementById('inp_files').value = ''; 
           alert('Please only select images in JPG or PNG format.');   
           return false;
        }
     }
 
  }
 
  document.getElementById('inp_files').addEventListener('change', fileChange, false); 
         
</script>     
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imageHolder').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
   
$( document ).ready(function() {
    var addedColor = document.querySelector("#color_list").value;
    var arrayOfColor = addedColor.split(',');
    
    
    
    //console.log(addedColor);
    onReadyColorList(arrayOfColor);       
});
function onReadyColorList(arrayOfColor){
    var addedColor = document.querySelector("#color_list").value;
    var arrayOfColor = addedColor.split(',');
    for(var i =0 ; i< arrayOfColor.length; i++){
        newColor = `<div style="height:25px;display:inline-block;margin:5px;width:25px!important;background-color:${arrayOfColor[i]}"></div>`;
        document.querySelector("#colors").innerHTML += newColor;
    }
}
function addColor(){
    var pickedColor = document.querySelector("#picker").value;
    newColor = `<div style="height:25px;display:inline-block;margin:5px;width:25px!important;background-color:${pickedColor}"></div>`;
    var addedColor = document.querySelector("#color_list").value;
    //console.log(addedColor);
    if (addColor != null){  
        var arrayOfColor = addedColor.split(',');
        if(!arrayOfColor.includes(pickedColor)){
            arrayOfColor.push(pickedColor);
            document.querySelector("#color_list").value = arrayOfColor.join(',');
            document.querySelector("#colors").innerHTML += newColor;
        }
        
        console.log(addedColor);
       
        
    } 
}

</script>
    

@endsection
