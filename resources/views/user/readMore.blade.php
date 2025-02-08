@extends('template')
@section('content')
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
                        <button class="btn btn-outline-success btn-sm LikeBlog" data-id="{{ $blog->id }}" data-liked="{{ $blog->isLike ? 'true' : 'false' }}">
                            <i class="fas fa-thumbs-up"></i> <span class="like-text">Like</span>
                            (<span class="like-count">{{ $blog->likes ? $blog->likes->count() : 0 }}</span>)
                        </button>
                        @if (Auth::id() == $blog->user_id)
                            <a href="{{ route('user.EditBlog', $blog->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('user.deleteBlog', $blog->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                    <a href="{{ route('user.home') }}" class="btn btn-secondary mt-3">Back to Blogs</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $(document).on('click', '.LikeBlog', function () {
    let blogId = $(this).data('id'); // Blog ID
    let likeBtn = $(this); // Button reference
    let isLiked = likeBtn.data('liked') === true; // Check if currently liked
    console.log(blogId,likeBtn);


    $.ajax({
        url: '{{ route("blog.toggle") }}', // Use the named route
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // CSRF token
            blog_id: blogId // Pass the blog ID in the payload
        },
        success: function (response) {
            if (response.success) {
                // Update the button text and like count
                likeBtn.data('liked', response.is_liked);
                // likeBtn.find('.like-text').text(response.is_liked ? 'Unlike' : 'Like');
                likeBtn.find('.like-count').text(response.likes_count);
            } else {
                alert(response.message);
            }
        },
        error: function (xhr) {
            alert('Something went wrong. Please try again.');
        }
    });
});
});
</script>
@endsection
