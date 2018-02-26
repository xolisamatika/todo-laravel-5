<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSFR token for ajax call -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>My Todo</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <style>

    </style>

</head>

<body>
    <div class="container">
    
        <h1>Todo App</h1>
        <div class="form-inline well">
                <div class="form-group">
                    <label for="newTodo">Title:</label>
                    <input type="text" name="newTodo" id="title-new-todo"   class="form-control" required>
                </div>
                
                    <a class="btn btn-success add">
                        <span class="glyphicon glyphicon-plus"></span>
                        Save
                </a>
        </div>

        <br>
        <table class="table table-striped table-bordered" id="todos-table">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Complete?</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($todos as $todo)
                @if ($todo->is_complete)
                    <tr scope="row" id="row-todo{{$todo->id}}" class="success">
                @else
                    <tr scope="row" id="row-todo{{$todo->id}}">
                @endif 

                    <td>
                        <p contenteditable="false" name="todo{{$todo->id}}" id="title-todo{{$todo->id}}"> {{$todo->title}} </p>
                    </td>
                    <td>
                        <input type="checkbox" name="completed" class="completed" id="completed-todo{{$todo->id}}" data-id="{{$todo->id}}" @if ($todo->is_complete) checked @endif>
                    </td>
                    <td>
                        <a id="edit-todo{{$todo->id}}" class="btn btn-primary edit" data-id="{{$todo->id}}">
                            <span class="glyphicon glyphicon-pencil"></span>
                            Edit
                        </a>
                        <a id="update-todo{{$todo->id}}" class="btn btn-primary update" data-id="{{$todo->id}}">
                            <span class="glyphicon glyphicon-floppy-save"></span>
                            Save
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger delete" data-id="{{$todo->id}}">
                            <span class="glyphicon glyphicon-trash"></span>
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
</div>


 <script>
        $(document).ready(function(){

            $('.update').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.completed').click(function() {
                id = $(this).data('id');
                if ($(this).is(':checked')) {
                    $(this).attr('value', '1');
                } else {
                    $(this).attr('value', '0');
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ URL::route('changeStatus') }}",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        if(data.todo.is_complete) {
                            $('#row-todo' + id).addClass("success");
                        } else {
                            $('#row-todo' + id).removeClass("success");
                        }
                    },
                });
            });

            $('.edit').click(function() {
                id = $(this).data('id');
                $('#title-todo' + id).attr('contenteditable', true);
                $(this).hide();
                $('#update-todo' + id).show();
            });

            $('#add-new').click(function() {
                $(this).hide();
                $('#todos-table').append(newRow);
            });

            $('.add').click(function() {
                
                var completed = $('#completed-new-todo').val() === "on" ? 1 : 0;
                $.ajax({
                    type: 'POST',
                    url: 'todos',
                    data: {
                        'title': $('#title-new-todo').val()
                    },
                    success: function(data) {
                    $('.errorTitle').addClass('hidden');
                    $('.errorContent').addClass('hidden');

                    if ((data.errors)) {
                        if (data.errors.title) {
                            $('.errorTitle').removeClass('hidden');
                            $('.errorTitle').text(data.errors.title);
                        }
                    } else {
                        var todo = data.todo;
                        var newRow = "<tr scope='row' id='row-todo" + todo.id + "'>"
                                +"<td>"
                                +"<p contenteditable='false' name='todo" + todo.id +"' id='title-todo" + todo.id +"' data-id='" + todo.id +"'>" + todo.title +"</p>"
                                +"</td>"
                                +"<td>"
                                +"<input type='checkbox' name='completed' class='completed' id='completed-todo" + todo.id 
                                +"' data-id='" + todo.id +"' " + (todo.is_complete ? "checked" : "") +" >"
                                +"</td>"
                                +"<td>"
                                +"<a id='edit-todo" + todo.id +"' class='btn btn-primary edit' data-id='" + todo.id +"'>"
                                +"<span class='glyphicon glyphicon-pencil'></span>"
                                +"Edit"
                                +"</a>"
                                +"<a id='update-todo" + todo.id +"'  class='btn btn-primary update' data-id='" + todo.id +"'>"
                                +"<span class='glyphicon glyphicon-pencil'></span>"
                                +"Save"
                                +"</a>"
                                +"</td>"
                                +"<td>"
                                +"<a id='delete-todo" + todo.id +"' class='btn btn-danger delete' data-id='" + todo.id +"'>"
                                +"<span class='glyphicon glyphicon-trash'></span>"
                                +"Delete"
                                +"</a>"
                                +"</td>"
                                +"</tr>";
                            
                        $('#todos-table').append(newRow);
                        $('#title-new-todo').val('');
                        $('#update-todo' + todo.id).hide();
                        $('#edit-todo' + todo.id).click(function() {
                            id = $(this).data('id');
                            $('#title-todo' + id).attr('contenteditable', true);
                            $(this).hide();
                            $('#update-todo' + id).show();
                        });

                        $('#update-todo' + todo.id).click(function() {
                            id = $(this).data('id');
                            $(this).hide();
                            $('#edit-todo' + id).show();
                            var completed = $('#completed-todo'+ id).val() === "on" ? 1 : 0;

                            $.ajax({
                                type: 'PATCH',
                                url: 'todos/' + id,
                                data: {
                                    'title': $('#title-todo'+ id).text(),
                                    'is_complete': completed
                                },
                                success: function(data) {
                                    $('#title-todo' + id).attr('contenteditable', false);
                                    if(data.todo.is_complete) {
                                        $('#row-todo' + id).addClass("success");
                                    } else {
                                        $('#row-todo' + id).removeClass("success");
                                    }
                                }
                            });
                        });
                        $('#delete-todo' + todo.id).click(function() {
                            id = $(this).data('id');
                            $.ajax({
                                type: 'DELETE',
                                url: 'todos/' + id,
                                success: function(data) {
                                    $('#row-todo' + id).remove();
                                }
                            });
                        });

                        $('.completed').click(function() {
                            id = $(this).data('id');
                            if ($(this).is(':checked')) {
                                $(this).attr('value', '1');
                            } else {
                                $(this).attr('value', '0');
                            }
                            $.ajax({
                                type: 'POST',
                                url: "{{ URL::route('changeStatus') }}",
                                data: {
                                    'id': id
                                },
                                success: function(data) {
                                    if(data.todo.is_complete) {
                                        $('#row-todo' + id).addClass("success");
                                    } else {
                                        $('#row-todo' + id).removeClass("success");
                                    }
                                },
                        });
            });
                    }
                }
                });
                
            });

            $('.update').click(function() {
                id = $(this).data('id');
                $(this).hide();
                $('#edit-todo' + id).show();
                var completed = $('#completed-todo'+ id).val() === "on" ? 1 : 0;

                $.ajax({
                    type: 'PATCH',
                    url: 'todos/' + id,
                    data: {
                        'title': $('#title-todo'+ id).text(),
                        'is_complete': completed
                    },
                    success: function(data) {
                        $('#title-todo' + id).attr('contenteditable', false);
                        if(data.todo.is_complete) {
                            $('#row-todo' + id).addClass("success");
                        } else {
                            $('#row-todo' + id).removeClass("success");
                        }
                    }
                });
            });

            $('.delete').click(function() {
                id = $(this).data('id');
                $.ajax({
                    type: 'DELETE',
                    url: 'todos/' + id,
                    success: function(data) {
                        $('#row-todo' + id).remove();
                    }
                });
            });
        });

    </script>
</body>
</html>