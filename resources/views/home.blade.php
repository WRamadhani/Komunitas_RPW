@extends('template.app')
<div class="container">
    @section('content')
    <br>
    @if($post->isEmpty())
    @foreach($popular as $item)
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <a href="{{ route('posts.show', $item->title) }}">{{ $item->title }}</a>
                        <br>
                        On&nbsp;<a href="{{ route('comunity.show', $item->name) }}">{{ $item->name }}</a>
                        <br>
                        {{ $item->updated_at }}
                    </div>
                    <div class="col-md-4 text-right">
                        @if($item->user_id == Auth::user()->id)
                        <a class="btn btn-info text-white" href="{{ route('posts.edit',$item->title) }}">Edit</a>
                        <form class="d-inline" onsubmit="return confirm('Delete this post permanently?')" action="{{ route('posts.delete',$item->post_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger text-white">Hapus</button>
                        </form>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset('storage/'.$item->media) }}" alt="" class="img-fluid img-thumbnail">
                            </div>
                            <div class="col-10">
                                <p class="artikel">{{ Str::words($item->content, 30, '...') }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('posts.like',Auth::id()) }}" class="lead text-dark">LIKE</a>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <br>
        </div>
    </div>
    <br>
    @endforeach
    @endif
    @foreach($post as $item)
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <a href="{{ route('posts.show', $item->title) }}">{{ $item->title }}</a>
                        <br>
                        On&nbsp;<a href="{{ route('comunity.show', $item->name) }}">{{ $item->name }}</a>
                        <br>
                        {{ $item->updated_at }}
                    </div>
                    <div class="col-md-4 text-right">
                        @if($item->user_id == Auth::user()->id)
                        <a class="btn btn-info text-white" href="{{ route('posts.edit',$item->title) }}">Edit</a>
                        <form class="d-inline" onsubmit="return confirm('Delete this post permanently?')" action="{{ route('posts.delete',$item->post_id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger text-white">Hapus</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <img src="{{ asset('storage/'.$item->media) }}" alt="" class="img-fluid img-thumbnail">
                    </div>
                    <div class="col-10">
                        <p class="artikel">{{ Str::words($item->content, 30, '...') }}</p>
                    </div>
                </div>
            </div>
            {{-- <div class="card-footer">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('posts.like',Auth::id()) }}" class="lead text-dark">LIKE</a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <br>
    @endforeach
    @endsection
    @section('sidebar')
    <br>
    <div class="row">
        <div class="col-12">
            <div class="tabbable" id="tabs-153735">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" href="#tab1" data-toggle="tab">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="#tab2" data-toggle="tab">New</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        {{-- <h4>Ini Pop</h4> --}}
                        @foreach($popular as $item)
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <a href="{{ route('posts.show', $item->title) }}">{{ $item->title }}</a>&nbsp;by&nbsp;<a href="{{ route('users.show', $item->username) }}">{{ $item->username }}</a>
                                </div>
                                <div class="row">
                                    <a href="{{ route('comunity.show', $item->name) }}">{{ $item->name }}</a>
                                </div>
                                <div class="row">
                                    {{ $item->updated_at }}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/'.$item->media) }}" alt="" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md-8">
                                        <p class="small artikel">{{ Str::words($item->content, 30, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                        <br>
                        @endforeach
                    </div>
                    <div class="tab-pane" id="tab2">
                        {{-- <h4>Ini New</h4> --}}
                        @foreach($newPost as $item)
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <a href="{{ route('posts.show', $item->title) }}">{{ $item->title }}</a>&nbsp;by&nbsp;<a href="{{ route('users.show', $item->username) }}">{{ $item->username }}</a>
                                </div>
                                <div class="row">
                                    <a href="{{ route('comunity.show', $item->name) }}">{{ $item->name }}</a>
                                </div>
                                <div class="row">
                                    {{ $item->updated_at }}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/'.$item->media) }}" alt="" class="img-fluid img-thumbnail">
                                    </div>
                                    <div class="col-md-8">
                                        <p class="small artikel">{{ Str::words($item->content, 30, '...') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            </div>
                        </div>
                        <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">
                OlaWikiWiki
                </h5>
                <div class="card-body">
                    <p class="card-text">
                        &copy;Kelompok 4
                    </p>
                </div>
                <div class="card-footer">
                    2019
                </div>
            </div>
        </div>
    </div>
    <br>
    @endsection
</div>
@section('js')
<script>
$(function() {
    $('p.artikel').each(function(key, value){
        var artikel = value.textContent;
        var ct = artikel.replace(/[[]/g,'<');
        var ct0 = ct.replace(/[\]]/g,'>');
        var ct1 = ct0.replace(/<script>|<\/script>/,':)');
        $(this).html(ct1);
    })
});
</script>
@endsection