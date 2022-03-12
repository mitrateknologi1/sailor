<label class="form-label">{{$label ?? ''}}</label>
<select class="form-select {{$class ?? ''}}" aria-hidden="true">
    @if ($class == 'filter')
        <option value="">Semua</option>
    @else
        <option value="" selected hidden>- Pilih Salah Satu -</option>
    @endif
    {{ $options }}
</select>