@extends('template')
@section('content')
<h4 style="margin-left: 87px">Create A Blog</h4>
<form id="BlogForm" class="BlogForm" enctype="multipart/form-data">
    @csrf
    <div class="form-container row" style="margin-left: 87px">
        <input type="hidden" name="id" value="{{isset($blog) ? $blog->id : ''}}">
    <div class="form-group">
      <label for="exampleInputEmail1">Title</label>
      <input type="text" class="form-control" id="title" name="title" value="{{isset($blog) ? $blog->title : ''}}" placeholder="Enter Title" style="width: 50%;">
    </div>
    <div class="form-group">
        <label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="3">{{isset($blog) ? $blog->content : ''}}</textarea>
      </div>
      <div class="form-group">
        <label for="exampleFormControlFile1">Image</label>
        <input type="file" class="form-control-file" id="image" name="image">
        @if (isset($blog->image))
        <img src="{{asset("storage/images/".$blog->image)}}" class="card-img-top" alt="Blog Image 1" style="height: 110px;width: 173px;; object-fit: cover;">
        @endif
      </div>
    </form>
</div>
    <button type="submit" class="btn btn-primary CreateBlog" style="margin-left: 98px; margin-top: 10px;">Submit</button>

  </form>
  <script>
    $(function(){
        $(".CreateBlog").on("click", function(e) {
            e.preventDefault();
            var editId ={{isset($blog) ? $blog->id : 'null'}}
            let formData = new FormData($('#BlogForm')[0]);
            $('.error-message').remove();
                $('.form-control').removeClass('is-invalid');

            $.ajax({
                url: '{{ route('user.createBlog') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function() {
                if(editId != null){
                    toastr.success("Blog Updated Successfully");
                }else
                    toastr.success("Blog Created Successfully");
                    setTimeout(function() {
                        window.location.href ="{{route('user.home')}}";
                    }, 1000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, jqXHR.responseJSON);

                let errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                        let inputField = $('#' + field);
                        inputField.addClass('is-invalid');
                        inputField.after('<span class="text-danger error-message">' + messages[0] + '</span>');
                    });
                }
    });
});
    });
    </script>
  @endsection
