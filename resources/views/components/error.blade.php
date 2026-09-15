@props ([
    'name' => 'required'
    ])
@error($name)
   <div class="fehler">{{ $message }}</div>  
@enderror