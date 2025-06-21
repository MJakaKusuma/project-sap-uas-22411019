@props([
    'action' => '#',
    'method' => 'POST',
    'title' => null,
    'description' => null,
])

@php
  $httpMethod = strtoupper($method);
  $isGetOrPost = in_array($httpMethod, ['GET', 'POST']);
@endphp

<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      @if($title)
        <h4 class="card-title">{{ $title }}</h4>
      @endif

      @if($description)
        <p class="card-description">{{ $description }}</p>
      @endif

      <form action="{{ $action }}" method="{{ $isGetOrPost ? strtolower($httpMethod) : 'post' }}" enctype="multipart/form-data" class="forms-sample">
        @csrf
        @unless($isGetOrPost)
          @method($httpMethod)
        @endunless

        {{ $slot }}

        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
      </form>
    </div>
  </div>
</div>
