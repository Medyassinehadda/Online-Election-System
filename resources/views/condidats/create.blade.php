@extends('layout')

@section('content')

    @if (Auth::check())
        @if (Auth::user()->user_type == 'admin')
            <div class="container" style="padding-top: 2%;">
                <form action="{{ route('condidats.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name condidat">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlInput1">age</label>
                        <input type="text" name="age" class="form-control" placeholder="Age">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Details</label>
                        <textarea class="form-control" name="detail" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Cv</label>
                        <input type="file" name="cv" class="form-control">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>You have not acces to this page, Sorry !</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    @else
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>You need to connect first to have access to this page !</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    
@endsection