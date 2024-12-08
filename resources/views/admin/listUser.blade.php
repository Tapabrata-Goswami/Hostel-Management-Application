@include('includes.header')

<div class="container-fluid">

<!-- Page Heading -->
<!-- <h1 class="h3 mb-2 text-gray-800">Manager list</h1> -->
<div class="row">
    <div class="col-md-6">

    </div>
    <div class="col-md-6 d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="{{route('addUserView')}}">Add Manager</a>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Contact info</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Name</th>
                        <th>Contact info</th>
                        <th>User Type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @php
                        $count = 1
                    @endphp
                    @foreach ($users as $user)
                    @if(session('user_type') != $user->user_type)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->fname}} {{$user->lname}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            Manager
                        </td>
                        <td>
                            <a href="{{route('deleteUser', $user->id)}}" class="btn btn-danger btn-sm">
                                <span class="text"><i class="fa-solid fa-trash"></i></span>
                            </a>
                        </td>
                    </tr>
                    @php
                        $count ++;
                    @endphp
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

@include('includes.footer')