<label class="form-label">{{$label ?? ''}} {!!$wajib ?? ''!!} </label> {!!$button_add ?? ''!!}
<select class="form-select {{$class ?? ''}}" id="{{$id ?? ''}}" aria-hidden="true" {{$attribute ?? ''}} name="{{$name ?? ''}}">
    @if ($class == 'filter')
        <option value="">Semua</option>
    @elseif($class == 'kosong')
        <option value="" selected hidden>- Pilih Salah Satu -</option>
    @else
        <option value="" selected hidden>- Pilih Salah Satu -</option>
    @endif
    {{$options ?? ''}}
</select>
<span class="text-danger error-text {{$name}}-error"></span>
