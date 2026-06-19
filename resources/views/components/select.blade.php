<div class="col-12">
  <h6>{{ $title }}</h6>
  <fieldset class="form-group">
    <select class="form-select" id="basicSelect" name="{{$name}}">

      <!-- old input -->
      @foreach($items as $item)
        @if(old($name) == $item->id)
          <option value="{{$item->id}}">{{$item->label}}</option>
        @endif
      @endforeach

      <!-- input before -->
      @foreach($items as $item)
        @if($another_old_input == $item->id)
          <option value="{{$item->id}}">{{$item->label}}</option>
        @endif
      @endforeach

      <!-- another option select -->
      @foreach($items as $item)
        @if(old($name) != $item->id && $another_old_input != $item->id)
          <option value="{{$item->id}}">{{$item->label}}</option>
        @endif
      @endforeach
    </select>
  </fieldset>
</div>
