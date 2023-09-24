@extends('layout')

@section('header')
    <script>
        $(document).ready(function(){
            $("#btnAdd").click(function(){
                if($("#txtName_0").val().trim() == "" ||
                        $("#txtDescription_0").val().trim() == "" ||
                        $("#txtPrix_0").val().trim() == "" ||
                        $("#txtStock_0").val().trim() == ""){
                    alert("Please enter the product information");
                    return;
                }

                $(this).attr('disabled', 'disabled');
                $.ajaxSetup({
                    headers:{'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
                });
                var data1 = new FormData();
                data1.append("image", document.getElementById("txtPhoto_0").files[0]);
                data1.append("name", $("#txtName_0").val());
                data1.append("description", $("#txtDescription_0").val());
                data1.append("price", $("#txtPrix_0").val());
                data1.append("stock", $("#txtStock_0").val());
                data1.append("category", $("#cmbCategorie_0").val());
                $.ajax({
                    url:"{{url('/admin/items/add')}}",
                    type:"post",
                    data: data1, /*{name: $("#txtName_0").val(), description: $("#txtDescription_0").val(),
                            price: $("#txtPrix_0").val(), stock:$("#txtStock_0").val(),
                            category: $("#cmbCategorie_0").val(),
                            image:document.getElementById("txtPhoto_0").files[0]},*/
                    contentType: false, //multipart/form-data
                    processData: false, //sans traitement des donnees (sans encoding)
                    success: function(output){
                        $('.alert').show();
                        $('.alert').html(output.success);
                        $("#tab_Item").append(output.row);
                        $("#btnAdd").removeAttr('disabled');
                        $("#txtName_0").val("");
                        $("#txtDescription_0").val("");
                        $("#txtPrix_0").val("");
                        $("#txtStock_0").val("");
                    }
                });
            });
        });

        function updateItem(id){
            $("#btnUpdate_"+id).attr('disabled', 'disabled');
        
            $.ajaxSetup({
                headers:{'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
            });
            var data1 = new FormData();
            if(document.getElementById("txtPhoto_"+id) != null)
                data1.append("image", document.getElementById("txtPhoto_"+id).files[0]);
            data1.append("name", $("#txtName_"+id).val());
            data1.append("description", $("#txtDescription_"+id).val());
            data1.append("price", $("#txtPrix_"+id).val());
            data1.append("stock", $("#txtStock_"+id).val());
            data1.append("category", $("#cmbCategorie_"+id).val());
            data1.append("id", id);
            $.ajax({
                url:"{{url('/admin/items/update')}}",
                type:"post",
                data: data1, /*{name: $("#txtName_0").val(), description: $("#txtDescription_0").val(),
                        price: $("#txtPrix_0").val(), stock:$("#txtStock_0").val(),
                        category: $("#cmbCategorie_0").val(),
                        image:document.getElementById("txtPhoto_0").files[0]},*/
                contentType: false, //multipart/form-data
                processData: false, //sans traitement des donnees (sans encoding)
                success: function(output){
                    $('.alert').show();
                    $('.alert').html(output.success);
                    $("#btnUpdate_"+id).removeAttr('disabled');
                    if(output.image == true){
                        var a = document.getElementById("txtPhoto_"+id).files[0].name.split('.');
                        var file_name = "http://127.0.0.1:8000/images/" + id + "." + a[a.length-1];
                        $("#img_"+id).attr('src', file_name);
                        $("#div_"+id).remove();
                    }
                }
            });
        }

        function deleteItem(id){
            $("#btnDelete_"+id).attr('disabled', 'disabled');
            $.ajax({
                url:"{{url('/admin/items/delete')}}",
                type:"get",
                data:{id: id},
                success: function(output){
                    $('.alert').show();
                    $('.alert').html(output.success);
                    $("#rowItem_"+id).fadeOut('slow');
                },
                error: function(ex, exception){
                    alert(ex.status);
                    alert(ex.responseText);
                }
            });
        }
    </script>
@endsection

@section('contenu')
    <h1>Articles</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table border="1">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix Unitaire</th>
                    <th>Stock</th>
                    <th>Photo</th>
                    <th>Categorie</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tab_Item">
            @foreach($articles as $a)
                    <tr id="rowItem_{{$a->id}}">
                        <td>
                            <div class="form-group">
                                <input id="txtName_{{$a->id}}" type="text" class="form-control" 
                                    name="txtName_{{$a->id}}" value="{{$a->nom_article}}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="txtDescription_{{$a->id}}" type="text" class="form-control" 
                                    name="txtDescription_{{$a->id}}" value="{{$a->description}}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="txtPrix_{{$a->id}}" type="number" class="form-control" 
                                    name="txtPrix_{{$a->id}}" value="{{$a->prix_unitaire}}">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input id="txtStock_{{$a->id}}" type="number" class="form-control" 
                                    name="txtStock_{{$a->id}}" value="{{$a->stock}}">
                            </div>
                        </td>
                        <td align="center">
                            @if($a->photo != null and file_exists(public_path()."/images/$a->photo"))
                                <img src="{{asset('/images/'.$a->photo)}}" alt="" width="100">
                            @else
                                <img src="" alt="" width="100" id="img_{{$a->id}}">
                                <div class="form-group" id="div_{{$a->id}}">
                                    <input id="txtPhoto_{{$a->id}}" type="file" class="form-control" 
                                        name="txtPhoto_{{$a->id}}" value="">
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="form-group">
                                <select name="cmbCategorie_{{$a->id}}" id="cmbCategorie_{{$a->id}}" class="form-control">
                                    @foreach($categories as $c)
                                        <option value="{{$c->id}}"
                                        @if($a->id_cat == $c->id)
                                            selected
                                        @endif 
                                        >{{$c->nom_cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" id="btnUpdate_{{$a->id}}"
                                onclick="updateItem({{$a->id}})">Update</button>
                            <button type="button" class="btn btn-primary" id="btnDelete_{{$a->id}}"
                                onclick="deleteItem({{$a->id}})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td colspan="7">New Item</td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <input id="txtName_0" type="text" class="form-control" 
                            name="txtName_0" value="">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="txtDescription_0" type="text" class="form-control" 
                            name="txtDescription_0" value="">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="txtPrix_0" type="number" class="form-control" 
                            name="txtPrix_0" value="">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="txtStock_0" type="number" class="form-control" 
                            name="txtStock_0" value="">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input id="txtPhoto_0" type="file" class="form-control" 
                            name="txtPhoto_0" value="">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <select name="cmbCategorie_0" id="cmbCategorie_0" class="form-control">
                            @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->nom_cat}}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary" id="btnAdd">Add</button>
                </td>
            </tr>
        </table>
    </form>
@endsection