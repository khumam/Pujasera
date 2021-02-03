@extends('layouts.app')

@section('content')

<div class="container py-5" style="background-color: #fff; margin-top: -30px">
    <div class="row">
        <div class="col-12">
            <h6>Selamat datang</h6>
            <p class="lead">Mau jajan apa hari ini?</p>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Cari jajan disekitar anda">
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        @forelse($data as $product)
        <div class="col-6 col-md-4 col-xl-3 detailProduct" data-id="{{ $product->id }}">
            <div class="card">
                <img src="images/{{ $product->pic }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h5 class="card-title" style="font-size: 12px; font-weight: 600">{{ $product->name }}</h5>
                        </div>
                        <div class="col-6 text-right" style="font-size: 12px;">
                            <p>Rp{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p>Tidak ada produk</p>
        </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <img src="" id="detail_pic" class="img-fluid">
                    </div>
                    <div class="col-12 mt-3">
                        <h5 id="detail_name"></h5>
                        <p id="detail_desc"></p>
                        <p class="lead" id="detail_price"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" id="pesanButton">Pesan sekarang</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $('.detailProduct').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '{{ route("detailProduct") }}',
            method: 'POST',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log(data);
                $('#detail_pic').attr('src', 'images/' + data.pic);
                $('#detail_name').html(data.name);
                $('#detail_desc').html(data.desc);
                $('#detail_price').html(data.price);
                $('#detailModal').modal('show');
            },
            error: function(err) {

            }
        });
    })

    $('#pesanButton').on('click', function() {
        window.open('https://wa.me/' + '{{ $contact->contact }}')
    })
</script>
@endsection