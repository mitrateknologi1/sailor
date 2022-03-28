<label for="TextInput" class="form-label">{{$label}} {!!$wajib ?? ''!!}</label>
<input type="{{$type ?? ''}}" id="{{$id ?? ''}}" name="{{$name ?? ''}}" class="form-control {{$class ?? ''}}" value="{{$value ?? ''}}" {{$attribute ?? ''}}>
<span class="text-danger error-text {{$name}}-error"></span>



