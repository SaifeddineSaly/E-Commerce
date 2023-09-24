@extends('layout')

@section('header')
    <script>
        $(document).ready(function(){
            $("#btnAdd").click(function(){
                if($("#txtName_0").val().trim() == ""){
                    alert("Please enter a category name");
                    return;
                }

                $(this).attr('disabled', 'disabled');
                /*$.ajaxSetup({
                    headers:{'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}
                });*/

                $.ajax({
                    url:"{{url('/admin/categories/add')}}",
                    type:"get",
                    data:{name: $("#txtName_0").val()},
                    success: function(output){
                        $('.alert').show();
                        $('.alert').html(output.success);
                        $("#tbCategories").append(output.row);
                        $("#btnAdd").removeAttr('disabled');
                        $("#txtName_0").val("");
                    }
                });
            });
        });

        function updateCategory(id){
            $("#btnUpdate_"+id).attr('disabled', 'disabled');
            $.ajax({
                url:"{{url('/admin/categories/update')}}",
                type:"get",
                data:{id: id, name: $("#txtName_"+id).val()},
                success: function(output){
                    $('.alert').show();
                    $('.alert').html(output.success);
                    $("#btnUpdate_"+id).removeAttr('disabled');
                }
            });
        }

        function deleteCategory(id){
            $("#btnDelete_"+id).attr('disabled', 'disabled');
            $.ajax({
                url:"{{url('/admin/categories/delete')}}",
                type:"get",
                data:{id: id},
                success: function(output){
                    $('.alert').show();
                    $('.alert').html(output.success);
                    $("#rowCat_"+id).fadeOut('slow', function(){
                        $(this).remove();
                        return false;
                    });
                    //$("#btnDelete_"+id).removeAttr('disabled');
                }
            });
        }
    </script>
@endsection

@section('contenu')
    <h1>Categories</h1>
    <form action="" method="post">
        <table border="1" width="100%" bgcolor="#c0c0c0">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbCategories">
                @foreach($categories as $c)
                    <tr id="rowCat_{{$c->id}}">
                        <td>
                            <div class="form-group">
                                <input id="txtName_{{$c->id}}" type="text" class="form-control" 
                                    name="txtName_{{$c->id}}" value="{{$c->nom_cat}}">
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" id="btnUpdate_{{$c->id}}"
                                onclick="updateCategory({{$c->id}})">Update</button>
                            <button type="button" class="btn btn-primary" id="btnDelete_{{$c->id}}"
                                onclick="deleteCategory({{$c->id}})">Delete</button>
                        </td>
                    </tr>

                @endforeach
            </tbody>
            <tr>
                <td colspan="2">New Category</td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <input id="txtName_0" type="text" class="form-control" name="txtName_0" 
                            placeholder="Enter a category name" value="">
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary" id="btnAdd">Add</button>
                </td>
            </tr>
        </table>
    </form>
@endsection