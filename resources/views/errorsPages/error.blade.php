@extends('layouts.app')
@section('filsAriane')
    <li class="breadcrumb-item"><a href="#">Error</a></li>
@endsection
@section('content')
<div class="container">
    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-danger">Ouups!!</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
          <p>
            We will work on fixing that right away.
            Meanwhile, you may <a href="{{route('projects.index')}}">return to dashboard</a> or try using the search form.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-danger"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
      </div>
      <!-- /.error-page -->

    </section>
    <!-- /.content -->
  </div>
@endsection