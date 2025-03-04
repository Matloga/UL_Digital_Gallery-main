<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UL Digital Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="/script/script.js"></script>

    <link href="{{ asset('/css/style.css') }}" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="img/logo.png">
</head>

<style>
    #imagePreview {
        max-width: 100%;
        max-height: 400px;
        border: 1px solid #ccc;
        margin-top: 10px;
    }

    .nav-link.dropdown-toggle {
        position: relative;
        padding-right: 1.5rem;
    }

    .nav-link.dropdown-toggle::after {
        display: none;
    }

    /* Additional styles for the dropdown */
    .dropdown-container .dropdown-menu {
        background-color: #ffffff;
        color: #000000;
    }

    .nav-link.dropdown-toggle i {
        display: inline-block !important;
    }

    .tribute-container {
        font-size: 16px !important; /* Increase font size */
        padding: 5px; /* Add padding for better spacing */
    }

    .tribute-container li {
        padding: 10px; /* Add padding to each suggestion item */
    }

    .tribute-container li.highlight {
        background-color: #f0f0f0; /* Change highlight background color */
    }


    .highlighted-user {
        background-color: #ffff00; /* Yellow background */
        font-weight: bold; /* Bold text */
    }

    .like-btn {
        background-color: #C8AB4D; /* Red background */
        border: none; /* Remove border */
        color: white; /* White text */
        padding: 10px 16px; /* Add some padding */
        text-align: center; /* Center the icon */
        text-decoration: none; /* Remove underline */
        display: inline-block; /* Display as inline-block */
        font-size: 16px; /* Set the font size */
        margin: 4px 2px; /* Add some margin */
        cursor: pointer; /* Change the cursor to a pointer on hover */
        border-radius: 50%; /* Make it a circle */
    }

    .like-btn:hover {
        background-color: #C8AB4D; /* Slightly darker green on hover */
    }

    .unlike-btn {
        background-color: #f44336; /* Red background */
        border: none; /* Remove border */
        color: white; /* White text */
        padding: 10px 16px; /* Add some padding */
        text-align: center; /* Center the icon */
        text-decoration: none; /* Remove underline */
        display: inline-block; /* Display as inline-block */
        font-size: 16px; /* Set the font size */
        margin: 4px 2px; /* Add some margin */
        cursor: pointer; /* Change the cursor to a pointer on hover */
        border-radius: 50%; /* Make it a circle */
    }

    .unlike-btn:hover {
        background-color: #c62828; /* Slightly darker red on hover */
    }

    .spinner-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(198, 170, 76);
        z-index: 9999;
    }

    .spinner-container img {
        justify-content: center;
        text-align: center;

    }

    .spinner-grow {
        margin-top: 20px;
    }


    .highlight {
        background-color: #ffff00; /* Yellow highlight */
    }

    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    .badge-danger {
        color: #fff;
        background-color: #dc3545;
    }


</style>

<body>
<div class="spinner-container">
    <div class="spinner-grow" style="width: 7rem; height: 7rem; color: white;" role="status">
        <span class="sr-only"></span>
        <img src="/img/logo.png" alt="Logo" style="width: 90px;margin: 17px">

    </div>
</div>


<nav class="navbar navbar-expand-lg py-1.5 sticky-top ">
    <div class="container-fluid">

        <div class="navvv">
            <a href="welcome">
                <img src="/img/logo.png" alt="Logo">
            </a>

        </div>


        <form class="form-inline my-2 my-lg-0" action="{{ route('search') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" style="margin-left: 15px;" placeholder="Search here"
                   aria-label="Search" name="query" id="searchInput">
        </form>


        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="welcome">Home</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pictures">Pictures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="videos">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('notifications.index') }}">
                            Notifications
                            @isset($mentionsCount)
                                @if ($mentionsCount > 0)
                                    <span class="badge badge-pill badge-danger">{{ $mentionsCount }}</span>
                                @endif
                            @endisset
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i>
                                <img src="/img/profileicon.png" alt="icon"
                                     style="height: 35px;width: 35px;align-content: center">

                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider"/>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-white" href="news">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="pictures">Pictures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="videos">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="contact">Contact</a>
                    </li>
            </ul>
            <a href="log" class="btn btn-primary">Log in</a>
            @endauth
            </ul>
        </div>
    </div>
</nav>


<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mx-auto" style="margin-top: 25px;">

            <form id="postForm" action="{{ route('post.timeline') }}" method="POST" enctype="multipart/form-data"
                  class="post-to-timeline shadow p-3 mb-3 bg-white rounded" style="margin-top: 20px;">
                @csrf
                <div class="input-group" style="position: relative;">
                    <div id="highlightedContent" class="form-control"
                         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; color: transparent; white-space: pre-wrap; pointer-events: none; z-index: 1;"></div>
                    <textarea class="form-control" id="postContent"
                              style="height: 70px; margin-bottom: 10px; resize: none; background: none; z-index: 2; position: relative;"
                              name="text" placeholder="What's on your mind..."></textarea>
                    <div class="input-group-append p-3">
                        <label for="image-upload" class="btn btn-sm btn-default">
                            <i class="fa fa-camera" style="color: white;"></i>
                            <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;"
                                   onchange="previewImage(this)">
                        </label>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </div>
            </form>

            <div class="mt-1">
                @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error) @endforeach
                        <div class="alert alert-danger"> {{$error}} </div>
                    </div>

                @endif
                @if(session()->has('error'))
                    <div class="alert-danger"> {{session('error')}} </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success"> {{session('success')}} </div>
                @endif
            </div>
            <div class="row" id="image-preview" style="display: none;">
                <div class="col-lg-2 mx-auto">
                    <img id="preview-img" src="#" alt="Preview Image" style="max-width: 100%;max-height: 2000px;">
                </div>
            </div>
        </div>


        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 700px;"> <!-- Set custom max-width -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modal-image" src="#" alt="Preview Image"
                             style="width: 100%; height: auto; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>


<div class="container posts-content">

    @if ($posts->isEmpty())
        <p>No results found.</p>
    @else
        <ul class="list-group">
            @foreach($posts as $post)
                <div class="row">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mb-4 shadow p-3 mb-1 bg-white rounded">

                            <div class="media mb-9" style="display: flex; align-items: center;">
                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                     class="d-block ui-w-40 rounded-circle"
                                     height="50px"
                                     alt="" style="margin-left:15px; flex-shrink: 0;">

                                <div class="media-body ml-3">
                                    <h6 style="margin-left:15px;"> {{ $post->user->name }}</h6>
                                    <div class="text-muted small" style="margin-left:15px;">
                                        <h7>{{ $post->created_at->diffForHumans() }}</h7>
                                    </div>
                                </div>

                                @auth
                                    @if (auth()->user()->id === $post->user_id)
                                        <div class="nav-item dropdown"
                                             style="margin-left: auto; border-radius: 5px; padding: 5px;">

                                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#"
                                               role="button"
                                               data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-left"
                                                 style="background-color: #ffffff; color: #000000;"
                                                 aria-labelledby="navbarDropdown">

                                                <a class="dropdown-item"
                                                   href="{{ route('posts.delete', ['id' => $post->id]) }}">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>

                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                   data-bs-target="#editCaptionModal-{{ $post->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                            </div>

                                        </div>
                                    @endif
                                @endauth
                            </div>

                            <p style="margin-left:15px;margin-top:19px;"> {{ $post->text }}</p>
                            <img src="{{ asset('/image/' . $post->image_path) }}" class="img-fluid"
                                 style="width: 100%;" height="600px" alt="">

                            <div class="card-body"></div>

                            <div>
                                @auth
                                    @if (auth()->user()->likedPictures->contains($post->id))
                                        <form action="{{ route('posts.unlike', $post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="unlike-btn">
                                                <i class="fas fa-thumbs-down"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="like-btn">
                                                <i class="fas fa-thumbs-up"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                <span>{{ $post->likes()->count() }}</span> likes
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Caption Modal -->
                @auth
                    @if (auth()->user()->id === $post->user_id)
                        <div class="modal fade" id="editCaptionModal-{{ $post->id }}" tabindex="-1"
                             aria-labelledby="editCaptionModalLabel-{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCaptionModalLabel-{{ $post->id }}">Edit
                                            Caption</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('posts.updateCaption', $post->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-5">
                                                <label for="caption-{{ $post->id }}" class="form-label">Caption</label>
                                                <textarea type="text" class="form-control" id="caption-{{ $post->id }}"
                                                          name="caption">{{ $post->text }}</textarea>

                                                <img src="{{ asset('/image/' . $post->image_path) }}" class="img-fluid"
                                                     style="width: 100%; margin-top: 10px" height="600px" alt="">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

            @endforeach
        </ul>
    @endif
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="https://unpkg.com/tributejs@5.1.3/dist/tribute.js"></script>


<script>
    window.addEventListener('load', function () {
        document.querySelector('.spinner-container').style.display = 'none';
    });

    function previewImage(input) {
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById('image-preview').style.display = 'block';
            document.getElementById('preview-img').src = e.target.result;

            // Set the modal image source
            document.getElementById('modal-image').src = e.target.result;

            // Open the modal
            var modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modal.show();
        };


        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        let typingTimer; // Timer identifier
        const doneTypingInterval = 500; // Time in milliseconds (0.5 seconds)

        searchInput.addEventListener('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });

        function performSearch() {
            searchForm.submit(); // Submit the form when typing stops
        }
    });


    document.getElementById('postForm').addEventListener('submit', function (event) {
        @guest
        event.preventDefault();
        window.location.href = '{{ route('log') }}';
        @endguest
    });

    const tribute = new Tribute({
        trigger: '@',
        values: function (text, cb) {
            fetch('/api/users?query=' + text).then(res => res.json()).then(data => cb(data.map(user => ({
                key: user.name,
                value: user.name
            }))));
        },
        selectTemplate: function (item) {
            return '@' + item.original.value; // Return the user's name with "@" symbol
        },
        menuItemLimit: 10 // Limit the number of suggestions
    });

    tribute.attach(document.getElementById('postContent'));

    // Synchronize textarea content with the overlay div
    document.getElementById('postContent').addEventListener('input', function () {
        synchronizeHighlighting(this);
    });

    document.getElementById('postContent').addEventListener('tribute-replaced', function (e) {
        synchronizeHighlighting(this);
    });

    // Function to synchronize highlighting
    function synchronizeHighlighting(textarea) {
        const text = textarea.value;
        const highlightedContent = text.replace(/(@\w+)/g, '<span style="background-color: #ffff00;">$1</span>');
        document.getElementById('highlightedContent').innerHTML = highlightedContent.replace(/\n/g, '<br>');
    }

    // Initial synchronization
    synchronizeHighlighting(document.getElementById('postContent'));

    // Add an input event listener to remove the highlighting span if the text changes
    document.getElementById('postContent').addEventListener('input', function () {
        this.innerHTML = this.value; // Remove any HTML and keep only plain text
    });

    // Add an input event listener to remove the highlighting span if the text changes
    document.getElementById('postContent').addEventListener('input', function () {
        const spans = this.querySelectorAll('span');
        spans.forEach(span => {
            const parent = span.parentNode;
            while (span.firstChild) {
                parent.insertBefore(span.firstChild, span);
            }
            parent.removeChild(span);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Get the textarea element
        var textArea = document.getElementById('postContent');

        // Add an event listener for input changes
        textArea.addEventListener('input', function () {
            // Limit the text to 255 characters
            if (this.value.length > 150) {
                this.value = this.value.substring(0, 150);
            }
        });
    });
</script>

</body>

</html>
