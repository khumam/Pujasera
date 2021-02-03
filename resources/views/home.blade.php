@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Katalog produk</div>

                <div class="card-body">
                    <button type="button" class="btn btn-success" id="tambahKatalogButton">Tambah katalog</button>
                    <div class="row mt-5">
                        <div class="col-12">
                            @forelse($data as $product)
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="images/{{ $product->pic }}" class="img-fluid">
                                </div>
                                <div class="col-md-8">
                                    <h6>{{ $product->name }}</h6>
                                    <p>{{ $product->desc }}</p>
                                    <p>Rp{{ number_format($product->price) }}</p>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-warning btn-block editButton" data-id="{{ $product->id }}">Edit</button>
                                    <button class="btn btn-danger btn-block deleteButton" data-id="{{ $product->id }}">Hapus</button>
                                </div>
                                <!-- col-12 -->
                            </div>
                            <hr>
                            @empty
                            <p class="text-center">Tidak ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahKatalogModal" tabindex="-1" aria-labelledby="tambahKatalogModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKatalogModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="dataform" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label for="name">Nama produk</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukan nama produk" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" min="0" name="price" id="price" class="form-control" placeholder="Harga produk" required>
                    </div>
                    <div class="form-group">
                        <label for="discount">Diskon</label>
                        <input type="number" min="0" max="100" name="discount" id="discount" class="form-control" placeholder="Diskon produk" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi</label>
                        <textarea type="text" name="desc" id="desc" class="form-control" placeholder="Deskripsi produk" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pic">Gambar produk</label>
                        <input type="file" name="pic" id="pic" class="form-control" placeholder="Gambar produk" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveButton">Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $('#tambahKatalogButton').on('click', function() {
        $("#dataform")[0].reset();
        $('#tambahKatalogModalLabel').html('Tambah produk')
        $('#tambahKatalogModal').modal('show');
    });

    $('#saveButton').on('click', function() {
        if ($('#id').val() == '') {
            saveData();
        } else {
            editData();
        }
    });

    $('.editButton').on('click', function() {
        $("#dataform")[0].reset();
        $('#id').val($(this).data('id'));

        $.ajax({
            url: '{{ route("detailProduct") }}',
            method: 'POST',
            data: {
                id: $(this).data('id')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $('#name').val(res.name);
                $('#desc').val(res.desc);
                $('#price').val(res.price);
                $('#discount').val(res.discount);
                $('#tambahKatalogModalLabel').html('Tambah produk')
                $('#tambahKatalogModal').modal('show');
            },
            error: function(err) {

            }
        });
    });

    $('.deleteButton').on('click', function() {
        $.ajax({
            url: '{{ route("deleteProduct") }}',
            method: 'POST',
            data: {
                id: $(this).data('id')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                console.log(res);
                window.location.reload();
            },
            error: function(err) {

            }
        });
    })

    function saveData() {
        var data = new FormData();
        var image = $('#pic')[0].files;

        data.append('name', $('#name').val());
        data.append('price', $('#price').val());
        data.append('discount', $('#discount').val());
        data.append('desc', $('#desc').val());
        data.append('pic', image[0]);

        console.log(image, data);

        $.ajax({
            url: '{{ route("createProduct") }}',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                console.log(res);
                window.location.reload();
            },
            error: function(err) {

            }
        });
    }

    function editData() {
        var data = new FormData();
        var image = $('#pic')[0].files;

        if (image.length > 0) {
            data.append('pic', image[0]);
        } else {
            data.append('pic', '');
        }
        data.append('name', $('#name').val());
        data.append('price', $('#price').val());
        data.append('discount', $('#discount').val());
        data.append('desc', $('#desc').val());
        data.append('id', $('#id').val());

        console.log(image, data);

        $.ajax({
            url: '{{ route("editProduct") }}',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                console.log(res);
                window.location.reload();
            },
            error: function(err) {

            }
        });
    }
</script>
@endsection