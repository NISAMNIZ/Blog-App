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
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <img src="{{ asset('storage/images/' . $blog->image) }}" class="card-img-top" alt="Blog Image" style="height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h2 class="card-title">{{ ucwords($blog->title) }}</h2>
                    @if ($blog->user)
                    <p class="text-muted">By {{ $blog->user->name }} | {{ $blog->created_at->format('M d, Y') }}</p>
                    @endif
                    <hr>
                    <p class="card-text">{{ $blog->content }}</p>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-success btn-sm LikeBlog" disabled data-id="{{ $blog->id }}" data-liked="{{ $blog->isLike ? 'true' : 'false' }}">
                            <i class="fas fa-thumbs-up"></i> <span class="like-text">Like</span>
                            (<span class="like-count">{{ $blog->likes ? $blog->likes->count() : 0 }}</span>)
                        </button>
                    </div>
                    <a href="{{ route('user.withoutLoginBlog') }}" class="btn btn-secondary mt-3">Back to Blogs</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

