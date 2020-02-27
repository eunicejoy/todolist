@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="card text-left">
              <div class="card-header">
                  <h4>Add New Task</h4>
              </div>
              <div class="card-body">
                  @include('messages.errors')
                <form action="/task" method="post">
                    @csrf
                  <div class="form-group">
                    <label for="task">Task</label>
                    <input type="text" name="taskname" id="taskname" class="form-control">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Task</button>
                  </div>
                </form>
              </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card text-left">
                <div class="card-header">
                    <h4>Current Tasks</h4>
                </div>
                <div class="card-body">
                    @if ($tasks->count() > 0)
                    <table class="table table-striped task-table">
                        <thead>
                            <th>Task</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $task->name }}</div>
                                    </td>
                                    <td>
                                        <button type="button"
                                         class="btn btn-success"
                                         data-target="#editModal"
                                         data-toggle="modal"
                                         data-taskid= {{$task->id}}
                                         data-name="{{$task->name}}">Edit</button>
                                    </td>
                                    <td>
                                        <form action="/task/{{$task->id}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No task yet.</p>
                    @endif


                    <div>
                        {{ $tasks->links()}}
                    </div>

                </div>
              </div>
        </div>
    </div>
</div>

{{-- Modal --}}

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Task
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="/update" method="post">
                @method('PATCH')
                @csrf
            <div class="form-group">
                <input type="text" hidden id="taskid" name="taskid">
              <input type="text" class="form-control" id="task" name="task">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script type="application/javascript">
    $(document).ready(function(){
        $("#edit").click(function(){
            $("#editModal").modal();
        });

        $('#editModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var name = button.data('name');
            var id = button.data('taskid');
            var modal = $(this);

            modal.find('#task').val(name);
            modal.find('#taskid').val(id);
        });
    });

  </script>


@endsection

