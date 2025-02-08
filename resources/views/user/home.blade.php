@extends('template')
@section('content')
    <div class="container my-5">
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
                    <div class="col-md-4 mb-4" style="height: fit-content;">
                        <div class="card shadow-sm h-100">
                            <img src="{{ asset('storage/images/' . $blog->image) }}" class="card-img-top" alt="Blog Image 1"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ ucwords($blog->title) }}</h5>
                                <p class="card-text text-muted">
                                    {{ $blog->content }}
                                </p>
                                <div class="d-flex justify-content-between mt-auto">
                                    <button class="btn btn-outline-success btn-sm LikeBlog" data-id="{{ $blog->id }}"
                                        data-liked="{{ $blog->isLike ? 'true' : 'false' }}">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span class="like-text">{{ 'Like' }}</span>
                                        (<span class="like-count">{{ $blog->likes ? $blog->likes->count() : 0 }}</span>)
                                    </button>
                                    @if (Auth::user()->id == $blog->user_id)
                                        <button class="btn btn-primary btn-sm EditBlog" data-id="{{ $blog->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger btn-sm DeleteBlog" data-id="{{ $blog->id }}">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    @endif
                                </div>
                                <a href="{{ route('user.readMore', $blog->id) }}"" class="btn btn-primary mt-auto">Read
                                    More</a>
                                <button class="btn btn-outline-secondary mt-auto toggle-comments-btn"
                                    data-blog-id="{{ $blog->id }}">Show Comments</button>
                                <div class="mt-3 comment-section" id="comment-section-{{ $blog->id }}"
                                    style="display: none;">
                                    <h6>Comments <span style="float: right">{{ $blog->comments->count() }}</span></h6>
                                    <div class="comments-list" id="comments-list-{{ $blog->id }}">
                                        @if ($blog->comments)
                                            @foreach ($blog->comments as $comment)
                                                <div class="comment mb-2 p-2 border rounded">
                                                    <strong>{{ $comment->user->name }}</strong>
                                                    <span class="text-muted small"> •
                                                        {{ $comment->created_at->diffForHumans() }}</span>
                                                    <p class="mb-1">{{ $comment->comment }}</p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <!-- Add Comment Form -->
                                    <form class="addComment" data-blog-id="{{ $blog->id }}">
                                        @csrf
                                        <input type="hidden" name=blog_id value={{ $blog->id }} />
                                        <div class="input-group">
                                            <input type="text" name="comment" id ="comment"
                                                class="form-control comment-input" placeholder="Write a comment...">
                                            <button class="btn btn-primary add-comment-btn" type="submit">Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination (Static Example) -->
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    {{ $blogs->links() }}
                </nav>
            </div>
        @else
            <div style="display: flex;align-content:center;justify-content:center">
                <h3>There are no blog posts.</h3>
            </div>
        @endif
    </div>

    <style>
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #343a40;
        }

        .card {
            min-height: 100%;
        }

        .card {
            position: relative;
        }

        .card-text {
            font-size: 0.9rem;
            line-height: 1.5;
            color: #6c757d;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
    <script>
        $(function() {
            $('.toggle-comments-btn').click(function() {
                let blogId = $(this).data('blog-id');
                let commentSection = $('#comment-section-' + blogId);

                if (commentSection.is(':visible')) {
                    commentSection.slideUp();
                    $(this).text('Show Comments');
                } else {
                    commentSection.slideDown();
                    $(this).text('Hide Comments');
                }
            });
            $('.EditBlog').click(function() {
                let id = $(this).data('id');
                window.location.href = "{{ route('user.blog') }}/" + id;
            });
            $('.DeleteBlog').click(function() {
                let id = $(this).data('id');
                $.post("{{ route('user.deleteBlog') }}", {
                    id: id
                }, function() {
                    toastr.success('Blog deleted Successfully ');
                    setTimeout(function() {
                        window.location.href = "{{ route('user.home') }}";
                    });
                }).fail(function(response) {
                    toastr.error('Blog Deletion failed');
                })
            });

            $('.LikeBlog').click(function() {
                let blogId = $(this).data('id'); // Blog ID
                let likeBtn = $(this); // Button reference
                let isLiked = likeBtn.data('liked') === true; // Check if currently liked
                console.log(blogId, likeBtn);


                $.ajax({
                    url: '{{ route('blog.toggle') }}', // Use the named route
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token
                        blog_id: blogId // Pass the blog ID in the payload
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the button text and like count
                            likeBtn.data('liked', response.is_liked);
                            // likeBtn.find('.like-text').text(response.is_liked ? 'Unlike' : 'Like');
                            likeBtn.find('.like-count').text(response.likes_count);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Something went wrong. Please try again.');
                    }
                });
            });

            $('.add-comment-btn').click(function(e) {
                e.preventDefault();

                let form = $(this).closest('.addComment');
                let blogId = $(this).data('blog-id');
                let commentInput = $(this).find('.comment-input');
                let commentValue = form.find('.comment-input').val().trim();
                $('.error-messages').remove();
                $('.comment-input').removeClass('is-invalid');

                $.post("{{ route('user.comment') }}", form.serialize(), function(response) {
                    if (response.success) {
                        let newComment = `
        <div class="comment mb-2 p-2 border rounded">
            <strong>${response.username}</strong>
            <span class="text-muted small"> • Just now</span>
            <p class="mb-1">${response.comment}</p>
        </div>`;

                        // Append the new comment at the top of the comment list
                        $('#comments-list-' + blogId).prepend(newComment);

                        // Clear input field
                        commentInput.val('');
                        toastr.success('commented Successfully ');
                        setTimeout(function() {
                            window.location.href = "{{ route('user.home') }}";
                        }, 800);
                    }
                }).fail(function(response) {
                    let errors = response.responseJSON.errors;
                    let errorContainer = '<div class="error-messages mt-2 alert alert-danger"><ul>';

                    $.each(errors, function(field, messages) {
                        errorContainer += `<li>${messages[0]}</li>`;
                    });

                    errorContainer += '</ul></div>';
                    form.after(errorContainer);
                });
            });
        });
    </script>
@endsection
