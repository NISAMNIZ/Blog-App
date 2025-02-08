<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<div class="container my-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid" style="margin-left: 92px;">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" style="background-color: #000000;color: #fff;" aria-current="page" href="{{route('user.register')}}">Register Your Account</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" style="background-color: #1940d6;color: #fff;margin-left: 20px;" aria-current="page" href="{{route('user.login')}}">Login to Your Account</a>
              </li>
            </ul>
            <form class="d-flex" id="searchForm">
              <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success SearchButton" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    <!-- Page Heading -->
    <div class="text-center mb-5">
        <h1 class="display-4">Welcome to Our Blog</h1>
        <p class="text-muted">Discover the latest news, updates, and stories.</p>
    </div>


    @if ($blogs->count())
    <!-- Blog Section -->
    <div class="row">
        <!-- Blog Post 1 -->
        @foreach ($blogs as $blog)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <img src="{{asset("storage/images/".$blog->image)}}" class="card-img-top" alt="Blog Image 1" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ucwords($blog->title)}}</h5>
                    <p class="card-text text-muted">
                       {{$blog->content}}
                    </p>
                    <div class="d-flex justify-content-between mt-auto">
                        <button class="btn btn-outline-success btn-sm LikeBlog" disabled data-id="{{ $blog->id }}" data-liked="{{ $blog->isLike ? 'true' : 'false' }}">
                            <i class="fas fa-thumbs-up"></i>
                            <span class="like-text">{{ 'Like' }}</span>
                            (<span class="like-count">{{ $blog->likes ? $blog->likes->count() : 0 }}</span>)
                        </button>
                </div>
                    <a href="{{route('user.withoutLoginreadMore',$blog->id)}}" class="btn btn-primary mt-auto">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination (Static Example) -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            {{$blogs->links()}}
        </nav>
    </div>
    @else
    <div style="display: flex;align-content:center;justify-content:center">
        <h3>There are no blog posts.</h3>
    </div>
    @endif
</div>
</body>
</html>
