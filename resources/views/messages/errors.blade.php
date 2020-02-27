@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Something went wrong!</strong>
        <br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
@else

@endif
