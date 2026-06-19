<div>
  <label for="invalid-state">{{$title}}</label>
    <input type="{{$type}}" class="form-control {{ ($errors->get($error_name)) ? 'is-invalid' : '' }}" id="invalid-state" placeholder="fill here..."
    value="{{old($error_name, '') ? old($error_name, '') : $another_old_input }}" {{$attribute}} name="{{$name}}" />
  @if($errors->get($error_name))
    <div class="invalid-feedback">
      <i class="bx bx-radio-circle"></i>
      <ul>
        @foreach($errors->get($error_name) as $item)
            <li>{{$item}}</li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
