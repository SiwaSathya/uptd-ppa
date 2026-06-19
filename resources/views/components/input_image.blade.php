<div class="mb-3">
    <label for="formFile" class="form-label">{{$title}}</label>
    <!-- preview gambar-start -->
    <div>
        <img loading="lazy" src="{{ old($name) ? old($name) : $another_old_input }}" alt="" class="img-{{$name}} w-full" style="width: 100%;max-width:500px">
    </div>
    <!-- preview gambar-end -->
    <div>
        <input class="form-control {{ ($errors->get($name)) ? 'is-invalid' : '' }}" type="file" id="{{$name}}" onchange="previewImg(`{{'#' . $name}}`,`{{'.img-' . $name}}`);" name="{{$name}}">
        
        @if($errors->get($name))
        <div class="invalid-feedback">
            <i class="bx bx-radio-circle"></i>
            <ul>
                @foreach($errors->get($name) as $item)
                    <li>{{$item}}</li>
                @endforeach
            </ul>
            </div>
        @endif
    </div>
</div>