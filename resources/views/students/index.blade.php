@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Students<a style="float:right;color:red;"
                                                             href="{{ route('students.create') }}">Add Student</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            @if(Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                    @php
                                        Session::forget('success');
                                    @endphp
                                </div>
                            @endif
                        <table class="table table-bordered data-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="100px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('students.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

        });

        $(document).ready(function() {
            $(document).on('click','.toggle_status', function(){
                var studentId = $(this).data('id');
                var $this = $(this);
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    url : "{{ route('students.status.update') }}",
                    data : {'token' : token, 'id' : studentId},
                    type : 'POST',
                    dataType : 'json',
                    success : function(result){
                        if(result.status == 200) {
                            $this.closest('td').find('.badge').removeClass('alert-danger').removeClass('alert-success');
                            $this.closest('td').find('.badge').text(result.updated_status).addClass(result.class);
                        } else {
                            alert('An error occured');
                        }
                    },
                    error: function(result){
                        alert('An error occured');
                    }
                });
            });
        })
    </script>
@endsection
