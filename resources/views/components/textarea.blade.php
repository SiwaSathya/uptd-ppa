<div>   
    <div class="relative my-2" style="color: black!important;">
        <label for="outlined_error" class="absolute text-sm  duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1
        
        {{ $errors->get($name) ? 'text-red-600 dark:text-red-500' : 'dark:text-white'}}

        ">{{$title}}</label>

        <textarea type="{{$type}}" name="{{$name}}" id="summernote" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 appearance-none dark:text-white
        
        {{ ($errors->has($name)) ? 'dark:border-red-500 border-red-600 dark:focus:border-red-500 focus:outline-none focus:border-red-600' : $another_old_input }} 
        
        {{$attribute}}
        
        focus:ring-0 
        peer" >{{old($name) ? old($name) : $another_old_input }}</textarea>
    </div>
    @if($errors->get($name))
        <ul id="outlined_error_help" class="my-2"><span class="font-medium">
        @foreach($errors->get($name) as $item)
            <li style="color: #dc3545;">{{$item}}</li>
        @endforeach
        </ul>
    @endif
</div>
