@include('layouts.head')

<body>
    @include('layouts.navbar')
    <section id="sidebar">
        <div class="product-image">
            <img src="/images/admin.png" alt="image" />
        </div>
        <div class="product-li">
            <a href="" class="text-danger">Product</a>
        </div>
    </section>
    <section id="content" class="jumbotron p-1">
        <div class="content-left">
            <table class="table table-striped table-bordered shadow">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Article</th>
                        <th>Heading</th>
                        <th>Status</th>
                        <th>Attribute</th>
                        @if (session()->get('user')[0]->role == 1)
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($productList as $product)
                    <tr>
                        <td>{{ ($loop->index) + 1 }}</td>
                        <td> {{ $product->article }} </td>
                        <td> {{ $product->name }} </td>
                        <td> {{ $product->status }} </td>
                        <td>
                            @if($product->data != '')
                            @foreach($product->data as $productD)
                            <b> {{ $productD['key'] ?? '' }} </b> : <span> {{ $productD['value'] ?? '' }} </span><br>
                            @endforeach
                            @endif
                        </td>
                        @if (session()->get('user')[0]->role == 1)
                        <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal{{ $product->id ?? '' }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('product.destroy', [$product->id]) }}" method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    <div id="exampleModal{{ $product->id ?? '' }}" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('product.update', ['product' => $product->id]) }}" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group">
                                            <label for="article">Article</label>
                                            <input type="text" class="form-control" name="article" id="article" value="{{$product->article}}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="select custom-select">
                                                <option value="available">Available</option>
                                                <option value="unavailable">Unavailable</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="hidden" name="data[0][key]" value="Color" />
                                            <input type="text" name="data[0][value]" id="color" class="form-control" value="{{ $product->data[0]['value'] ?? '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="size">Size</label>
                                            <input type="hidden" name="data[1][key]" value="Size" />
                                            <input type="text" name="data[1][value]" id="size" class="form-control" value="{{ $product->data[1]['value'] ?? '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Save" class="btn btn-success btn-block">
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="content-button">
            <button class="button-primary" id="openBtn">Add</button>
        </div>
        <div class="content-right {{count($errors) > 0 ? 'salom' : ''}}" id="modal">
            <div class="card card-body text-white">
                @if (count($errors) > 0)
                @foreach($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops!</strong> {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endforeach
                @endif
                <h5>Add product</h5>
                <div id="closeBtn">
                    <i class="fa-solid fa-xmark fa-x"></i>
                </div>
                <form method="POST" action="{{ route('product.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="article">Article</label>
                        <input type="text" class="form-control" name="article" id="article" value="{{old('article')}}" />
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" />
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="select custom-select">
                            <option value="" selected disabled>Select</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                    </div>
                    <h5 class="my-4">Attribute</h5>
                    <div id="parent">

                    </div>

                    <span id="addNewAttr" class="attr"><i class="fa-solid fa-plus mr-1"></i>Add new attrribute</span>
                    <div class="form-group">
                        <input type="submit" value="Send" class="btn btn-success mt-3 px-5 py-2" />
                    </div>
                </form>
            </div>
        </div>
    </section>
    @include('layouts.script')
    <script>
        const openBtn = document.getElementById("openBtn");
        const closeBtn = document.getElementById("closeBtn");
        const modal = document.getElementById("modal");
        const addNewAttr = document.getElementById("addNewAttr");

        openBtn.addEventListener("click", openModal);
        closeBtn.addEventListener("click", closeModal);
        addNewAttr.addEventListener("click", addAttribute);

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function addAttribute() {
            let div = document.createElement("div");
            div.className = "forms d-flex align-items-center";

            div.innerHTML = `
                <div class="forms1 mb-3">
                  <label for="color">Color</label>
                  <input type="hidden" name="data[0][key]" value="Color" />
                  <input type="text" name="data[0][value]" id="color" />
                </div>
                <div class="forms2 mb-3">
                  <label for="size">Size</label>
                  <input type="hidden" name="data[1][key]" value="Size" />
                  <input type="text" name="data[1][value]" id="size" />
                </div>
                <span onclick="deleteAttr(this)">
                  <i class="fa-solid fa-trash-can mt-4"></i>
                </span>
              </div>
        `;

            let count = document.getElementById("parent").childElementCount;
            if (count >= 1) {
                console.log("Break...");
            } else {
                document.getElementById("parent").appendChild(div);
            }
        }

        function deleteAttr(span) {
            document.getElementById("parent").removeChild(span.parentNode);
        }
    </script>

</body>

</html>